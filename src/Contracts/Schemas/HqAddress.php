<?php

namespace Projects\Hq\Contracts\Schemas;

use Projects\Hq\Contracts\Data\HqAddressData;
use Illuminate\Database\Eloquent\Model;
use Hanafalah\ModuleRegional\Contracts\Schemas\Regional\Address;

/**
 * @see \Projects\Hq\Schemas\HqAddress
 * @method mixed export(string $type)
 * @method self conditionals(mixed $conditionals)
 * @method array updateHqAddress(?HqAddressData $hq_address_dto = null)
 * @method Model prepareUpdateHqAddress(HqAddressData $hq_address_dto)
 * @method bool deleteHqAddress()
 * @method bool prepareDeleteHqAddress(? array $attributes = null)
 * @method mixed getHqAddress()
 * @method ?Model prepareShowHqAddress(?Model $model = null, ?array $attributes = null)
 * @method array showHqAddress(?Model $model = null)
 * @method Collection prepareViewHqAddressList()
 * @method array viewHqAddressList()
 * @method LengthAwarePaginator prepareViewHqAddressPaginate(PaginateData $paginate_dto)
 * @method array viewHqAddressPaginate(?PaginateData $paginate_dto = null)
 * @method array storeHqAddress(?HqAddressData $hq_address_dto = null)
 * @method Collection prepareStoreMultipleHqAddress(array $datas)
 * @method array storeMultipleHqAddress(array $datas)
 */

interface HqAddress extends Address{}