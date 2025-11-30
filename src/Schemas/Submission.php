<?php

namespace Projects\Hq\Schemas;

use Hanafalah\ModuleTransaction\Schemas\Submission as SchemasSubmission;
use Illuminate\Database\Eloquent\Model;
use Projects\Hq\Contracts\Schemas\Submission as ContractsSubmission;

class Submission extends SchemasSubmission implements ContractsSubmission
{
    protected string $__entity = 'Submission';
    public $submission_model;

    public function prepareStoreSubmission(mixed $submission_dto): Model{
        $add = [
            'name' => $submission_dto->name,
            'reference_type' => $submission_dto->reference_type,
            'reference_id' => $submission_dto->reference_id
        ];
        $guard  = ['id' => $submission_dto->id];
        $create = [$guard, $add];

        $submission = $this->usingEntity()->updateOrCreate(...$create);

        if (isset($submission_dto->installed_product_items) && count($submission_dto->installed_product_items) > 0){
            foreach ($submission_dto->installed_product_items as &$installed_product_item) {
                $installed_product_item->submission_id = $submission->getKey();
                $this->schemaContract('installed_product_item')->prepareStoreInstalledProductItem($installed_product_item);
            }
        }

        $this->initPaymentSummary($submission_dto, $submission);
        $this->fillingProps($submission,$submission_dto->props);
        $submission->save();
        return $this->submission_model = $submission;
    }

    protected function initPaymentSummary(mixed &$dto, Model &$model): self{
        if (isset($dto->payment_summary)){
            $payment_summary_dto = &$dto->payment_summary;
            $payment_summary_dto->reference_type  = $model->getMorphClass();
            $payment_summary_dto->reference_id    = $model->getKey();
            $payment_summary_dto->transaction_id  = $model->transaction->getKey();
            $payment_summary_dto->reference_model = $model;
            
            $payment_summary = $this->schemaContract('payment_summary')->prepareStorePaymentSummary($payment_summary_dto);
            $model->setRelation('paymentSummary', $payment_summary);
            $payment_summary_dto->id = $payment_summary->getKey();            
        }
        return $this;
    }
}