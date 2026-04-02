<?php

use App\Controllers\AssetController;
use App\Controllers\FamilyController;
use App\Controllers\LoginController;
use App\Controllers\MainController;
use App\Controllers\PersonController;
use App\Controllers\TreeController;
use PXP\Http\Middleware\InteractiveAuth as Auth;
use PXP\Router\Route;

Route::group(
    Route::get('/')->do(MainController::class, 'index'),

    Route::get('/tree')->do(TreeController::class, 'tree'),
    Route::get('/tree/info')->do(TreeController::class, 'info'),

    Route::get('/families')->do(FamilyController::class, 'index'),
    Route::get('/families/{id}')->do(FamilyController::class, 'show'),
    Route::get('/families/{id}/add-parent')->do(FamilyController::class, 'addParent'),
    Route::get('/families/{id}/add-child')->do(FamilyController::class, 'addChild'),
    Route::get('/families/create-child')->do(FamilyController::class, 'createChild'),
    Route::get('/families/create-spousal')->do(FamilyController::class, 'createSpousal'),

    Route::get('/people/{id}')->do(PersonController::class, 'show'),
    Route::get('/people/{id}/edit')->do(PersonController::class, 'edit'),
    Route::post('/people/{id}')->do(PersonController::class, 'update'),
)
    ->middleware(Auth::class);

Route::get('/login')->do(LoginController::class, 'form');
Route::post('/login')->do(LoginController::class, 'login');

Route::get('/logout')->do(LoginController::class, 'logout');
Route::post('/logout')->do(LoginController::class, 'logout');

Route::get('/css/{file}')->do(AssetController::class, 'css');
