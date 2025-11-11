<?php

namespace Projects\Hq\Controllers\API\ProductService;

use Projects\Hq\Contracts\Schemas\ModuleWorkspace\Workspace;
use Projects\Hq\Controllers\API\ApiController;

class EnvironmentController extends ApiController{
    public function __construct(
        public Workspace $__schema,
    ){
        parent::__construct();
    }

    protected function commonConditional($query){

    }

    protected function commonRequest(){
        $this->userAttempt();
        request()->merge([
            'owner_id' => $this->global_user->getKey(),
            'search_owner_id' => $this->global_user->getKey()
        ]);
    }

    protected function getWorkspacePaginate(?callable $callback = null){        
        $this->commonRequest();
        return $this->__schema->conditionals(function($query) use ($callback){
            $this->commonConditional($query);
            $query->when(isset($callback),function ($query) use ($callback){
                $callback($query);
            });
        })->viewWorkspacePaginate();
    }

    protected function showWorkspace(?callable $callback = null){        
        $this->commonRequest();
        return $this->__schema->conditionals(function($query) use ($callback){
            $this->commonConditional($query);
            $query->when(isset($callback),function ($query) use ($callback){
                $callback($query);
            });
        })->showWorkspace();
    }

    protected function deleteWorkspace(?callable $callback = null){        
        $this->commonRequest();
        return $this->__schema->conditionals(function($query) use ($callback){
            $this->commonConditional($query);
            $callback($query);
        })->deleteWorkspace();
    }

    protected function storeWorkspace(?callable $callback = null){
        $this->commonRequest();
        return $this->__schema->conditionals(function($query) use ($callback){
            $this->commonConditional($query);
            $callback($query);
        })->storeWorkspace();
    }
}