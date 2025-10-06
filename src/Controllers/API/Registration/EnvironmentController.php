<?php

namespace Projects\Hq\Controllers\API\Registration;

use Hanafalah\ModuleUser\Contracts\Schemas\UserReference;
use Projects\Hq\Controllers\API\ApiController;

class EnvironmentController extends ApiController{
    public function __construct(
        public UserReference $__user_reference_schema
    ){
        parent::__construct();
        $this->userAttempt();
    }

    protected function commonConditional($query){

    }

    protected function commonRequest(){
        
    }

    protected function storeRegistration(?callable $callback = null){
        $this->commonRequest();
        return $this->__user_reference_schema->conditionals(function($query) use ($callback){
            $this->commonConditional($query);
            $callback($query);
        })->storeUserReference();
    }
}