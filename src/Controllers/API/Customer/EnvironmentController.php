<?php

namespace Projects\Hq\Controllers\API\Customer;

use Hanafalah\ModulePayment\Contracts\Schemas\Consument;
use Projects\Hq\Controllers\API\ApiController;

class EnvironmentController extends ApiController{
    public function __construct(
        public Consument $__consument_schema
    ){
        parent::__construct();
        $this->userAttempt();
    }

    protected function commonConditional($query){
    }

    protected function commonRequest(){
        
    }

    protected function getConsumentPaginate(?callable $callback = null){
        $this->commonRequest();
        return $this->__consument_schema->conditionals(function($query) use ($callback){
            $this->commonConditional($query);
            $query->when(isset($callback),function ($query) use ($callback){
                $callback($query);
            });
        })->viewConsumentPaginate();
    }

    protected function showConsument(?callable $callback = null){
        $this->commonRequest();
        return $this->__consument_schema->conditionals(function($query) use ($callback){
            $this->commonConditional($query);
            $query->when(isset($callback),function ($query) use ($callback){
                $callback($query);
            });
        })->showConsument();
    }

    protected function storeCustomer(?callable $callback = null){
        $this->commonRequest();
        return $this->__consument_schema->conditionals(function($query) use ($callback){
            $this->commonConditional($query);
            $callback($query);
        })->storeConsument();
    }
}