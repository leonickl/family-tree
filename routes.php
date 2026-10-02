<?php

use App\Controllers\FamilyController;
use App\Controllers\MainController;
use App\Controllers\PersonController;
use App\Controllers\TreeController;
use App\Middleware\RequireEditor;
use PXP\Auth\Controllers\LoginController;
use PXP\Auth\Controllers\RegisterController;
use PXP\Auth\Controllers\VerificationController;
use PXP\Auth\Middleware\InteractiveAuth;
use PXP\Auth\Middleware\VerifiedEmail;
use PXP\Http\Controllers\AssetController;
use PXP\Router\Route;

Route::get('/')->do(MainController::class, 'index')->name('main');

Route::group(
    Route::get('/tree')->do(TreeController::class, 'tree')->name('tree'),
    Route::get('/people/{id}')->do(PersonController::class, 'show'),
)
    ->middleware(InteractiveAuth::class)
    ->middleware(VerifiedEmail::class);

Route::group(
    Route::get('/tree/info')->do(TreeController::class, 'info'),
    Route::post('/tree/share')->do(TreeController::class, 'share')->name('share'),

    Route::get('/families')->do(FamilyController::class, 'index')->name('families'),
    Route::get('/families/{id}')->do(FamilyController::class, 'show'),
    Route::get('/families/{id}/add-parent')->do(FamilyController::class, 'addParent'),
    Route::get('/families/{id}/add-child')->do(FamilyController::class, 'addChild'),
    Route::get('/families/create-child')->do(FamilyController::class, 'createChild'),
    Route::get('/families/create-spousal')->do(FamilyController::class, 'createSpousal'),

    Route::get('/people')->do(PersonController::class, 'index')->name('people'),
    Route::get('/people/{id}/edit')->do(PersonController::class, 'edit'),
    Route::post('/people/{id}')->do(PersonController::class, 'update'),
)
    ->middleware(InteractiveAuth::class)
    ->middleware(VerifiedEmail::class)
    ->middleware(RequireEditor::class);

Route::get('/auth/register')->do(RegisterController::class, 'form')->name('register');
Route::post('/auth/register')->do(RegisterController::class, 'register');

Route::get('/auth/verify')->do(VerificationController::class, 'verify')->name('verify');

Route::get('/auth/login')->do(LoginController::class, 'form')->name('login');
Route::post('/auth/login')->do(LoginController::class, 'login');

Route::group(
    Route::get('/auth/logout')->do(LoginController::class, 'logout')->name('logout'),
    Route::post('/auth/logout')->do(LoginController::class, 'logout'),
)
    ->middleware(InteractiveAuth::class);

Route::get('/css/{file}')->do(AssetController::class, 'css')->name('css');
