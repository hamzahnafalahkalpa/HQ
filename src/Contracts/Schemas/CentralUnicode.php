<?php

namespace Projects\Hq\Contracts\Schemas;

use Hanafalah\LaravelSupport\Contracts\Schemas\Unicode;
use Illuminate\Database\Eloquent\Builder;
use Projects\Hq\Contracts\Data\CentralUnicodeData;
//use Projects\Hq\Contracts\Data\CentralUnicodeUpdateData;
use Illuminate\Database\Eloquent\Model;

/**
 * @see \Projects\Hq\Schemas\CentralUnicode
 * @method mixed export(string $type)
 * @method self conditionals(mixed $conditionals)
 * @method array updateCentralUnicode(?CentralUnicodeData $central_unicode_dto = null)
 * @method Model prepareUpdateCentralUnicode(CentralUnicodeData $central_unicode_dto)
 * @method bool deleteCentralUnicode()
 * @method bool prepareDeleteCentralUnicode(? array $attributes = null)
 * @method mixed getCentralUnicode()
 * @method ?Model prepareShowCentralUnicode(?Model $model = null, ?array $attributes = null)
 * @method array showCentralUnicode(?Model $model = null)
 * @method Collection prepareViewCentralUnicodeList()
 * @method array viewCentralUnicodeList()
 * @method LengthAwarePaginator prepareViewCentralUnicodePaginate(PaginateData $paginate_dto)
 * @method array viewCentralUnicodePaginate(?PaginateData $paginate_dto = null)
 * @method array storeCentralUnicode(?CentralUnicodeData $central_unicode_dto = null)
 * @method Collection prepareStoreMultipleCentralUnicode(array $datas)
 * @method array storeMultipleCentralUnicode(array $datas)
 */

interface CentralUnicode extends Unicode
{
    public function prepareStoreCentralUnicode(CentralUnicodeData $central_unicode_dto): Model;
    public function centralUnicode(mixed $conditionals = null): Builder;
}