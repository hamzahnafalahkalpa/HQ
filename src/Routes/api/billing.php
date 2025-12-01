<?php

use Illuminate\Support\Facades\Route;

use Projects\Hq\Controllers\API\Billing\{
    BillingController
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

Route::apiResource('/billing',BillingController::class)->parameters(['billing' => 'id']);