<?php

namespace Projects\Hq\Models\ModuleWorkspace;

use Hanafalah\ModuleWorkspace\Models\Workspace\Workspace as WorkspaceWorkspace;
use Projects\Hq\Resources\Workspace\ShowWorkspace;
use Projects\Hq\Resources\Workspace\ViewWorkspace;

class Workspace extends WorkspaceWorkspace
{
    protected $list = [
        'id', 'uuid', 'name', 'owner_id', 'product_id', 'status', 'props'
    ];  

    public function viewUsingRelation(): array{
        return ['tenant'];
    }

    public function showUsingRelation(): array{
        return ['tenant','address','product','installedProductItems'];
    }

    public function getShowResource(){
        return ShowWorkspace::class;
    }

    public function getViewResource(){
        return ViewWorkspace::class;
    }

    public function tenant(){return $this->morphOneModel('Tenant','reference');}
    public function product(){return $this->belongsToModel('Product','product_id');}
    public function installedProductItem(){
        return $this->morphOneModel('InstalledProductItem','reference');
    }
    public function installedProductItems(){
        return $this->morphManyModel('InstalledProductItem','reference');
    }
}
