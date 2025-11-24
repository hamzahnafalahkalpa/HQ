<?php

namespace Projects\Hq\Models;

use Hanafalah\ModulePayment\Concerns\HasPaymentSummary;
use Hanafalah\ModuleTransaction\Models\Submission as ModelsSubmission;

class Submission extends ModelsSubmission
{
    use HasPaymentSummary;

    protected $table = 'submissions';

    public function viewUsingRelation(): array{
        return ['paymentSummary','transaction'];
    }

    public function showUsingRelation(): array{
        return ['paymentSummary','transaction'];
    }

    public function workspace(){
        return $this->hasOneModel('Workspace','submission_id');
    }
}
