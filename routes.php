<?php

use App\Controllers\AssetController;
use App\Controllers\FamilyController;
use App\Controllers\LoginController;
use App\Controllers\MainController;
use App\Controllers\PersonController;
use App\Controllers\TreeController;
use PXP\Http\Middleware\InteractiveAuth as Auth;
use PXP\Router\Route;

Route::get('/')->do(MainController::class, 'index')
    ->middleware(Auth::class);
Route::get('/tree')->do(TreeController::class, 'tree')
    ->middleware(Auth::class);
Route::get('/tree/families')->do(FamilyController::class, 'index')
    ->middleware(Auth::class);
Route::get('/tree/families/{id}')->do(FamilyController::class, 'show')
    ->middleware(Auth::class);
Route::get('/tree/families/{id}/add-parent')->do(FamilyController::class, 'addParent')
    ->middleware(Auth::class);
Route::get('/tree/families/{id}/add-child')->do(FamilyController::class, 'addChild')
    ->middleware(Auth::class);
Route::get('/tree/info')->do(TreeController::class, 'info')
    ->middleware(Auth::class);
Route::get('/tree/people/{id}')->do(PersonController::class, 'show')
    ->middleware(Auth::class);
Route::get('/tree/people/{id}/edit')->do(PersonController::class, 'edit')
    ->middleware(Auth::class);
Route::post('/tree/people/{id}')->do(PersonController::class, 'update')
    ->middleware(Auth::class);

Route::get('/login')->do(LoginController::class, 'form');
Route::post('/login')->do(LoginController::class, 'login');

Route::get('/logout')->do(LoginController::class, 'logout');
Route::post('/logout')->do(LoginController::class, 'logout');

Route::get('/css/{file}')->do(AssetController::class, 'css');
