<?php

namespace Projects\Hq\Schemas\ModuleWorkspace;

use Hanafalah\ModuleWorkspace\Schemas\Workspace as SchemasWorkspace;
use Illuminate\Database\Eloquent\Model;
use Projects\Hq\Contracts\Schemas\ModuleWorkspace\Workspace as ModuleWorkspaceWorkspace;
use Illuminate\Support\Facades\Http;

class Workspace extends SchemasWorkspace implements ModuleWorkspaceWorkspace{
    public function prepareStoreWorkspace(mixed $workspace_dto): Model{
        $workspace = parent::prepareStoreWorkspace($workspace_dto);
        $workspace->product_id = $workspace_dto->product_id;
        if (isset($workspace_dto->installed_product_items) && count($workspace_dto->installed_product_items) > 0){
            foreach ($workspace_dto->installed_product_items as &$installed_product_item) {
                $installed_product_item->reference_type = $workspace->getMorphClass();
                $installed_product_item->reference_id = $workspace->getKey();
                $this->schemaContract('installed_product_item')->prepareStoreInstalledProductItem($installed_product_item);
            }
        }

        $tenant = $workspace->tenant;
        if (!isset($tenant) && $workspace_dto->status == 'ACTIVE'){
        // if (!isset($tenant)){
            $product_model = $workspace_dto->product_model;
            $app_tenant   = $this->TenantModel()->where('flag','APP')->where('props->product_type',$product_model->label)->firstOrFailWithMessage('App Tenant Not Found');
            $group_tenant = $this->TenantModel()->where('flag','CENTRAL_TENANT')->where('props->product_type',$product_model->label)->firstOrFailWithMessage('Group Tenant Not Found');
            $url = config('hq.backbone.url');
            try {
                $response = Http::withHeaders(request()->headers->all())
                    ->timeout(10)
                    ->post($url, [
                        'workspace_id'    => $workspace->getKey(),
                        'app_tenant_id'   => $app_tenant->getKey(),
                        'group_tenant_id' => $group_tenant->getKey(),
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
        $this->fillingProps($workspace,$workspace_dto->props);
        $workspace->save();
        return $this->workspace_model = $workspace;
    }
}