<?php

namespace Projects\Hq\Controllers\API\Submission;

use Projects\Hq\Contracts\Schemas\PosTransaction;
use Projects\Hq\Controllers\API\ApiController;
use Xendit\Configuration;

class EnvironmentController extends Environment{
    protected function commonConditional($query){
        parent::commonConditional($query);
    }
    
    protected function commonRequest(){
        parent::commonRequest();
        $billing = request()?->billing;
        if (isset($billing)){
            $billing['author_type']  ??= $this->global_user->getMorphClass();   
            $billing['author_id']    ??= $this->global_user->getKey();   
        }
    
        request()->merge([
            'search_reference_type' => ['Submission'],
            'billing'               => $billing ?? null
        ]);
        Configuration::setXenditKey(env('XENDIT_SECRET_KEY'));
        
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