<?php

namespace Projects\Hq\Controllers\API\Billing;

use Projects\Hq\Requests\API\Billing\{
    ViewRequest, ShowRequest, StoreRequest, UpdateRequest
};

class BillingController extends EnvironmentController{
    protected function commonConditional($query){
    }

    public function index(ViewRequest $request){
        return $this->getBillingPaginate();
    }

    public function show(ShowRequest $request){
        return $this->showBilling();
    }

    public function store(StoreRequest $request){
        return $this->storeBilling();
    }
}