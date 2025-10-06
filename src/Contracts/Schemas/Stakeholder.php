<?php

namespace Projects\Hq\Contracts\Schemas;

use Projects\Hq\Contracts\Data\StakeholderData;
//use Projects\Hq\Contracts\Data\StakeholderUpdateData;
use Hanafalah\LaravelSupport\Contracts\Supports\DataManagement;
use Hanafalah\ModulePeople\Contracts\Schemas\People;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @see \Projects\Hq\Schemas\Stakeholder
 * @method mixed export(string $type)
 * @method self conditionals(mixed $conditionals)
 * @method array updateStakeholder(?StakeholderData $stakeholder_dto = null)
 * @method Model prepareUpdateStakeholder(StakeholderData $stakeholder_dto)
 * @method bool deleteStakeholder()
 * @method bool prepareDeleteStakeholder(? array $attributes = null)
 * @method mixed getStakeholder()
 * @method ?Model prepareShowStakeholder(?Model $model = null, ?array $attributes = null)
 * @method array showStakeholder(?Model $model = null)
 * @method Collection prepareViewStakeholderList()
 * @method array viewStakeholderList()
 * @method LengthAwarePaginator prepareViewStakeholderPaginate(PaginateData $paginate_dto)
 * @method array viewStakeholderPaginate(?PaginateData $paginate_dto = null)
 * @method array storeStakeholder(?StakeholderData $stakeholder_dto = null)
 * @method Collection prepareStoreMultipleStakeholder(array $datas)
 * @method array storeMultipleStakeholder(array $datas)
 */

interface Stakeholder extends People
{
    public function prepareStoreStakeholder(StakeholderData $stakeholder_dto): Model;
}