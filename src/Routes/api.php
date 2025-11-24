<?php

use Hanafalah\ApiHelper\Facades\ApiAccess;
use Hanafalah\LaravelSupport\Facades\LaravelSupport;
use Illuminate\Support\Facades\Route;

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

Route::post('/xendit/paid',function(){
    \Log::channel('xendit')->info('Backbone: Xendit paid callback', [
        'payload' => request()->all(),
        'headers' => request()->headers->all()
    ]);
});

Route::get('/cek/invoice',function(){
    Configuration::setXenditKey(env('XENDIT_SECRET_KEY'));
    $xendit_invoice = new InvoiceApi();
    return $xendit_invoice->getInvoices(null,'97f13cff-1300-42c7-9713-3189d8f3f233');
});