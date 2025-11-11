<?php

namespace Projects\Hq\Schemas\ModuleWorkspace;

use Hanafalah\ModuleWorkspace\Contracts\Data\WorkspaceData;
use Hanafalah\ModuleWorkspace\Schemas\Workspace as SchemasWorkspace;
use Illuminate\Database\Eloquent\Model;
use Projects\Hq\Contracts\Schemas\ModuleWorkspace\Workspace as ModuleWorkspaceWorkspace;

class Workspace extends SchemasWorkspace implements ModuleWorkspaceWorkspace{
    // protected function prepareStoreAddressWorkspace(Model $workspace, WorkspaceData &$workspace_dto): void{
    //     $address             = &$workspace_dto->props->setting->address;
    //     $address->model_type = $workspace->getMorphClass();
    //     $address->model_id   = $workspace->getKey(); 
    //     $address_model       = $this->schemaContract('wellmed_address')->prepareStoreWellmedAddress($address);
    //     $address->id         = $address_model->getKey();
    //     unset($address->props);
    // }
}