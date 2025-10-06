<?php

use Illuminate\Support\Facades\Route;
use Projects\Hq\Controllers\API\Navigation\Auth\UpdatePasswordController;

Route::apiResource('update-password',UpdatePasswordController::class)->only('store');