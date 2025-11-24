<?php

namespace Projects\Hq\Models\ModulePayment;

use Hanafalah\ModulePayment\Models\Payment\PaymentSummary as PaymentPaymentSummary;
use Projects\Hq\Resources\ModulePaymentSummary\{
    ViewPaymentSummary,ShowPaymentSummary
};

class PaymentSummary extends PaymentPaymentSummary
{
    public function getShowResource(){
        return ShowPaymentSummary::class;
    }

    public function getViewResource(){
        return ViewPaymentSummary::class;
    }
}
