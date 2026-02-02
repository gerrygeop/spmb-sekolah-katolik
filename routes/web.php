<?php

use App\Http\Controllers\PaymentController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;
use App\Livewire\RegistrationWizard;

Route::get('/', WelcomeController::class)->name("welcome");

Route::middleware(['throttle:10,1'])->group(function () {
    Route::get('/register', RegistrationWizard::class)->name('register');
    Route::get('/registration/{code}/edit', RegistrationWizard::class)->name('registration.edit');
});

Route::get('/status', function () {
    return view('status.index');
})->name('status');

Route::post('/status', function (\Illuminate\Http\Request $request) {
    $request->validate(['registration_code' => 'required|exists:registrations,registration_code']);
    return redirect()->route('status.show', ['code' => $request->registration_code]);
})
    ->middleware('throttle:10,1')
    ->name('status.check');

Route::get('/registration/{code}', function ($code) {
    $registration = \App\Models\Registration::with([
        'student',
        'parent',
        'documents.document',
        'payment',
        'batch'
    ])
        ->where('registration_code', $code)
        ->firstOrFail();

    return view('status.show', compact('registration'));
})->name('status.show');

// Payment Routes
Route::post('/payments/{registration}/upload', [PaymentController::class, 'upload'])
    ->middleware('throttle:5,1')
    ->name('payments.upload');
