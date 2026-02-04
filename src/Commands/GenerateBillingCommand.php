<?php

namespace Projects\Hq\Commands;

use Hanafalah\LaravelSupport\Concerns\Support\HasRequestData;
use Illuminate\Support\Facades\Log;
use Xendit\Configuration;

class GenerateBillingCommand extends EnvironmentCommand
{
    use HasRequestData;

    protected $signature = 'hq:generate-billing';

    public function handle(): void
    {
        $this->comment('Generating billings...');
        Log::channel('generate_billing')->info('Generating billings...');

        try {
            Configuration::setXenditKey(env('XENDIT_SECRET_KEY'));

            $licenses = app(config('database.models.License'))
                ->with('reference')
                ->where('status', 'ACTIVE')
                ->where('flag','WORKSPACE_LICENSE')
                ->whereDate('due_date', '<', now()->toDateString())
                ->where('props->is_billing_generated', true)
                ->update([
                    'status' => 'EXPIRED'
                ]);
            $this->comment('Set Expired licenses...');
            Log::channel('generate_billing')->info('Set Expired licenses...');

            $licenses = app(config('database.models.License'))
                ->with('reference')
                ->where('status', 'ACTIVE')
                ->where('flag','WORKSPACE_LICENSE')
                ->whereDate('expired_at', '=', now()->addDays(5)->toDateString())
                ->where('props->is_billing_generated', false)
                ->get();
            $this->comment('Renewal Billing For '.count($licenses).'...');
            Log::channel('generate_billing')->info('Renewal Billing For '.count($licenses).'...');
            foreach ($licenses as $license) {
                $this->comment('Renewal Billing For '.$license->license_key.'...');
                Log::channel('generate_billing')->info('Renewal Billing For '.$license->license_key.'...');

                $license->load(['reference' => function($query){
                    $query->with([
                        'owner','installedProductItems' => function($query){
                            $query->where('props->prop_product_item->flag','Add');
                        }
                    ]);
                }]);
                $workspace = $license->reference;
                $owner = $workspace->owner;

                $pos_transaction_data = [
                    'id' => null,
                    'reference_type' => 'Submission',
                    'reference' => [
                        'id' => null,
                        'name' => 'RENEWAL LICENSE '.$workspace->name,
                        'flag' => 'RENEWAL',
                        'payment_summary' => [
                            'id' => null,
                            'name'           =>  'Workspace License Renewal',
                            'reference_type' => 'Submission'
                        ]
                    ],
                    'transaction_items' => [],
                    'consument' => [
                        'id' => null,
                        'name' => $owner->name,
                        'phone' => $owner->phone,
                        'reference_type' => $owner->getMorphClass(),
                        'reference_id' => (string) $owner->getKey()
                    ],
                    'billing' => [
                        
                    ]
                ];
                $installed_product_items = $workspace->installedProductItems;
                $transaction_items = &$pos_transaction_data['transaction_items'];
                $amount = 0;
                $debt = 0;
                $discount = 0;
                foreach ($installed_product_items as $installed_product_item) {
                    $transaction_items[] = [
                        'id' => null,
                        'item_id' => $installed_product_item->product_item_id,
                        'item_type' => 'ProductItem',
                        'name' => $installed_product_item->prop_product_item['name'],
                        'payment_detail' => [
                            'id' => null,
                            'qty'        => $installed_product_item->qty,
                            'price'      => $installed_product_item->price,
                            'amount'     => $amount_calc = $installed_product_item->actual_price * $installed_product_item->qty,
                            'discount'   => $discount_calc = $installed_product_item->discount,
                            'debt'       => $debt_price_calc = $amount_calc - $discount_calc,
                            'cogs'       => 0
                        ]
                    ];
                    $amount   += $amount_calc;
                    $debt     += $debt_price_calc;
                    $discount += $discount_calc;
                }

                $product_data = $workspace->prop_product;
                $transaction_items[] = [
                    'id' => null,
                    'item_id' => $workspace->product_id,
                    'item_type' => 'Product',
                    'name' => 'Workspace License Renewal Fee',
                    'payment_detail' => [
                        'id' => null,
                        'qty'        => 1,
                        'price'      => $product_data['price'],
                        'amount'     => $amount_calc = $product_data['price'],
                        'discount'   => $discount_calc = $amount_calc * (($product_data['discount'] ?? 0)/100),
                        'debt'       => $debt_price_calc = $product_data['actual_price'],
                        'cogs'       => 0
                    ]
                ];
                $amount   += $amount_calc;
                $debt     += $debt_price_calc;
                $discount += $discount_calc;

                $pos_transaction_data['billing'] = [
                    'debt'        => $debt,
                    'amount'      => $amount,
                    'discount'    => $discount,
                    'reporting' => false,
                    'author_type' => $owner->getMorphClass(),
                    'author_id'   => $owner->getKey(),
                    'invoices'    => [
                        [
                            'id' => null,
                            'reporting' => false,
                            'payer_type' => $owner->getMorphClass(),
                            'payer_id'   => $owner->getKey(),
                            'payment_history' => [
                                'id' => null,
                                'discount' => 0,
                                'form' => [
                                    'payment_summaries' => []
                                ]
                            ]   
                        ]
                    ]
                ];
                app(config('app.contracts.PosTransaction'))->prepareStorePosTransaction(
                    $this->requestDTO(
                        config('app.contracts.PosTransactionData'),
                        $pos_transaction_data
                    )
                );

                $tenant = $workspace->tenant;
                $license->is_billing_generated = true;
                $license->billing_generated_at = now();
                $license->due_date = now()->addDays(8);
                $days_remaining = now()->diffInDays($license->expired_at, false);
                $extra_days = $days_remaining > 0 ? $days_remaining : 0;
                
                if ($tenant->recurring_type === 'MONTHLY') {
                    $next_billing_date = now()->addMonth()->addDays($extra_days);
                } elseif ($tenant->recurring_type === 'YEARLY') {
                    $next_billing_date = now()->addYear()->addDays($extra_days);
                } else {
                    $next_billing_date = now()->addDays($extra_days);
                }
                $license->next_expired_at = $next_billing_date;
                $license->save();
                $this->comment('Next Expired For '.$license->license_key.' is '.$next_billing_date.'...');
                Log::channel('generate_billing')->info('Next Expired For '.$license->license_key.' is '.$next_billing_date.'...');
            }
            $this->info('✔️  Billings generated successfully.');        
        } catch (\Throwable $th) {
            Log::channel('generate_billing')->error($th->getMessage());
            //throw $th;
        }
    }
}