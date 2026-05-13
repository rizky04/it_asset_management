<?php

use App\Http\Controllers\HandoverController;
use App\Http\Controllers\HandoverSignatureController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check() ? redirect()->route('dashboard') : redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('handovers', HandoverController::class);

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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
