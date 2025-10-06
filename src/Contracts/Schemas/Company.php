<?php

namespace Projects\Hq\Contracts\Schemas;

use Projects\Hq\Contracts\Data\CompanyData;
//use Projects\Hq\Contracts\Data\CompanyUpdateData;
use Hanafalah\LaravelSupport\Contracts\Supports\DataManagement;
use Hanafalah\ModulePayer\Contracts\Schemas\Company as SchemasCompany;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @see \Projects\Hq\Schemas\Company
 * @method mixed export(string $type)
 * @method self conditionals(mixed $conditionals)
 * @method array updateCompany(?CompanyData $company_dto = null)
 * @method Model prepareUpdateCompany(CompanyData $company_dto)
 * @method bool deleteCompany()
 * @method bool prepareDeleteCompany(? array $attributes = null)
 * @method mixed getCompany()
 * @method ?Model prepareShowCompany(?Model $model = null, ?array $attributes = null)
 * @method array showCompany(?Model $model = null)
 * @method Collection prepareViewCompanyList()
 * @method array viewCompanyList()
 * @method LengthAwarePaginator prepareViewCompanyPaginate(PaginateData $paginate_dto)
 * @method array viewCompanyPaginate(?PaginateData $paginate_dto = null)
 * @method array storeCompany(?CompanyData $company_dto = null)
 * @method Collection prepareStoreMultipleCompany(array $datas)
 * @method array storeMultipleCompany(array $datas)
 */

interface Company extends SchemasCompany{
    public function prepareStoreCompany(mixed $company_dto): Model;
}