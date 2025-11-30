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
                $payment_detail = $transaction_item['payment_detail'] ?? [
                    'id' => null,
                    'payment_summary_id'  => null,
                    'transaction_item_id' => null,
                    'qty'        => $qty ?? 1,
                    'price'      => $product_item->price,
                    'amount'     => $total_price = $product_item->price * $qty,
                    'debt'       => $total_price,
                    'cogs'       => 0
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
                'reference_type' => 'Submission',
                'reference_id' => request()->product_service_id,
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
                'reference_id'   => $user->getKey()
            ];
            request()->merge(['consument' => $consument]);
        }

        $name = request()->reference['name'];
        request()->merge([
            'name' => $name ?? 'Penambahan Produk',
            'billing' => [
                'author_type' => $user->getMorphClass(),
                'author_id'   => $user->getKey(),
                'debt'        => $amount,
                'amount'      => $amount
            ]
        ]);
        return $this->storePosTransaction();
    }

    public function delete(DeleteRequest $request){
        return $this->deletePosTransaction();
    }
}