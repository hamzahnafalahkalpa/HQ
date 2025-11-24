<?php

namespace Projects\Hq\Schemas;

use Hanafalah\ModulePayment\Schemas\PosTransaction as SchemasPosTransaction;
use Illuminate\Database\Eloquent\Model;
use Projects\Hq\Contracts\Schemas\PosTransaction as ContractsPosTransaction;

class PosTransaction extends SchemasPosTransaction implements ContractsPosTransaction
{
    protected string $__entity = 'PosTransaction';
    public $pos_transaction_model;
    //protected mixed $__order_by_created_at = false; //asc, desc, false

    protected array $__cache = [
        'index' => [
            'name'     => 'pos_transaction',
            'tags'     => ['pos_transaction', 'pos_transaction-index'],
            'duration' => 24 * 60
        ]
    ];

    public function prepareStorePosTransaction(mixed $pos_transaction_dto): Model{
        $pos_transaction = parent::prepareStorePosTransaction($pos_transaction_dto);
        $this->fillingProps($pos_transaction,$pos_transaction_dto->props);
        $pos_transaction->save();
        
        return $this->pos_transaction_model = $pos_transaction;
    }
}