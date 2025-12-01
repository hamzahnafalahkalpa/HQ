<?php

namespace Projects\Hq\Models\ModulePayment;

use Hanafalah\ModulePayment\Models\Transaction\Invoice as TransactionInvoice;

class Invoice extends TransactionInvoice
{
    public function viewUsingRelation(){
        return [
            'billing.hasTransaction.reference',
            'paymentSummary', 'paymentHistory'
        ];
    }

    public function showUsingRelation(){
        return [
            'billing.hasTransaction.reference',
            'paymentSummary' => function($query){
                return $query->with([
                    'paymentDetails',
                    'recursiveChilds'
                ]);
            },
            'paymentHistory' => function($query){
                return $query->with([
                    'childs.paymentHistoryDetails',
                ]);
            },
            'splitPayments'
        ];
    }
}
