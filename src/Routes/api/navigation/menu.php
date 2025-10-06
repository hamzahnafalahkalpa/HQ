<?php

use Illuminate\Support\Facades\Route;
use Projects\Hq\Controllers\API\Menu\MenuController;

Route::get('/menu',[MenuController::class,'index'])->name('menu.index');