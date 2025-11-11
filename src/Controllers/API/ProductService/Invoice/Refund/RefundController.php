<?php

namespace Projects\Hq\Controllers\API\Transaction\Invoice\Refund;

use Projects\Hq\Requests\API\Transaction\Invoice\Refund\{
    ViewRequest, ShowRequest, StoreRequest, DeleteRequest
};
use Projects\Hq\Controllers\API\Transaction\Refund\EnvironmentController;


class RefundController extends EnvironmentController{
    public function index(ViewRequest $request){
        return $this->getRefundPaginate();
    }

    public function show(ShowRequest $request){
        return $this->showRefund();
    }

    public function store(StoreRequest $request){
        return $this->storeRefund();
    }

    public function destroy(DeleteRequest $request){
        return $this->deleteRefund();
    }
}