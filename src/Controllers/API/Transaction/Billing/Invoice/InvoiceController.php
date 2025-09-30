<?php

namespace Projects\Hq\Controllers\API\Transaction\Billing\Invoice;

use Projects\Hq\Requests\API\Transaction\Invoice\{
    ViewRequest, ShowRequest
};
use Projects\Hq\Controllers\API\Transaction\Invoice\EnvironmentController;

class InvoiceController extends EnvironmentController{
    public function index(ViewRequest $request){
        return $this->getInvoiceList();
    }

    public function show(ShowRequest $request){
        return $this->showInvoice();
    }
}