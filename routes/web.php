<?php

use App\Http\Controllers\AssetController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HandoverController;
use App\Http\Controllers\HandoverSignatureController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LendingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check() ? redirect()->route('dashboard') : redirect()->route('login');
});

Route::get('/dashboard', DashboardController::class)->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('users', UserController::class)->except(['show']);
    Route::resource('assets', AssetController::class);
    Route::resource('lendings', LendingController::class);
    Route::get('lendings/{lending}/return', [LendingController::class, 'returnForm'])->name('lendings.return');
    Route::patch('lendings/{lending}/return', [LendingController::class, 'returnStore'])->name('lendings.return.store');

    Route::resource('handovers', HandoverController::class);
    Route::get('handovers/{handover}/print', [HandoverController::class, 'print'])->name('handovers.print');
    Route::get('handovers/{handover}/return', [HandoverController::class, 'returnForm'])->name('handovers.return');
    Route::post('handovers/{handover}/return', [HandoverController::class, 'returnStore'])->name('handovers.return.store');
    Route::get('handovers/{handover}/redispatch', [HandoverController::class, 'redispatch'])->name('handovers.redispatch');

    // Signature management (auth required)
    Route::post('handovers/{handover}/signatures/generate', [HandoverSignatureController::class, 'generate'])->name('handovers.signatures.generate');
    Route::delete('handovers/{handover}/signatures/{role}/reset', [HandoverSignatureController::class, 'reset'])->name('handovers.signatures.reset');
});

// Public signing routes (no auth)
Route::get('/sign/{token}', [HandoverSignatureController::class, 'sign'])->name('sign');
Route::post('/sign/{token}', [HandoverSignatureController::class, 'store'])->name('sign.store');
Route::get('/sign/{token}/done', [HandoverSignatureController::class, 'done'])->name('sign.done');

require __DIR__.'/auth.php';

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
