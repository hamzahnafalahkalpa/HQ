<?php

namespace Projects\Hq\Contracts\Schemas\ModuleWorkspace;

use Hanafalah\ModuleWorkspace\Contracts\Schemas\Workspace as SchemasWorkspace;
use Illuminate\Database\Eloquent\Builder;
use Projects\Hq\Contracts\Data\CentralWorkspaceData;
//use Projects\Hq\Contracts\Data\CentralWorkspaceUpdateData;
use Illuminate\Database\Eloquent\Model;

/**
 * @see \Projects\Hq\Schemas\CentralWorkspace
 * @method mixed export(string $type)
 * @method self conditionals(mixed $conditionals)
 * @method array updateCentralWorkspace(?CentralWorkspaceData $workspace_dto = null)
 * @method Model prepareUpdateCentralWorkspace(CentralWorkspaceData $workspace_dto)
 * @method bool deleteCentralWorkspace()
 * @method bool prepareDeleteCentralWorkspace(? array $attributes = null)
 * @method mixed getCentralWorkspace()
 * @method ?Model prepareShowCentralWorkspace(?Model $model = null, ?array $attributes = null)
 * @method array showCentralWorkspace(?Model $model = null)
 * @method Collection prepareViewCentralWorkspaceList()
 * @method array viewCentralWorkspaceList()
 * @method LengthAwarePaginator prepareViewCentralWorkspacePaginate(PaginateData $paginate_dto)
 * @method array viewCentralWorkspacePaginate(?PaginateData $paginate_dto = null)
 * @method array storeCentralWorkspace(?CentralWorkspaceData $workspace_dto = null)
 * @method Collection prepareStoreMultipleCentralWorkspace(array $datas)
 * @method array storeMultipleCentralWorkspace(array $datas)
 */

interface Workspace extends SchemasWorkspace
{
}