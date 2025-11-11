<?php

namespace Projects\Hq\Models\ModuleWorkspace;

use Hanafalah\ModuleWorkspace\Models\Workspace\Workspace as WorkspaceWorkspace;
use Projects\Hq\Resources\Workspace\ShowWorkspace;
use Projects\Hq\Resources\Workspace\ViewWorkspace;

class Workspace extends WorkspaceWorkspace
{
    public function viewUsingRelation(): array{
        return ['tenant'];
    }

    public function showUsingRelation(): array{
        return ['tenant','address'];
    }

    public function getShowResource(){
        return ShowWorkspace::class;
    }

    public function getViewResource(){
        return ViewWorkspace::class;
    }

    public function tenant(){return $this->morphOneModel('Tenant','reference');}
}
