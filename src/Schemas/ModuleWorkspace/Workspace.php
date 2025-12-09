<?php

namespace Projects\Hq\Schemas\ModuleWorkspace;

use Hanafalah\ModuleWorkspace\Schemas\Workspace as SchemasWorkspace;
use Illuminate\Database\Eloquent\Model;
use Projects\Hq\Contracts\Schemas\ModuleWorkspace\Workspace as ModuleWorkspaceWorkspace;
use Illuminate\Support\Facades\Http;

class Workspace extends SchemasWorkspace implements ModuleWorkspaceWorkspace{
    protected function prepareUpdateCreate(mixed $workspace_dto){
        $add = [
            'name'   => $workspace_dto->name, 
            'status' => $workspace_dto->status,
            'owner_id' => $workspace_dto->owner_id,
            'submission_id' => $workspace_dto->submission_id,
        ];
        if (isset($workspace_dto->uuid)){
            $guard = ['uuid' => $workspace_dto->uuid];
            $create = [$guard,$add];
        }else{
            $create = [$add];
        }
        return $this->usingEntity()->updateOrCreate(...$create);
    }

    public function prepareStoreWorkspace(mixed $workspace_dto): Model{
        $workspace = parent::prepareStoreWorkspace($workspace_dto);

        $tenant = tenancy()->tenant;
        if (isset($tenant) && $tenant->flag == 'APP') {
            $transaction = app(config('app.contracts.Transaction'))
                ->prepareStoreTransaction($this->requestDTO(config('app.contracts.TransactionData'),[
                    'reference_model' => $workspace,
                    'reference_id' => $workspace->getKey(),
                    'reference_type' => $workspace->getMorphClass()
                ]));
            $workspace->prop_transaction = $transaction->toViewApi()->resolve();
        }

        if (isset($workspace_dto->product_id)){
            $workspace->product_id = $workspace_dto->product_id;
            if (isset($workspace_dto->installed_product_items) && count($workspace_dto->installed_product_items) > 0){
                foreach ($workspace_dto->installed_product_items as &$installed_product_item) {
                    $installed_product_item->reference_type = $workspace->getMorphClass();
                    $installed_product_item->reference_id = $workspace->getKey();
                    $installed_product_item->submission_id = $workspace->submission_id;
                    $this->schemaContract('installed_product_item')->prepareStoreInstalledProductItem($installed_product_item);
                }
            }
            if (isset($workspace_dto->installed_features) && count($workspace_dto->installed_features) > 0){
                foreach ($workspace_dto->installed_features as &$installed_feature_dto) {
                    $installed_feature_dto->model_type = $workspace->getMorphClass();
                    $installed_feature_dto->model_id = $workspace->getKey();
                    $installed_feature = $this->schemaContract('installed_feature')->prepareStoreInstalledFeature($installed_feature_dto);
                }
            }
    
            $tenant = $workspace->tenant;
            if (!isset($tenant) && $workspace_dto->status == 'ACTIVE'){
                $workspace_dto->workspace_model = $workspace;
                $this->generateTenant($workspace_dto);
            }
        }
        $this->fillingProps($workspace,$workspace_dto->props);
        $workspace->save();
        return $this->workspace_model = $workspace;
    }

    public function generateTenant(mixed $workspace_dto): void{
        $workspace     = $workspace_dto->workspace_model;

        $this->InstalledProductItemModel()
            ->where('reference_type',$workspace->getMorphClass())
            ->where('reference_id',$workspace->getKey())
            ->where('status','DRAFT')
            ->update([
                'status' => 'ACTIVE'
            ]);

        $now = now();
        $this->schemaContract('license')->prepareStoreLicense($this->requestDTO(
            config('app.contracts.LicenseData'),[
                'reference_type' => $workspace->getMorphClass(),
                'reference_id'   => $workspace->getKey(),
                'expired_at' => $now->addMonth(),
                'billing_generated_at' => $now,
                'is_billing_generated' => false,
                'last_paid' => $now,
                'status' => 'ACTIVE',
                'recurring_type' => 'MONTHLY',
                'flag' => 'WORKSPACE_LICENSE',
                'model_has_license' => [
                    'model_type' => $workspace->getMorphClass(),
                    'model_id'   => $workspace->getKey(),
                ]
            ]
        ));
        $product_model = $workspace_dto->product_model ?? $workspace->product;
        $app_tenant    = $this->TenantModel()->where('flag','APP')->where('props->product_type',$product_model->label)->firstOrFailWithMessage('App Tenant Not Found');
        $group_tenant  = $this->TenantModel()->where('flag','CENTRAL_TENANT')->where('props->product_type',$product_model->label)->firstOrFailWithMessage('Group Tenant Not Found');
        $url           = config('hq.backbone.url');
        try {
            $response = Http::withHeaders(array_merge(request()->headers->all(),[
                'Accept' => '*/*'
            ]))
            ->timeout(10)
            ->post($url, [
                'workspace_id'    => $workspace->getKey(),
                'workspace_name'  => $workspace->name,
                'workspace_data'  => $workspace->toViewApi()->resolve(),
                'product_label'   => $product_model->label,
                'app_tenant_id'   => $app_tenant->getKey(),
                'group_tenant_id' => $group_tenant->getKey(),
                'admin'           => $workspace->admin
            ]);

            // Kalau status bukan 2xx, lempar exception
            if ($response->failed()) {
                throw new \RuntimeException(
                    "Backbone API call failed with status {$response->status()}: {$response->body()}"
                );
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}