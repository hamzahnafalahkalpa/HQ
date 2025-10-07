<?php

namespace Projects\Hq\Contracts\Schemas;

use Projects\Hq\Contracts\Data\PosTransactionData;
//use Projects\Hq\Contracts\Data\PosTransactionUpdateData;
use Hanafalah\LaravelSupport\Contracts\Supports\DataManagement;
use Hanafalah\ModulePayment\Contracts\Schemas\PosTransaction as SchemasPosTransaction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @see \Projects\Hq\Schemas\PosTransaction
 * @method mixed export(string $type)
 * @method self conditionals(mixed $conditionals)
 * @method array updatePosTransaction(?PosTransactionData $pos_transaction_dto = null)
 * @method Model prepareUpdatePosTransaction(PosTransactionData $pos_transaction_dto)
 * @method bool deletePosTransaction()
 * @method bool prepareDeletePosTransaction(? array $attributes = null)
 * @method mixed getPosTransaction()
 * @method ?Model prepareShowPosTransaction(?Model $model = null, ?array $attributes = null)
 * @method array showPosTransaction(?Model $model = null)
 * @method Collection prepareViewPosTransactionList()
 * @method array viewPosTransactionList()
 * @method LengthAwarePaginator prepareViewPosTransactionPaginate(PaginateData $paginate_dto)
 * @method array viewPosTransactionPaginate(?PaginateData $paginate_dto = null)
 * @method array storePosTransaction(?PosTransactionData $pos_transaction_dto = null)
 * @method Collection prepareStoreMultiplePosTransaction(array $datas)
 * @method array storeMultiplePosTransaction(array $datas)
 */

interface PosTransaction extends SchemasPosTransaction
{
    public function prepareStorePosTransaction(mixed $pos_transaction_dto): Model;
}