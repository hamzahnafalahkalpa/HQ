<?php

namespace Projects\Hq\Controllers\API\Registration;

use Hanafalah\MicroTenant\Facades\MicroTenant as FacadesMicroTenant;
use Hanafalah\MicroTenant\MicroTenant;
use Projects\Hq\Requests\API\Registration\{
    StoreRequest
};

class RegistrationController extends EnvironmentController{
    public function store(StoreRequest $request){
        $possibleTypes = ['company','people'];
        $reference = null;
        $referenceType = null;
        foreach ($possibleTypes as $type) {
            if (request()->filled($type)) {
                $reference = request()->input($type);
                $referenceType = $type;
                break;
            }
        }
        if (isset($referenceType)) {
            $data = array_fill_keys($possibleTypes, null);
            if (isset($reference)) $data['reference'] = $reference;
            $data['reference_type'] = $referenceType;
            request()->merge($data);
        }

        $user = request()->user;
        $user['is_hq_user'] = true;
        $user['email_verified_at'] = now();
        $tenant = tenancy()->tenant;
        if (!isset($tenant)) {
            $tenant = $this->TenantModel()->where('props->product_type','Hq')->first();
            FacadesMicroTenant::tenantImpersonate($tenant);
        }
        request()->merge([
            'workspace_type' => 'Tenant',
            'workspace_id' => $tenant->getKey(),
            'user' => $user,
            'role_ids' => [$this->RoleModel()->where('name','Customer')->firstOrFail()->getKey()]
        ]);
        return $this->storeRegistration();
    }
}