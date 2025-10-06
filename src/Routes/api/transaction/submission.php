<?php

use Illuminate\Support\Facades\Route;

use Projects\Hq\Controllers\API\Transaction\Submission\{
    Billing\Invoice\InvoiceController,
    Billing\BillingController,
    SubmissionController
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

Route::apiResource('/submission',SubmissionController::class)->parameters(['submission' => 'id']);
Route::group([
    "prefix" => "/submission/{transaction_id}",
    'as' => 'submission.show.'
],function(){
    Route::apiResource('/billing',BillingController::class)->parameters(['billing' => 'id']);
    Route::group([
        "prefix" => "/billing/{billing_id}",
        'as' => 'billing.show.'
    ],function(){
        Route::apiResource('/invoice',InvoiceController::class)->parameters(['invoice' => 'id']);
    });
});