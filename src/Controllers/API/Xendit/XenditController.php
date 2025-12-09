<?php

namespace Projects\Hq\Controllers\API\Xendit;

use Projects\Hq\Controllers\API\ApiController;
use Illuminate\Http\Request;

class XenditController extends ApiController{
    public function store(Request $request){
        \Log::channel('xendit')->info('HQ: Xendit paid callback', [
            'payload' => request()->all(),
            'headers' => request()->headers->all()
        ]);
        $data = request()->all();
        if (isset($data['external_id'])){
            try {
                $data = $this->transaction(function () use ($data) {
                    $billing = $this->BillingModel()->with('hasTransaction.consument')->findOrFail($data['external_id']);
                    $transaction = $billing->hasTransaction;
                    $transaction->load(['transactionItems','paymentSummary.paymentDetails']);
                    $payment_summary = $transaction->paymentSummary;
                    $reference = $payment_summary->reference;
                    switch ($reference->flag) {
                        case 'MAIN':
                            $workspace = $reference->workspace;
                            if (isset($workspace)){
                                $workspace->status = 'ACTIVE';
                                $workspace->save();
                                $workspace->load(['product','submission']);
                                app(config('app.contracts.Workspace'))->generateTenant($this->requestDTO(
                                    config('app.contracts.WorkspaceData'),
                                    [
                                        'name' => $workspace->name,
                                        'workspace_id' => $workspace->getKey(),
                                        'workspace_model' => $workspace,
                                        'product_model' => $workspace->product
                                    ]
                                ));
                            }
                        break;
                        case 'ADDITIONAL':
                            $workspace = $reference->reference;
                            $tenant = $workspace->tenant;
                            if (isset($workspace)){
                                $transactionItems = $transaction->transactionItems;
                                $restrictionModel = $this->RestrictionFeatureModel();
                                foreach ($transactionItems as $transactionItem) {
                                    $dynamic_forms = $transactionItem->dynamic_forms ?? [];
                                    foreach ($dynamic_forms as $dynamic_form) {
                                        switch ($dynamic_form['key']) {
                                            case 'medic_service_id': 
                                                $license = $workspace->license;
                                                $license->is_billing_generated = false;
                                                $license->save();
                                                foreach ($dynamic_form['value'] as $medic_service_id) {
                                                    $restriction = $restrictionModel->where('reference_type','Tenant')
                                                        ->where('reference_id',$tenant->getKey())
                                                        ->where('model_type','MedicService')
                                                        ->where('model_id',$medic_service_id)
                                                        ->first();
                                                    if (isset($restriction)){
                                                        $model = $restriction->model;
                                                        $model->is_restricted = false;
                                                        $model->save();
                                                        $restriction->delete();
                                                    }
                                                }
                                            break;
                                            case 'user_count': 
                                                $qty = $dynamic_form['value'] ?? 1;
                                                $workspace_license = $workspace->license;
                                                for ($i=0; $i < $qty; $i++) { 
                                                    app(config('app.contracts.License'))->prepareStoreLicense(
                                                        $this->requestDTO(config('app.contracts.LicenseData'), [
                                                            'reference_type' => $workspace->getMorphClass(),
                                                            'reference_id'   => $workspace->getKey(),
                                                            'expired_at' => $workspace_license->expired_at,
                                                            'billing_generated_at' => now()->toDateTimeString(),
                                                            'is_billing_generated' => false,
                                                            'status' => 'ACTIVE',
                                                            'recurring_type' => $workspace_license->recurring_type,
                                                            'flag' => 'USER_LICENSE'
                                                        ])
                                                    );
                                                }
                                            break;
                                        }
                                    }
                                }

                                $this->InstalledProductItemModel()
                                    ->where('reference_type',$workspace->getMorphClass())
                                    ->where('reference_id',$workspace->getKey())
                                    ->where('status','DRAFT')
                                    ->update([
                                        'status' => 'ACTIVE'
                                    ]);
                            }
                        break;
                        case 'RENEWAL':
                            $workspace = $reference->workspace;
                            if (isset($workspace)){
                                $workspace->status = 'ACTIVE';
                                $workspace->save();
                                $license = $workspace->license;
                                $license->expired_at = $license->next_expired_at;
                                $license->next_expired_at = null;
                                $license->is_billing_generated = false;
                                $license->save();
                            }
                    }
                    app(config('app.contracts.Billing'))->prepareStoreBilling(
                        $this->requestDTO(config('app.contracts.BillingData'),[
                            "id" => $billing->getKey(),
                            "reporting" => true, 
                            'xendit' => $data,
                            'has_transaction_id' => $transaction->getKey(),
                            'author_type' => $billing->author_type,
                            'author_id' => $billing->author_id,
                            'debt' => 0,
                            'money_paid' => ($billing->money_paid ?? 0) + $payment_summary->debt,
                            "invoices" => call_user_func(function() use ($payment_summary, $billing, $transaction){
                                $billing->load('invoices.paymentHistory');
                                $invoices = [];
                                foreach ($billing->invoices as $invoice) {
                                    $payment_history = $invoice->paymentHistory;
                                    $invoices[] = [
                                        "id" => $invoice->getKey(),
                                        "payer_id"   => $transaction->consument->getKey(), 
                                        "payer_type" => "Consument", 
                                        "reporting" => true,
                                        "payment_history" => [
                                            'id' => $payment_history->getKey(),
                                            'discount' => $payment_history->discount,
                                            'form' => $payment_history->form
                                        ],
                                        "split_payments" => [
                                            [
                                                "id"=> null,
                                                "money_paid" => $payment_summary->debt, //nullable
                                                // "payment_method_id" => $payment_method->getKey(),
                                                // 'payment_method_model' => $payment_method //required, GET FROM AUTOLIST - PAYMENT METHOD LIST                
                                            ]
                                        ]
                                    ];
                                }
                                return $invoices;
                            })
                        ])
                    );
                    // app(config('app.contracts.Billing'))->prepareStoreBilling(
                    //     $this->requestDTO(config('app.contracts.BillingData'),[
                    //         "id" => $billing->getKey(),
                    //         "reporting" => true, 
                    //         'xendit' => $data,
                    //         'has_transaction_id' => $transaction->getKey(),
                    //         'author_type' => $billing->author_type,
                    //         'author_id' => $billing->author_id,
                    //         'debt' => 0,
                    //         "invoices" => [
                    //             [
                    //                 "id"         => null,                
                    //                 "payer_id"   => $transaction->consument->getKey(), 
                    //                 "payer_type" => "Consument", 
                    //                 "reporting" => true,
                    //                 "payment_history" => [
                    //                     "id" => null,
                    //                     "discount" => 0,
                    //                     "form" => [ //THIS FIELD USING ONLY FOR ARTIFICIAL DATA, WILL REMOVE WHEN DATA SETTLED
                    //                         "payment_summaries" => [
                    //                             //YOU CAN USE PAYMENT SUMMARY AND PAYMENT DETAIL RESPONSE WHEN SHOW POS TRANSACTION
                    //                             [
                    //                                 "id" => $payment_summary->getKey(),
                    //                                 "payment_details" => $payment_summary->paymentDetails->map(function($pd){
                    //                                     return ["id" => $pd->getKey()];
                    //                                 })->toArray()
                    //                             ]
                    //                         ]
                    //                     ]
                    //                 ],
                    //                 "split_payments" => [
                    //                     [
                    //                         "id"=> null,
                    //                         "money_paid" => $payment_summary->amount, //nullable
                    //                         "payment_method_id" => $payment_method->getKey(),
                    //                         'payment_method_model' => $payment_method //required, GET FROM AUTOLIST - PAYMENT METHOD LIST                
                    //                     ]
                    //                 ]
                    //             ]
                    //         ]
                    //     ])
                    // );
                    return $data;
                });
            } catch (\Throwable $th) {
                dd($th->getMessage());
                throw $th;
            }
        }
        return response()->json([
            'message' => 'Received',
            'payload' => request()->all(),
            'headers' => request()->headers->all(),
            'response' => $data
        ]);
    }
}