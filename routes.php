<?php

use App\Controllers\AssetController;
use App\Controllers\MainController;
use App\Controllers\TreeController;
use App\Controllers\LoginController;
use PXP\Core\Lib\Route;
use App\Middleware\AuthMiddleware as Auth;

Route::get('/')->do(MainController::class, 'index')
    ->middleware(Auth::class);
Route::get('/trees/{tree}')->do(TreeController::class, 'tree')
    ->middleware(Auth::class);
Route::get('/trees/{tree}/families')->do(TreeController::class, 'families')
    ->middleware(Auth::class);
Route::get('/trees/{tree}/info')->do(TreeController::class, 'info')
    ->middleware(Auth::class);
Route::get('/trees/{tree}/people/{id}')->do(TreeController::class, 'person')
    ->middleware(Auth::class);

Route::get('/login')->do(LoginController::class, 'form');
Route::post('/login')->do(LoginController::class, 'login');

Route::get('/logout')->do(LoginController::class, 'logout');
Route::post('/logout')->do(LoginController::class, 'logout');

Route::get('/css/{file}')->do(AssetController::class, 'css');
