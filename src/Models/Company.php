<?php

namespace Projects\Hq\Models;

use Hanafalah\ModulePayer\Models\Company as ModelsCompany;
use Hanafalah\ModuleUser\Concerns\UserReference\HasUserReference;
use Projects\Hq\Transformers\Company\{ViewCompany, ShowCompany};

class Company extends ModelsCompany
{
    use HasUserReference;

    protected $table = 'unicodes';

    public function viewUsingRelation(): array
    {
        return $this->mergeArray(parent::viewUsingRelation(),[]);
    }

    public function showUsingRelation(): array
    {
        return $this->mergeArray(parent::showUsingRelation(),[
            'stakeholder'
        ]);
    }

    public function getShowResource(){
        return ShowCompany::class;
    }

    public function getViewResource(){
        return ViewCompany::class;
    }

    public function stakeholder(){return $this->hasOneModel('Stakeholder');}
}
