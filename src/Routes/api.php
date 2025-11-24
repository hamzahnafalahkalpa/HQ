<?php

use Hanafalah\ApiHelper\Facades\ApiAccess;
use Hanafalah\LaravelSupport\Facades\LaravelSupport;
use Illuminate\Support\Facades\Route;
use Projects\Hq\Controllers\API\Xendit\XenditController;
use Xendit\Configuration;

use Xendit\{
    Invoice\InvoiceApi,
    Invoice\CreateInvoiceRequest,
    XenditSdkException
};

ApiAccess::secure(function(){
    Route::group([
        'as' => 'api.'
    ],function(){
        LaravelSupport::callRoutes(__DIR__.'/api');

        Route::group([
            'prefix' => 'xendit',
            'as' => 'xendit.'
        ],function(){
            LaravelSupport::callRoutes(__DIR__.'/xendit');
        });
    });
});

Route::post('/xendit/paid',[XenditController::class,'store'])->name('api.xendit.paid');

Route::get('/cek/invoice',function(){
    Configuration::setXenditKey(env('XENDIT_SECRET_KEY'));
    $xendit_invoice = new InvoiceApi();
    return $xendit_invoice->getInvoices(null,request()->external_id);
});