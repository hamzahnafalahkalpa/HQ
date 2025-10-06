<?php

namespace Projects\Hq\Controllers\API\Transaction\Submission\Billing\Invoice;

use Projects\Hq\Requests\API\Transaction\Submission\Billing\Invoice\{
    ViewRequest, ShowRequest, StoreRequest, DeleteRequest
};
use Projects\Hq\Controllers\API\Transaction\Invoice\EnvironmentController;

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