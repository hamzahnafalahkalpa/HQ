<?php

namespace Projects\Hq\Controllers\API\Setting;

use Hanafalah\ModuleWorkspace\Contracts\Schemas\Workspace;
use Projects\Hq\Controllers\API\ApiController;
use Projects\Hq\Requests\API\Setting\Workspace\{
    ShowRequest, StoreRequest
};

class WorkspaceController extends ApiController{
    public function __construct(
        protected Workspace $__workspace_schema
    ){
        parent::__construct();
    }

    public function show(ShowRequest $request){
        return $this->__workspace_schema->showWorkspace();
    }

    public function store(StoreRequest $request){
        return $this->__workspace_schema->storeWorkspace();
    }
}