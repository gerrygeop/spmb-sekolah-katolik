<?php

use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;
use App\Livewire\RegistrationWizard;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/register', RegistrationWizard::class)->name('register');

Route::get('/registration/{code}/edit', RegistrationWizard::class)->name('registration.edit');

Route::get('/status', function () {
    return view('status.index');
})->name('status');

Route::post('/status', function (\Illuminate\Http\Request $request) {
    $request->validate(['registration_code' => 'required|exists:registrations,registration_code']);
    return redirect()->route('status.show', ['code' => $request->registration_code]);
})->name('status.check');

Route::get('/registration/{code}', function ($code) {
    $registration = \App\Models\Registration::with(['student', 'parentProfile', 'documents', 'payment'])
        ->where('registration_code', $code)
        ->firstOrFail();

    return view('status.show', compact('registration'));
})->name('status.show');

// Payment Routes
Route::post('/payment/snap-token', [PaymentController::class, 'getToken'])->name('payment.snap-token');
Route::post('/payment/callback', [PaymentController::class, 'handleCallback'])->name('payment.callback');
Route::post('/payment/notification', [PaymentController::class, 'handleNotification'])->name('payment.notification');
