<?php

namespace Projects\Hq\Contracts\Schemas;

use Hanafalah\LaravelSupport\Contracts\Schemas\Unicode;
use Projects\Hq\Contracts\Data\InstalledProductItemData;
//use Projects\Hq\Contracts\Data\InstalledProductItemUpdateData;
use Hanafalah\LaravelSupport\Contracts\Supports\DataManagement;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @see \Projects\Hq\Schemas\InstalledProductItem
 * @method mixed export(string $type)
 * @method self conditionals(mixed $conditionals)
 * @method array updateInstalledProductItem(?InstalledProductItemData $installed_product_item_dto = null)
 * @method Model prepareUpdateInstalledProductItem(InstalledProductItemData $installed_product_item_dto)
 * @method bool deleteInstalledProductItem()
 * @method bool prepareDeleteInstalledProductItem(? array $attributes = null)
 * @method mixed getInstalledProductItem()
 * @method ?Model prepareShowInstalledProductItem(?Model $model = null, ?array $attributes = null)
 * @method array showInstalledProductItem(?Model $model = null)
 * @method Collection prepareViewInstalledProductItemList()
 * @method array viewInstalledProductItemList()
 * @method LengthAwarePaginator prepareViewInstalledProductItemPaginate(PaginateData $paginate_dto)
 * @method array viewInstalledProductItemPaginate(?PaginateData $paginate_dto = null)
 * @method array storeInstalledProductItem(?InstalledProductItemData $installed_product_item_dto = null)
 * @method Collection prepareStoreMultipleInstalledProductItem(array $datas)
 * @method array storeMultipleInstalledProductItem(array $datas)
 */

interface InstalledProductItem extends DataManagement
{
    public function prepareStoreInstalledProductItem(InstalledProductItemData $installed_product_item_dto): Model;
}