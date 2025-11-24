<?php

namespace Projects\Hq\Schemas;

use Hanafalah\ModuleTransaction\Schemas\Submission as SchemasSubmission;
use Illuminate\Database\Eloquent\Model;
use Projects\Hq\Contracts\Schemas\Submission as ContractsSubmission;
use Projects\Hq\Contracts\Data\SubmissionData;
use Illuminate\Support\Str;

use Xendit\{
    Invoice\InvoiceApi,
    Invoice\CreateInvoiceRequest,
    XenditSdkException
};

class Submission extends SchemasSubmission implements ContractsSubmission
{
    protected string $__entity = 'Submission';
    public $submission_model;

    public function prepareStoreSubmission(mixed $submission_dto): Model{
        $submission = parent::prepareStoreSubmission($submission_dto);

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
            $payment_summary->refresh();
            $model->setRelation('paymentSummary', $payment_summary);
            $payment_summary_dto->id = $payment_summary->getKey();
            $xendit_invoice = new InvoiceApi();
            $create_invoice_request = new CreateInvoiceRequest([
                // 'external_id' => $payment_summary_dto->id,
                'external_id' => Str::uuid()->toString(),
                'description' => $payment_summary->name,
                'amount' => 10100,
                'invoice_duration' => 10100,
                'currency' => 'IDR',
                'reminder_time' => 1
            ]);
            $for_user_id = null;
            try {
                $result = $xendit_invoice->createInvoice($create_invoice_request, $for_user_id);
                $result = $result->jsonSerialize();
                $payment_summary->xendit = $result;
                $payment_summary->save();
            } catch (XenditSdkException $e) {
                echo 'Exception when calling InvoiceApi->createInvoice: ', $e->getMessage(), PHP_EOL;
                echo 'Full Error: ', json_encode($e->getFullError()), PHP_EOL;
            }
        }
        return $this;
    }
}