<?php

namespace Projects\Hq\Schemas;

use Hanafalah\ModulePayer\Schemas\Company as SchemasCompany;
use Hanafalah\ModuleRegional\Enums\Address\Flag;
use Illuminate\Database\Eloquent\Model;
use Projects\Hq\Contracts\Schemas\Company as ContractsCompany;
use Projects\Hq\Contracts\Data\CompanyData;

class Company extends SchemasCompany implements ContractsCompany
{
    protected string $__entity = 'Company';
    public $company_model;
    //protected mixed $__order_by_created_at = false; //asc, desc, false

    public function prepareStoreCompany(mixed $company_dto): Model{
        $company = parent::prepareStoreCompany($company_dto);

        if (isset($company_dto->address)){
            $address = $company_dto->address;
            $address->model_type = $company->getMorphClass();
            $address->model_id   = $company->getKey();
            $company->setAddress(Flag::OTHER->value, $address);
        }

        if (isset($company_dto->stakeholder)){
            $stakeholder = &$company_dto->stakeholder;
            $stakeholder->company_id = $company->getKey();
            $this->schemaContract('stakeholder')->prepareStoreStakeholder($stakeholder);
        }
        return $this->company_model = $company;
    }
}