<?php

use App\Controllers\AssetController;
use App\Controllers\LoginController;
use App\Controllers\MainController;
use App\Controllers\TreeController;
use App\Middleware\AuthMiddleware as Auth;
use PXP\Core\Lib\Route;

Route::get('/')->do(MainController::class, 'index')
    ->middleware(Auth::class);
Route::get('/tree')->do(TreeController::class, 'tree')
    ->middleware(Auth::class);
Route::get('/tree/families')->do(TreeController::class, 'families')
    ->middleware(Auth::class);
Route::get('/tree/info')->do(TreeController::class, 'info')
    ->middleware(Auth::class);
Route::get('/tree/people/{id}')->do(TreeController::class, 'person')
    ->middleware(Auth::class);
Route::get('/tree/people/{id}/set-as-start')->do(TreeController::class, 'setStart')
    ->middleware(Auth::class);

Route::get('/login')->do(LoginController::class, 'form');
Route::post('/login')->do(LoginController::class, 'login');

Route::get('/logout')->do(LoginController::class, 'logout');
Route::post('/logout')->do(LoginController::class, 'logout');

Route::get('/css/{file}')->do(AssetController::class, 'css');
