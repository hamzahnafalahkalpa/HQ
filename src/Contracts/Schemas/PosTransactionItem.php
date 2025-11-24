<?php

namespace Projects\Hq\Contracts\Schemas;

use Projects\Hq\Contracts\Data\PosTransactionItemData;
//use Projects\Hq\Contracts\Data\PosTransactionItemUpdateData;
use Hanafalah\LaravelSupport\Contracts\Supports\DataManagement;
use Hanafalah\ModulePayment\Contracts\Schemas\PosTransactionItem as SchemasPosTransactionItem;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @see \Projects\Hq\Schemas\PosTransactionItem
 * @method mixed export(string $type)
 * @method self conditionals(mixed $conditionals)
 * @method array updatePosTransactionItem(?PosTransactionItemData $pos_transaction_item_dto = null)
 * @method Model prepareUpdatePosTransactionItem(PosTransactionItemData $pos_transaction_item_dto)
 * @method bool deletePosTransactionItem()
 * @method bool prepareDeletePosTransactionItem(? array $attributes = null)
 * @method mixed getPosTransactionItem()
 * @method ?Model prepareShowPosTransactionItem(?Model $model = null, ?array $attributes = null)
 * @method array showPosTransactionItem(?Model $model = null)
 * @method Collection prepareViewPosTransactionItemList()
 * @method array viewPosTransactionItemList()
 * @method LengthAwarePaginator prepareViewPosTransactionItemPaginate(PaginateData $paginate_dto)
 * @method array viewPosTransactionItemPaginate(?PaginateData $paginate_dto = null)
 * @method array storePosTransactionItem(?PosTransactionItemData $pos_transaction_item_dto = null)
 * @method Collection prepareStoreMultiplePosTransactionItem(array $datas)
 * @method array storeMultiplePosTransactionItem(array $datas)
 */

interface PosTransactionItem extends SchemasPosTransactionItem
{
    public function prepareStorePosTransactionItem(mixed $pos_transaction_item_dto): Model;
}