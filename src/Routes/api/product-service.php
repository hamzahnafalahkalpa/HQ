<?php

use Illuminate\Support\Facades\Route;
use Projects\Hq\Controllers\API\ProductService\ProductServiceController;
use Projects\Hq\Controllers\API\ProductService\{
    Submission\SubmissionController,
    License\LicenseController,
};

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::apiResource('/product-service',ProductServiceController::class)->parameters(['product-service' => 'id']);
Route::group([
    "prefix" => "/product-service/{product_service_id}",
    'as' => 'product-service.show.'
],function(){
    Route::apiResource('/submission',SubmissionController::class)->parameters(['submission' => 'id']);
    Route::apiResource('/license',LicenseController::class)->parameters(['license' => 'id']);
    // Route::apiResource('/invoice',InvoiceController::class)->parameters(['invoice' => 'id']);
});