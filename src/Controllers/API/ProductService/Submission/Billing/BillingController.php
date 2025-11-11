<?php

namespace Projects\Hq\Controllers\API\Transaction\Submission\Billing;

use Projects\Hq\Controllers\API\Transaction\Billing\EnvironmentController;
use Projects\Hq\Requests\API\Transaction\Submission\Billing\{
    ViewRequest, ShowRequest, StoreRequest, DeleteRequest
};

class BillingController extends EnvironmentController{
    protected function commonRequest()
    {
        request()->merge([
            'has_transaction_id' => request()->transaction_id,
            'author_type'  => request()->author_type ?? $this->global_user->getMorphClass(),
            'author_id'    => request()->author_id ?? $this->global_user->getKey()
        ]);
    }

    protected function commonConditional($query){
        $query->whereNull('reported_at');
    }

    public function index(ViewRequest $request){
        return $this->getBillingList();
    }

    public function show(ShowRequest $request){
        return $this->showBilling();
    }

    public function store(StoreRequest $request){
        return $this->storeBilling();
    }

    public function delete(DeleteRequest $request){
        return $this->deleteBilling();
    }
}