<?php

namespace Projects\Hq\Controllers\API\Xendit\Transaction;

use Hanafalah\LaravelXendit\Facades\LaravelXendit;
use Projects\Hq\Controllers\API\Xendit\EnvironmentController;
use Illuminate\Http\Request;

class TransactionController extends EnvironmentController{
    public function store(Request $request){
        if (isset($request->subsquent_payment)){
            $parameters = $request->subsquent_payment;
            $parameters['type'] = 'subsquent_payment';
        }
        if (isset($request->one_time_payment)){
            $parameters = $request->one_time_payment;
            $parameters['type'] = 'one_time_payment';
        }
        return LaravelXendit::schemaContract('XTransaction')->storeXTransaction(
            $this->requestDTO(config('app.contracts.XTransactionData'),$parameters)
        );
    }
}