<?php

namespace Projects\HQ\Controllers\API\Transaction\Billing;

use Hanafalah\ModulePayment\Contracts\Schemas\Billing;
use Projects\HQ\Controllers\API\ApiController;

class EnvironmentController extends ApiController{
    public function __construct(
        public Billing $__schema,
    ){
        parent::__construct();
        $this->userAttempt();
    }

    protected function commonConditional($query){

    }

    protected function commonRequest(){
        
    }

    protected function getBillingPaginate(?callable $callback = null){        
        $this->commonRequest();
        return $this->__schema->conditionals(function($query) use ($callback){
            $this->commonConditional($query);
            $query->when(isset($callback),function ($query) use ($callback){
                $callback($query);
            });
        })->viewBillingPaginate();
    }

    protected function getBillingList(?callable $callback = null){        
        $this->commonRequest();
        return $this->__schema->conditionals(function($query) use ($callback){
            $this->commonConditional($query);
            $query->when(isset($callback),function ($query) use ($callback){
                $callback($query);
            });
        })->viewBillingList();
    }

    protected function showBilling(?callable $callback = null){        
        $this->commonRequest();
        return $this->__schema->conditionals(function($query) use ($callback){
            $this->commonConditional($query);
            $query->when(isset($callback),function ($query) use ($callback){
                $callback($query);
            });
        })->showBilling();
    }

    protected function deleteBilling(?callable $callback = null){        
        $this->commonRequest();
        return $this->__schema->conditionals(function($query) use ($callback){
            $this->commonConditional($query);
            $callback($query);
        })->deleteBilling();
    }

    protected function storeBilling(?callable $callback = null){
        $this->commonRequest();
        return $this->__schema->conditionals(function($query) use ($callback){
            $this->commonConditional($query);
            $callback($query);
        })->storeBilling();
    }
}