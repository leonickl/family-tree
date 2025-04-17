<?php

use App\Http\Controllers\FamilyController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TreeController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/tree', [TreeController::class, 'index'])->name('tree');
    Route::get('/families', [FamilyController::class, 'index'])->name('families');
    Route::get('/people', [PersonController::class, 'index'])->name('people');

    Route::get('/families/{id}', [FamilyController::class, 'show'])->name('family');
    Route::get('/people/{id}', [PersonController::class, 'show'])->name('person');
});

require __DIR__.'/auth.php';
