<?php

namespace Projects\Hq\Controllers\API\Billing;

use Projects\Hq\Requests\API\Billing\{
    ViewRequest, ShowRequest, StoreRequest, UpdateRequest
};

class BillingController extends EnvironmentController{
    protected function commonConditional($query){
    }

    protected function commonRequest(){
        parent::commonRequest();
        request()->merge([
            'search_author_type' => 'User',
            'search_author_id'   => $this->global_user->getKey()
        ]);
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