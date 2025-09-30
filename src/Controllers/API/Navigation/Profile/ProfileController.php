<?php

namespace Projects\Hq\Controllers\API\Navigation\Profile;

use Hanafalah\ModuleEmployee\Contracts\Schemas\ProfileEmployee;
use Projects\Hq\Controllers\API\ApiController;
use Projects\Hq\Requests\API\Navigation\Profile\{
    ShowRequest, StoreRequest
};

class ProfileController extends ApiController{
    public function __construct(
        protected ProfileEmployee $__employee_schema    
    ){
        parent::__construct();
    }

    public function store(StoreRequest $request){
        return $this->__employee_schema->storeProfile();
    }
    
    public function show(ShowRequest $request){
        return $this->__employee_schema->showProfile();
    }
}