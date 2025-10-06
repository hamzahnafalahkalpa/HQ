<?php

namespace Projects\Hq\Schemas;

use Hanafalah\ModulePeople\Contracts\Data\PeopleData;
use Hanafalah\ModulePeople\Schemas\People;
use Illuminate\Database\Eloquent\Model;
use Projects\Hq\Contracts\Schemas\Stakeholder as ContractsStakeholder;
use Projects\Hq\Contracts\Data\StakeholderData;

class Stakeholder extends People implements ContractsStakeholder
{
    protected string $__entity = 'Stakeholder';
    public $stakeholder_model;
    //protected mixed $__order_by_created_at = false; //asc, desc, false

    protected array $__cache = [
        'index' => [
            'name'     => 'stakeholder',
            'tags'     => ['stakeholder', 'stakeholder-index'],
            'duration' => 24 * 60
        ]
    ];

    public function prepareStoreStakeholder(StakeholderData $stakeholder_dto): Model{
        $stakeholder = $this->prepareStorePeople($stakeholder_dto);
        return $this->stakeholder_model = $stakeholder;
    }

    protected function createPeople(PeopleData &$people_dto): Model{
        $people = $this->people()->updateOrCreate([
            'id' => $people_dto->id ?? null
        ], [
            'name'               => $people_dto->name,
            'dob'                => $people_dto->dob,
            'pob'                => $people_dto->pob,
            'company_id'          => $people_dto->company_id,
            'last_name'          => $people_dto->last_name,
            'first_name'         => $people_dto->first_name,
            'sex'                => $people_dto->sex ?? null,
            'blood_type'         => $people_dto->blood_type ?? null,
            'religion_id'        => $people_dto->religion_id ?? null,
            'country_id'         => $people_dto->country_id ?? null,
            'father_name'        => $people_dto->father_name ?? null,
            'mother_name'        => $people_dto->mother_name ?? null,
            'religion_id'        => $people_dto->religion_id ?? null,
            'last_education_id'  => $people_dto->last_education_id ?? null, 
            'total_children'     => $people_dto->total_children ?? null, 
            'marital_status_id'  => $people_dto->marital_status_id ?? null
        ]);

        $company_model = $this->CompanyModel();
        if (isset($people_dto->company_id)){
            $company = $company_model->findOrFail($people_dto->company_id);
        }
        $props = &$people_dto->props;
        $props['prop_company'] = $company->toViewApi()->resolve();
        return $people;
    }
}