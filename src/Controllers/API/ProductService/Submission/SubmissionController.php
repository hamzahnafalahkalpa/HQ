<?php

namespace Projects\Hq\Controllers\API\Transaction\Submission;

use Projects\Hq\Requests\API\Transaction\Submission\{
    ViewRequest, ShowRequest, StoreRequest, DeleteRequest
};

class SubmissionController extends EnvironmentController{
    protected function commonRequest(){
        parent::commonRequest();
        $this->userAttempt();
        $billing = request()?->billing;
        if (isset($billing)){
            $billing['author_type']  ??= $this->global_user->getMorphClass();   
            $billing['author_id']    ??= $this->global_user->getKey();   
        }
        request()->merge([
            'search_reference_type' => ['Submission'],
            'billing'               => $billing ?? null
        ]);
    }

    public function index(ViewRequest $request){
        return $this->getPosTransactionPaginate();
    }

    public function show(ShowRequest $request){
        return $this->showPosTransaction();
    }

    public function store(StoreRequest $request){
        $user = $this->global_user;
        if (!isset(request()->submission)){
            $submission = [
                'id' => null,
                'name' => 'Registration',
                'payment_summary' => [
                    'id' => null,
                    'name'           =>  trim('Total Tagihan '.($user->name ?? '')),
                    'reference_type' => 'Submission'
                ]
            ];
            request()->merge(['reference' => $submission]);
        }

        if (!isset(request()->consument)){
            $consument = [
                'id' => null,
                'name' => $user->name,
                'phone' => $user->phone,
                'reference_type' => $user->getMorphClass(),
                'reference_id' => $user->getKey()
            ];
            request()->merge(['consument' => $consument]);
        }

        if (isset(request()->transaction_item)){
            $transaction_item = request()->transaction_item;
            $service = $this->ServiceModel()->findOrFail($transaction_item['item_id']);
            $payment_detail = $transaction_item['payment_detail'] ?? [
                'id' => null,
                'payment_summary_id'  => null,
                'transaction_item_id' => null,
                'qty'        => 1,
                'price'      => $service->price,
                'amount'     => $service->price,
                'debt'       => $service->price,
                'cogs'       => $service->cogs ?? 0
            ];
            $transaction_item['payment_detail'] = $payment_detail;
            request()->merge(['transaction_item' => $transaction_item]);
        }
        $name = request()->name;
        request()->merge([
            'name' => $name ?? 'Registration Submission'
        ]);
        return $this->storePosTransaction();
    }

    public function delete(DeleteRequest $request){
        return $this->deletePosTransaction();
    }
}