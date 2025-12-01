<?php

namespace Projects\Hq\Models\ModulePayment;

use Hanafalah\ModulePayment\Models\Transaction\Billing as TransactionBilling;
use Projects\Hq\Resources\ModuleBilling\{
    ViewBilling,ShowBilling
};

class Billing extends TransactionBilling
{
    public function viewUsingRelation(): array{
        return ['hasTransaction','invoice.paymentHistory'];
    }

    public function showUsingRelation(): array{
        return [
            'hasTransaction',
            'invoice' => function($query){
                return $query->with([
                    'paymentSummary' =>function($query){
                        return $query->with([
                            'paymentDetails',
                            'recursiveChilds'
                        ]);
                    },
                    'paymentHistory' => function($query){
                        return $query->with([
                            'paymentHistoryDetails',
                            'childs'
                        ]);
                    },
                    'splitPayments'
                ])->orderBy('created_at','desc');
            },
        ];
    }

    public function getShowResource(){
        return ShowBilling::class;
    }

    public function getViewResource(){
        return ViewBilling::class;
    }

    public function hasTransaction(){return $this->belongsToModel("PosTransaction",'has_transaction_id');}
}
