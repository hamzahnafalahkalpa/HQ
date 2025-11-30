<?php

namespace Projects\Hq\Models;

use Hanafalah\ModulePayment\Models\Transaction\PosTransaction as TransactionPosTransaction;

class PosTransaction extends TransactionPosTransaction{
    public function showUsingRelation(): array{
        return $this->mergeArray(parent::showUsingRelation(),[
            'transactionItems.item' => function($morphTo){
                $morphTo->morphWith([
                    $this->WorkspaceModelMorph() => [
                        'product',
                        'installedProductItems',
                        'installedWorkspaceItems'
                    ],
                    $this->ProductItemModelMorph() => [
                    ]
                ]);
            },
        ]);
    }
}
