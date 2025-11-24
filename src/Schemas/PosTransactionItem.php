<?php

namespace Projects\Hq\Schemas;

use Hanafalah\ModulePayment\Schemas\PosTransactionItem as SchemasPosTransactionItem;
use Illuminate\Database\Eloquent\Model;
use Projects\Hq\Contracts\Schemas\PosTransactionItem as ContractsSchemasPosTransactionItem;

class PosTransactionItem extends SchemasPosTransactionItem implements ContractsSchemasPosTransactionItem
{
    public function prepareStorePosTransactionItem(mixed $pos_transaction_item_dto): Model{
        $pos_transaction_item_model = parent::prepareStorePosTransactionItem($pos_transaction_item_dto);
        if ($pos_transaction_item_model->item_type == 'Workspace'){
            $submission = $pos_transaction_item_model->transaction->reference;

            $workspace = $pos_transaction_item_model->item;
            $workspace->submission_id = $submission->getKey();
            $workspace->prop_submission = $submission->toViewApi()->resolve();
            $workspace->save();
        }
        return $this->pos_transaction_item_model = $pos_transaction_item_model;
    }
}