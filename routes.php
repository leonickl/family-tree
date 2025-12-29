<?php

use App\Controllers\AssetController;
use App\Controllers\MainController;
use App\Controllers\TreeController;
use PXP\Core\Lib\Route;

Route::get('/')->do(MainController::class, 'index');
Route::get('/trees/{tree}')->do(TreeController::class, 'tree');
Route::get('/trees/{tree}/families')->do(TreeController::class, 'families');
Route::get('/trees/{tree}/info')->do(TreeController::class, 'info');

Route::get('/css/{file}')->do(AssetController::class, 'css');
