<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use App\Enums\RegistrationStatus;
use Illuminate\Http\Request;

class PendaftaranController extends Controller
{
    public function index()
    {
        return view('status.index');
    }

    public function show($code)
    {
        $registration = Registration::with([
            'student',
            'parent',
            'documents.document',
            'payment',
            'batch',
            'batch.selectionSchedules'
        ])
            ->where('registration_code', $code)
            ->firstOrFail();

        return view('status.show', compact('registration'));
    }

    public function examCard($code)
    {
        $registration = Registration::with([
            'student',
            'batch',
            'batch.selectionSchedules'
        ])
            ->where('registration_code', $code)
            ->firstOrFail();

        if ($registration->status !== RegistrationStatus::TERVERIFIKASI) {
            abort(403);
        }

        $schedule = $registration->selection_schedule;

        return view('status.exam-card', compact('registration', 'schedule'));
    }

    public function check(Request $request)
    {
        $valid = $request->validate([
            'registration_code' => 'required|exists:registrations,registration_code'
        ], [
            'registration_code.exists' => 'Nomor Pendaftaran tidak ditemukan'
        ]);

        return to_route('status.show', ['code' => $valid['registration_code']]);
    }
}
