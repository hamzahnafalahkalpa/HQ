<?php

namespace Projects\Hq\Contracts\Schemas;

use Hanafalah\LaravelSupport\Contracts\Schemas\Unicode;
use Projects\Hq\Contracts\Data\ProductItemData;
//use Projects\Hq\Contracts\Data\ProductItemUpdateData;
use Hanafalah\LaravelSupport\Contracts\Supports\DataManagement;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @see \Projects\Hq\Schemas\ProductItem
 * @method mixed export(string $type)
 * @method self conditionals(mixed $conditionals)
 * @method array updateProductItem(?ProductItemData $product_item_dto = null)
 * @method Model prepareUpdateProductItem(ProductItemData $product_item_dto)
 * @method bool deleteProductItem()
 * @method bool prepareDeleteProductItem(? array $attributes = null)
 * @method mixed getProductItem()
 * @method ?Model prepareShowProductItem(?Model $model = null, ?array $attributes = null)
 * @method array showProductItem(?Model $model = null)
 * @method Collection prepareViewProductItemList()
 * @method array viewProductItemList()
 * @method LengthAwarePaginator prepareViewProductItemPaginate(PaginateData $paginate_dto)
 * @method array viewProductItemPaginate(?PaginateData $paginate_dto = null)
 * @method array storeProductItem(?ProductItemData $product_item_dto = null)
 * @method Collection prepareStoreMultipleProductItem(array $datas)
 * @method array storeMultipleProductItem(array $datas)
 */

interface ProductItem extends DataManagement
{
    public function prepareStoreProductItem(ProductItemData $product_item_dto): Model;
}