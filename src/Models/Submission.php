<?php

namespace Projects\Hq\Models;

use Hanafalah\ModulePayment\Concerns\HasPaymentSummary;
use Hanafalah\ModuleTransaction\Models\Submission as ModelsSubmission;
use Projects\Hq\Resources\Submission\ShowSubmission;
use Projects\Hq\Resources\Submission\ViewSubmission;

class Submission extends ModelsSubmission
{
    use HasPaymentSummary;

    protected $table = 'submissions';
    public $list = [
        'id',
        'reference_type',
        'reference_id',
        'name',
        'props',
    ];

    public function getViewResource(){
        return ViewSubmission::class;
    }

    public function getShowResource(){
        return ShowSubmission::class;
    }

    public function viewUsingRelation(): array{
        return ['paymentSummary','transaction'];
    }

    public function showUsingRelation(): array{
        return ['paymentSummary','transaction'];
    }

    public function workspace(){
        return $this->hasOneModel('Workspace','submission_id');
    }

    public function installedProductItem(){
        return $this->hasOneModel('InstalledProductItem');
    }
    public function installedProductItems(){
        return $this->hasManyModel('InstalledProductItem');
    }
    public function reference(){return $this->morphTo();}
}
