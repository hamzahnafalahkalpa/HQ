<?php

namespace Projects\Hq\Models;

use Hanafalah\ModulePayment\Models\Transaction\PosTransaction as TransactionPosTransaction;
use Projects\Hq\Resources\PosTransaction\{
    ViewPosTransaction,
    ShowPosTransaction
};

class PosTransaction extends TransactionPosTransaction{
    public function showUsingRelation(): array{
        return $this->mergeArray(parent::showUsingRelation(),[
            'transactionItems.item' => function($query){
                $query->with([
                    'product',
                    'installedProductItems'
                ]);
            },
        ]);
    }
}
