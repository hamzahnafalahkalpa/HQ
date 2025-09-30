<?php

namespace Projects\Hq\Controllers\API\User;

use Hanafalah\ModuleUser\Contracts\Schemas\User;
use Projects\Hq\Controllers\API\ApiController;

class EnvironmentController extends ApiController{
    public function __construct(
        public User $__user_schema,
    ){
        parent::__construct();
        $this->userAttempt();
    }

    protected function commonConditional($query){
        $query->where('props->is_hq_user',true);
    }

    protected function commonRequest(){
        
    }

    protected function getUserPaginate(?callable $callback = null){        
        $this->commonRequest();
        return $this->__user_schema->conditionals(function($query) use ($callback){
            $this->commonConditional($query);
            $query->when(isset($callback),function ($query) use ($callback){
                $callback($query);
            });
        })->viewUserPaginate();
    }

    protected function showUser(?callable $callback = null){        
        $this->commonRequest();
        return $this->__user_schema->conditionals(function($query) use ($callback){
            $this->commonConditional($query);
            $query->when(isset($callback),function ($query) use ($callback){
                $callback($query);
            });
        })->showUser();
    }

    protected function deleteUser(?callable $callback = null){        
        $this->commonRequest();
        return $this->__user_schema->conditionals(function($query) use ($callback){
            $this->commonConditional($query);
            $callback($query);
        })->deleteUser();
    }

    protected function storeUser(?callable $callback = null){
        $this->commonRequest();
        return $this->__user_schema->conditionals(function($query) use ($callback){
            $this->commonConditional($query);
            $callback($query);
        })->storeUser();
    }
}