<?php

use App\Controllers\ExampleController;
use App\Controllers\TreeController;
use App\Controllers\AssetController;
use PXP\Core\Lib\Route;

Route::get('/')->do(ExampleController::class, 'index');
Route::get('/tree/{tree}')->do(TreeController::class, 'tree');
Route::get('/tree/{tree}/families')->do(TreeController::class, 'families');

Route::get('/css/{file}')->do(AssetController::class, 'css');
