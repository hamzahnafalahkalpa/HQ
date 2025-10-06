<?php

namespace Projects\Hq\Models;

use Hanafalah\ModulePeople\Models\People\People;
use Projects\Hq\Resources\Stakeholder\{
    ViewStakeholder,
    ShowStakeholder
};

class Stakeholder extends People
{  
    protected $table = 'peoples';

    protected $casts = [
        'company_id'  => 'string',
        'name'        => 'string',
        'first_name'  => 'string',
        'last_name'   => 'string',
        'sex'         => 'string'
    ];

    public function viewUsingRelation(): array{
        return [];
    }

    public function showUsingRelation(): array{
        return $this->mergeArray(parent::showUsingRelation(),[
            'company'
        ]);
    }

    public function getViewResource(){
        return ViewStakeholder::class;
    }

    public function getShowResource(){
        return ShowStakeholder::class;
    }

    public function company(){return $this->belongsToModel('Company');}
}
