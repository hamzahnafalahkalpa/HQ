<?php

use Illuminate\Support\Facades\Route;
use Projects\Hq\Controllers\API\Transaction\Submission\SubmissionController;

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
Route::apiResource('/product-service',SubmissionController::class)->parameters(['product-service' => 'id']);
// Route::group([
//     "prefix" => "/product-service/{transaction_id}",
//     'as' => 'product-service.show.'
// ],function(){
//     Route::apiResource('/billing',BillingController::class)->parameters(['billing' => 'id']);
//     Route::group([
//         "prefix" => "/billing/{billing_id}",
//         'as' => 'billing.show.'
//     ],function(){
//         Route::apiResource('/invoice',InvoiceController::class)->parameters(['invoice' => 'id']);
//     });
// });