<?php

namespace Projects\Hq\Controllers\API\Setting;

use Hanafalah\ModulePayment\Contracts\Schemas\PaymentMethod;
use Projects\Hq\Controllers\API\ApiController;
use Projects\Hq\Requests\API\Setting\PaymentMethod\{
    ViewRequest, StoreRequest, DeleteRequest
};

class PaymentMethodController extends ApiController{
    public function __construct(
        protected PaymentMethod $__schema
    ){
        parent::__construct();
    }

    public function index(ViewRequest $request){
        return $this->__schema->viewPaymentMethodList();
    }

    public function store(StoreRequest $request){
        return $this->__schema->storePaymentMethod();
    }

    public function destroy(DeleteRequest $request){
        return $this->__schema->deletePaymentMethod();
    }
}