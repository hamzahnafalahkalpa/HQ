<?php

namespace Projects\Hq\Controllers\API\Navigation\Profile;

use Hanafalah\ModuleEmployee\Contracts\Schemas\ProfilePhoto;
use Projects\Hq\Controllers\API\ApiController;
use Projects\Hq\Requests\API\Navigation\Profile\{
    ShowRequest, StoreRequest
};

class ProfilePhotoController extends ApiController{
    public function __construct(
        protected ProfilePhoto $__profile_schema    
    ){}

    public function store(StoreRequest $request){
        return $this->__profile_schema->storeProfilePhoto();
    }

    public function show(ShowRequest $request){
        return $this->__profile_schema->showProfilePhoto();
    }
}