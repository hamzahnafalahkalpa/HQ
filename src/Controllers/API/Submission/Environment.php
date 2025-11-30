<?php

namespace Projects\Hq\Controllers\API\Submission;

use Projects\Hq\Contracts\Schemas\PosTransaction;
use Projects\Hq\Controllers\API\ApiController;
use Xendit\Configuration;

class Environment extends ApiController{
    public function __construct(
        public PosTransaction $__pos_schema
    ){
        parent::__construct();
    }

    protected function commonConditional($query){

    }

    
    protected function commonRequest(){
        $this->userAttempt();
    }
}