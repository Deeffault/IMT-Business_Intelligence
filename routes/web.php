<?php

use App\Http\Controllers\RseDashboardController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Routes RSE protégées par authentification
Route::middleware(['auth'])->group(function () {
    Route::get('/rse', [RseDashboardController::class, 'index'])->name('rse.dashboard');
    Route::get('/rse/search', [RseDashboardController::class, 'search'])->name('rse.search');
    Route::get('/rse/company/{company}', [RseDashboardController::class, 'show'])->name('rse.company.show');
    Route::get('/rse/compare', [RseDashboardController::class, 'compare'])->name('rse.compare');
    Route::post('/rse/company/{company}/refresh', [RseDashboardController::class, 'refreshScore'])->name('rse.company.refresh');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
