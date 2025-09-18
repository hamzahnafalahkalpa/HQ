<?php

use Hanafalah\LaravelSupport\Facades\LaravelSupport;
use Illuminate\Support\Facades\Route;

Route::group([
    'as' => 'api.'
],function(){
    LaravelSupport::callRoutes(__DIR__.'/api');
});