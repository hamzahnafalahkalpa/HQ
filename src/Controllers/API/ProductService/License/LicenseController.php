<?php

namespace Projects\Hq\Controllers\API\ProductService\License;

use Projects\Hq\Requests\API\ProductService\License\{
    ViewRequest, ShowRequest, StoreRequest, DeleteRequest
};

class LicenseController extends EnvironmentController{
    protected function commonRequest(){
        parent::commonRequest();
        $workspace = $this->WorkspaceModel()->findOrFail(request()->product_service_id);
        config([
            'database.connections.clinic.database' => $workspace->tenant->tenancy_db_name
        ]);
    }

    protected function commonConditional($query){
        parent::commonConditional($query);
        $query->where('flag','USER_LICENSE');
    }

    public function index(ViewRequest $request){
        return $this->getLicensePaginate();
    }

    public function show(ShowRequest $request){
        return $this->showLicense();
    }

    public function store(StoreRequest $request){
        return $this->storeLicense();
    }

    public function delete(DeleteRequest $request){
        return $this->deleteLicense();
    }
}