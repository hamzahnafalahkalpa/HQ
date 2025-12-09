<?php

namespace Projects\Hq\Data;

use Hanafalah\ModulePayment\Contracts\Data\PaymentSummaryData;
use Hanafalah\ModuleTransaction\Data\SubmissionData as ModuleTransactionDataSubmissionData;
use Projects\Hq\Contracts\Data\SubmissionData as DataSubmissionData;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;

class SubmissionData extends ModuleTransactionDataSubmissionData implements DataSubmissionData
{
    #[MapInputName('payment_summary')]
    #[MapName('payment_summary')]
    public ?PaymentSummaryData $payment_summary;
}