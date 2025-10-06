<?php

namespace Projects\Hq\Controllers\API\Transaction\Submission;

use Hanafalah\ModulePayment\Contracts\Schemas\PosTransaction;
use Projects\Hq\Controllers\API\ApiController;
use Xendit\Configuration;

class EnvironmentController extends ApiController{
    public function __construct(
        public PosTransaction $__pos_schema
    ){
        parent::__construct();
        $this->userAttempt();
        
        // Configuration::setXenditKey(env('XENDIT_KEY'));
    }

    protected function commonConditional($query){

    }

    protected function commonRequest(){
        
    }

    protected function getPosTransactionPaginate(?callable $callback = null){        
        $this->commonRequest();
        return $this->__pos_schema->conditionals(function($query) use ($callback){
            $this->commonConditional($query);
            $query->when(isset($callback),function ($query) use ($callback){
                $callback($query);
            });
        })->viewPosTransactionPaginate();
    }

    protected function showPosTransaction(?callable $callback = null){        
        $this->commonRequest();
        return $this->__pos_schema->conditionals(function($query) use ($callback){
            $this->commonConditional($query);
            $query->when(isset($callback),function ($query) use ($callback){
                $callback($query);
            });
        })->showPosTransaction();
    }

    protected function deletePosTransaction(?callable $callback = null){        
        $this->commonRequest();
        return $this->__pos_schema->conditionals(function($query) use ($callback){
            $this->commonConditional($query);
            $callback($query);
        })->deletePosTransaction();
    }

    protected function storePosTransaction(?callable $callback = null){
        $this->commonRequest();
        return $this->__pos_schema->conditionals(function($query) use ($callback){
            $this->commonConditional($query);
            $callback($query);
        })->storePosTransaction();
    }
}