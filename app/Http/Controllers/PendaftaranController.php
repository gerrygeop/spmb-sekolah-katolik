<?php

namespace App\Http\Controllers;

use App\Models\Registration;
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
