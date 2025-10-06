<?php

namespace Projects\Hq\Contracts\Schemas;

use Hanafalah\LaravelSupport\Contracts\Schemas\Unicode;
use Projects\Hq\Contracts\Data\ProductData;
//use Projects\Hq\Contracts\Data\ProductUpdateData;
use Hanafalah\LaravelSupport\Contracts\Supports\DataManagement;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @see \Projects\Hq\Schemas\Product
 * @method mixed export(string $type)
 * @method self conditionals(mixed $conditionals)
 * @method array updateProduct(?ProductData $product_dto = null)
 * @method Model prepareUpdateProduct(ProductData $product_dto)
 * @method bool deleteProduct()
 * @method bool prepareDeleteProduct(? array $attributes = null)
 * @method mixed getProduct()
 * @method ?Model prepareShowProduct(?Model $model = null, ?array $attributes = null)
 * @method array showProduct(?Model $model = null)
 * @method Collection prepareViewProductList()
 * @method array viewProductList()
 * @method LengthAwarePaginator prepareViewProductPaginate(PaginateData $paginate_dto)
 * @method array viewProductPaginate(?PaginateData $paginate_dto = null)
 * @method array storeProduct(?ProductData $product_dto = null)
 * @method Collection prepareStoreMultipleProduct(array $datas)
 * @method array storeMultipleProduct(array $datas)
 */

interface Product extends Unicode
{
    public function prepareStoreProduct(ProductData $product_dto): Model;
    public function product(mixed $conditionals = null): Builder;
}