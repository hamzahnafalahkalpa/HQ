<?php

namespace Projects\Hq\Contracts\Schemas;

use Projects\Hq\Contracts\Data\SubmissionData;
//use Projects\Hq\Contracts\Data\SubmissionUpdateData;
use Hanafalah\ModuleTransaction\Contracts\Schemas\Submission as SchemasSubmission;
use Illuminate\Database\Eloquent\Model;

/**
 * @see \Projects\Hq\Schemas\Submission
 * @method mixed export(string $type)
 * @method self conditionals(mixed $conditionals)
 * @method array updateSubmission(?SubmissionData $submission_dto = null)
 * @method Model prepareUpdateSubmission(SubmissionData $submission_dto)
 * @method bool deleteSubmission()
 * @method bool prepareDeleteSubmission(? array $attributes = null)
 * @method mixed getSubmission()
 * @method ?Model prepareShowSubmission(?Model $model = null, ?array $attributes = null)
 * @method array showSubmission(?Model $model = null)
 * @method Collection prepareViewSubmissionList()
 * @method array viewSubmissionList()
 * @method LengthAwarePaginator prepareViewSubmissionPaginate(PaginateData $paginate_dto)
 * @method array viewSubmissionPaginate(?PaginateData $paginate_dto = null)
 * @method array storeSubmission(?SubmissionData $submission_dto = null)
 * @method Collection prepareStoreMultipleSubmission(array $datas)
 * @method array storeMultipleSubmission(array $datas)
 */

interface Submission extends SchemasSubmission
{
    public function prepareStoreSubmission(mixed $submission_dto): Model;
}