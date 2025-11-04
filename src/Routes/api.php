<?php

use Hanafalah\ApiHelper\Facades\ApiAccess;
use Hanafalah\LaravelSupport\Facades\LaravelSupport;
use Illuminate\Support\Facades\Route;

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