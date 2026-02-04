<?php

namespace Projects\Hq\Controllers\API\ProductService\Submission;

use Projects\Hq\Controllers\API\Submission\EnvironmentController;
use Projects\Hq\Requests\API\ProductService\Submission\{
    ViewRequest, ShowRequest, StoreRequest, DeleteRequest
};

class SubmissionController extends EnvironmentController{
    protected function commonConditional($query){
        parent::commonConditional($query);
        $query->whereHasMorph('reference',['Submission'], function ($query){
            $query->where('props->flag','ADDITIONAL');
        });
    }

    public function index(ViewRequest $request){
        return $this->getPosTransactionPaginate();
    }

    public function show(ShowRequest $request){
        return $this->showPosTransaction();
    }

    public function store(StoreRequest $request){
        $this->userAttempt();
        $user = $this->global_user;

        $amount = 0;
        $workspace = $this->WorkspaceModel()->with('license')->findOrFail(request()->product_service_id);
        $license = $workspace->license;
        $expired_at = $license->expired_at;
        $expired_at = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $expired_at);
        $days_until_expiry = (int) now()->diffInDays($expired_at, false);

        if (isset(request()->transaction_items)){
            $transaction_items = request()->transaction_items;
            foreach ($transaction_items as &$transaction_item) {
                $transaction_item['item_type'] = 'ProductItem';
                $product_item = $this->ProductItemModel()->findOrFail($transaction_item['item_id']);
                $transaction_item['name'] = $product_item->name;
                $dynamic_forms = $transaction_item['dynamic_forms'] ?? [];
                foreach ($dynamic_forms as $dynamic_form) {
                    switch ($dynamic_form['key']) {
                        case 'medic_service_id': $qty = count($dynamic_form['value'] ?? []);break;
                        case 'user_count': $qty = $dynamic_form['value'] ?? 1;break;
                    }
                }
                $qty ??= 1;
                $total_price = $product_item->price * $qty;
                if ($days_until_expiry > 0) {
                    $debt_price = ($total_price / 365) * $days_until_expiry;
                    $note = "(Prorate {$days_until_expiry} hari sampai {$expired_at->format('d M Y')})";
                } else {
                    $debt_price = $total_price;
                    $note = "";
                }
                $debt_price = (int) ceil($debt_price);
                $discount = $total_price - $debt_price;
                $payment_detail = $transaction_item['payment_detail'] ?? [
                    'id' => null,
                    'payment_summary_id'  => null,
                    'transaction_item_id' => null,
                    'qty'        => $qty ?? 1,
                    'price'      => $product_item->price,
                    'amount'     => $total_price,
                    'debt'       => $debt_price,
                    'discount'   => $discount,
                    'cogs'       => 0,
                    'note'       => $note
                ];
                $amount += $product_item->price * $qty;
                $transaction_item['payment_detail'] = $payment_detail;
            }
            request()->merge(['transaction_items' => $transaction_items]);
        }

        if (!isset(request()->submission)){
            $submission = [
                'id' => null,
                'name' => 'Penambahan Fitur',
                'reference_type' => 'Workspace',
                'reference_id' => (string) $workspace->getKey(),
                'flag' => 'ADDITIONAL',
                'payment_summary' => [
                    'id' => null,
                    'name'           =>  trim('Total Tagihan Pembelian Produk Tambahan'),
                    'reference_type' => 'Submission'
                ],

            ];
            request()->merge(['reference' => $submission]);
        }

        if (!isset(request()->consument)){
            $consument = [
                'id'             => null,
                'name'           => $user->name,
                'phone'          => $user->phone,
                'reference_type' => $user->getMorphClass(),
                'reference_id'   => (string) $user->getKey()
            ];
            request()->merge(['consument' => $consument]);
        }

        if ($days_until_expiry > 0) {
            $debt = ($amount / 365) * $days_until_expiry;
            $note = "(Prorate {$days_until_expiry} hari sampai {$expired_at->format('d M Y')})";
        } else {
            $debt = $amount;
            $note = "";
        }
        $debt = (int) ceil($debt);
        $discount = $amount - $debt;

        $name = request()->reference['name'];
        request()->merge([
            'name' => $name ?? 'Penambahan Produk',
            'billing' => [
                'author_type' => $user->getMorphClass(),
                'author_id'   => $user->getKey(),
                'debt'        => $debt,
                'amount'      => $amount,
                'discount'    => $discount,
                'note'        => $note,
                'reporting' => false,
                'invoices'    => [
                    [
                        'id' => null,
                        'reporting' => false,
                        'author_type' => 'User',
                        'author_id'   => $user->getKey(),
                        'payer_type' => 'User',
                        'payer_id'   => $user->getKey(),
                        'payment_history' => [
                            'id' => null,
                            'discount' => 0,
                            'form' => [
                                'payment_summaries' => []
                            ]
                        ]   
                    ]
                ]
            ]
        ]);
        return $this->storePosTransaction();
    }

    public function delete(DeleteRequest $request){
        return $this->deletePosTransaction();
    }
}