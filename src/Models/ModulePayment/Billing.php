<?php

namespace Projects\Hq\Models\ModulePayment;

use Hanafalah\ModulePayment\Models\Transaction\Billing as TransactionBilling;
use Projects\Hq\Resources\ModuleBilling\{
    ViewBilling,ShowBilling
};

class Billing extends TransactionBilling
{
    public function getShowResource(){
        return ShowBilling::class;
    }

    public function getViewResource(){
        return ViewBilling::class;
    }

    public function hasTransaction(){return $this->belongsToModel("PosTransaction",'has_transaction_id');}
}
