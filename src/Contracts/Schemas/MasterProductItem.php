<?php

namespace Projects\Hq\Contracts\Schemas;

use Hanafalah\LaravelSupport\Contracts\Schemas\Unicode;
use Projects\Hq\Contracts\Data\MasterProductItemData;
//use Projects\Hq\Contracts\Data\MasterProductItemUpdateData;
use Hanafalah\LaravelSupport\Contracts\Supports\DataManagement;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @see \Projects\Hq\Schemas\MasterProductItem
 * @method mixed export(string $type)
 * @method self conditionals(mixed $conditionals)
 * @method array updateMasterProductItem(?MasterProductItemData $master_product_item_dto = null)
 * @method Model prepareUpdateMasterProductItem(MasterProductItemData $master_product_item_dto)
 * @method bool deleteMasterProductItem()
 * @method bool prepareDeleteMasterProductItem(? array $attributes = null)
 * @method mixed getMasterProductItem()
 * @method ?Model prepareShowMasterProductItem(?Model $model = null, ?array $attributes = null)
 * @method array showMasterProductItem(?Model $model = null)
 * @method Collection prepareViewMasterProductItemList()
 * @method array viewMasterProductItemList()
 * @method LengthAwarePaginator prepareViewMasterProductItemPaginate(PaginateData $paginate_dto)
 * @method array viewMasterProductItemPaginate(?PaginateData $paginate_dto = null)
 * @method array storeMasterProductItem(?MasterProductItemData $master_product_item_dto = null)
 * @method Collection prepareStoreMultipleMasterProductItem(array $datas)
 * @method array storeMultipleMasterProductItem(array $datas)
 */

interface MasterProductItem extends Unicode
{
    public function prepareStoreMasterProductItem(MasterProductItemData $master_product_item_dto): Model;
    public function masterProductItem(mixed $conditionals = null): Builder;
}