<?php

namespace Projects\HQ\Controllers\API\User;

use Projects\HQ\Requests\API\User\{
    ViewRequest, ShowRequest, StoreRequest, DeleteRequest
};

class UserController extends EnvironmentController{
    public function index(ViewRequest $request){
        return $this->getUserPaginate();
    }

    public function show(ShowRequest $request){
        return $this->showUser();
    }

    public function store(StoreRequest $request){
        return $this->storeUser();
    }

    public function delete(DeleteRequest $request){
        return $this->deleteUser();
    }
}