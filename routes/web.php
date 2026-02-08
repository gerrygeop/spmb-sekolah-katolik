<?php

use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;
use App\Livewire\RegistrationWizard;

Route::get('/', WelcomeController::class)->name("welcome");

Route::get('/status', [PendaftaranController::class, 'index'])->name('status');
Route::get('/registration/{code}', [PendaftaranController::class, 'show'])->name('status.show');
Route::get('/registration/{code}/exam-card', [PendaftaranController::class, 'examCard'])->name('status.exam-card');

Route::middleware(['throttle:10,1'])->group(function () {
    Route::post('/status', [PendaftaranController::class, 'check'])->name('status.check');

    Route::get('/register', RegistrationWizard::class)->name('register');
    Route::get('/registration/{code}/edit', RegistrationWizard::class)->name('registration.edit');
});

Route::post('/payments/{registration}/upload', [PaymentController::class, 'upload'])
    ->middleware('throttle:5,1')
    ->name('payments.upload');
