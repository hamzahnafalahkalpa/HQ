<?php

namespace Projects\Hq\Models\ModuleWorkspace;

use Hanafalah\ModuleLicense\Concerns\HasLicense;
use Hanafalah\ModuleLicense\Concerns\HasModelHasLicense;
use Hanafalah\ModulePayment\Concerns\HasPaymentSummary;
use Hanafalah\ModuleTransaction\Concerns\HasTransaction;
use Hanafalah\ModuleWorkspace\Models\Workspace\Workspace as WorkspaceWorkspace;
use Projects\Hq\Resources\Workspace\ShowWorkspace;
use Projects\Hq\Resources\Workspace\ViewWorkspace;

class Workspace extends WorkspaceWorkspace
{
    use HasPaymentSummary, HasTransaction, HasLicense, HasModelHasLicense;

    public static function bootHasTransaction()
    {
        static::created(function ($query) {
            //OVERRIDE CREATED
        });
    }

    protected $list = [
        'id', 'uuid', 'name', 'owner_id', 'product_id', 'submission_id', 'status', 'props'
    ];  

    public function viewUsingRelation(): array{
        return ['tenant'];
    }

    public function showUsingRelation(): array{
        return ['tenant','address','product','installedProductItems','installedFeatures'];
    }

    public function getShowResource(){
        return ShowWorkspace::class;
    }

    public function getViewResource(){
        return ViewWorkspace::class;
    }

    public function tenant(){return $this->morphOneModel('Tenant','reference');}
    public function product(){return $this->belongsToModel('Product','product_id');}
    public function submission(){return $this->belongsToModel('Submission','submission_id');}    
    public function installedFeatures(){
        return $this->morphManyModel('InstalledFeature','model');
    }
    public function installedProductItem(){
        return $this->morphOneModel('InstalledProductItem','reference');
    }
    public function installedProductItems(){
        return $this->morphManyModel('InstalledProductItem','reference');
    }
}
