<?php

use App\Controllers\ExampleController;
use PXP\Core\Lib\Route;

Route::get('/')->do(ExampleController::class, 'index');
Route::get('/css/{file}')->do(AssetController::class, 'css');
