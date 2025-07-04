<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\RseDashboardController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('/blog', function () {
    return Inertia::render('Blog');
})->name('blog');

Route::get('/subscription', function () {
    return Inertia::render('Subscription');
})->name('subscription');

Route::get('dashboard', [RseDashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// RSE Dashboard route (public access) - main route
Route::get('/rse', [RseDashboardController::class, 'index'])->name('rse.dashboard');

// Additional RSE routes for detailed functionality
Route::middleware(['auth'])->group(function () {
    Route::get('/rse/search', [RseDashboardController::class, 'search'])->name('rse.search');
    Route::get('/rse/company/{company}', [RseDashboardController::class, 'show'])->name('rse.company.show');
    Route::get('/documentation', function () {
        return Inertia::render('Documentation');
    })->name('documentation');
});

// Affichage de toutes les entreprises avec filtres et pagination
Route::get('/rse/companies', [RseDashboardController::class, 'companiesTable'])->name('rse.companies');

// Contact form for companies to improve their RSE score
Route::get('/contact', [ContactController::class, 'show'])->name('contact.show');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
require __DIR__.'/auth.php';
require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
