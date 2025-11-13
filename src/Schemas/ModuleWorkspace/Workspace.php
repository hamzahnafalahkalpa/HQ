<?php

namespace Projects\Hq\Schemas\ModuleWorkspace;

use Hanafalah\ModuleWorkspace\Contracts\Data\WorkspaceData;
use Hanafalah\ModuleWorkspace\Schemas\Workspace as SchemasWorkspace;
use Illuminate\Database\Eloquent\Model;
use Projects\Hq\Contracts\Schemas\ModuleWorkspace\Workspace as ModuleWorkspaceWorkspace;

class Workspace extends SchemasWorkspace implements ModuleWorkspaceWorkspace{
    public function prepareStoreWorkspace(mixed $workspace_dto): Model{
        $workspace = parent::prepareStoreWorkspace($workspace_dto);
        $workspace->product_id = $workspace_dto->product_id;
        if (isset($workspace_dto->installed_product_items) && count($workspace_dto->installed_product_items) > 0){
            foreach ($workspace_dto->installed_product_items as &$installed_product_item) {
                $installed_product_item->reference_type = $workspace->getMorphClass();
                $installed_product_item->reference_id = $workspace->getKey();
                $this->schemaContract('installed_product_item')->prepareStoreInstalledProductItem($installed_product_item);
            }
        }
        $this->fillingProps($workspace,$workspace_dto->props);
        $workspace->save();
        return $this->workspace_model = $workspace;
    }
}