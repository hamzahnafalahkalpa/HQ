<?php

namespace Projects\HQ\Controllers\API\Transaction\PointOfSale\Billing\Invoice;

use Projects\HQ\Requests\API\Transaction\PointOfSale\Billing\Invoice\{
    ViewRequest, ShowRequest, StoreRequest, DeleteRequest
};
use Projects\HQ\Controllers\API\Transaction\Invoice\EnvironmentController;

class InvoiceController extends EnvironmentController{
    protected function commonConditional($query){
        $query->whereNull('reported_at');
    }

    public function index(ViewRequest $request){
        return $this->getInvoiceList();
    }

    public function show(ShowRequest $request){
        return $this->showInvoice();
    }

    public function store(StoreRequest $request){
        return $this->storeInvoice();
    }

    public function destroy(DeleteRequest $request){
        return $this->deleteInvoice();
    }
}