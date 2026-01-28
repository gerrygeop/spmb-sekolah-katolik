<?php

namespace App\Livewire;

use App\Enums\RegistrationStatus;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Registration;
use Illuminate\Support\Facades\DB;

class RegistrationWizard extends Component
{
    use WithFileUploads;

    public $currentStep = 1;
    public $totalSteps = 5;
    public $registrationCode;
    public $isEdit = false;

    // Step 1: School Level
    public $school_level;

    // Step 2: Student Profile
    public $full_name;
    public $email;
    public $phone_number;
    public $gender;
    public $place_of_birth;
    public $date_of_birth;
    public $address;
    public $nisn;
    public $previous_school;

    // Step 3: Parent Profile
    public $father_name;
    public $father_phone;
    public $father_occupation;
    public $mother_name;
    public $mother_phone;
    public $mother_occupation;
    public $guardian_name;
    public $guardian_phone;
    public $guardian_occupation;

    // Step 4: Documents
    public $document_kartu_keluarga;
    public $document_akte_kelahiran;
    public $document_ijazah;

    public function mount($code = null)
    {
        if ($code) {
            $registration = Registration::with(['student', 'parentProfile'])->where('registration_code', $code)->firstOrFail();

            if ($registration->status !== RegistrationStatus::PERBAIKAN) {
                abort(403, 'Pendaftaran tidak dapat diedit saat ini.');
            }

            $this->registrationCode = $code;
            $this->isEdit = true;
            $this->school_level = $registration->school_level;

            // Student
            $this->full_name = $registration->student->full_name;
            $this->email = $registration->student->email;
            $this->phone_number = $registration->student->phone_number;
            $this->gender = $registration->student->gender;
            $this->place_of_birth = $registration->student->place_of_birth;
            $this->date_of_birth = $registration->student->date_of_birth;
            $this->address = $registration->student->address;
            $this->nisn = $registration->student->nisn;
            $this->previous_school = $registration->student->previous_school;

            // Parent
            $this->father_name = $registration->parentProfile->father_name;
            $this->father_phone = $registration->parentProfile->father_phone;
            $this->father_occupation = $registration->parentProfile->father_occupation;
            $this->mother_name = $registration->parentProfile->mother_name;
            $this->mother_phone = $registration->parentProfile->mother_phone;
            $this->mother_occupation = $registration->parentProfile->mother_occupation;
            $this->guardian_name = $registration->parentProfile->guardian_name;
            $this->guardian_phone = $registration->parentProfile->guardian_phone;
            $this->guardian_occupation = $registration->parentProfile->guardian_occupation;
        }
    }

    public function validateStep($step)
    {
        if ($step == 1) {
            $this->validate([
                'school_level' => 'required|in:sd,smp,sma',
            ]);
        } elseif ($step == 2) {
            $this->validate([
                'full_name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone_number' => 'required|string|max:20',
                'gender' => 'required|in:Laki-laki,Perempuan',
                'place_of_birth' => 'required|string|max:255',
                'date_of_birth' => 'required|date',
                'address' => 'required|string',
                'nisn' => 'nullable|string|max:20',
                'previous_school' => 'nullable|string|max:255',
            ]);
        } elseif ($step == 3) {
            $this->validate([
                'father_name' => 'required|string|max:255',
                'father_phone' => 'required|string|max:20',
                'father_occupation' => 'required|string|max:255',
                'mother_name' => 'required|string|max:255',
                'mother_phone' => 'required|string|max:20',
                'mother_occupation' => 'required|string|max:255',
                'guardian_name' => 'nullable|string|max:255',
                'guardian_phone' => 'nullable|string|max:20',
                'guardian_occupation' => 'nullable|string|max:255',
            ]);
        } elseif ($step == 4) {
            $rules = [
                'document_kartu_keluarga' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
                'document_akte_kelahiran' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
                'document_ijazah' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            ];

            if ($this->isEdit) {
                $rules['document_kartu_keluarga'] = 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048';
                $rules['document_akte_kelahiran'] = 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048';
            }

            $this->validate($rules);
        }
    }

    public function nextStep()
    {
        $this->validateStep($this->currentStep);
        $this->currentStep++;
    }

    public function previousStep()
    {
        $this->currentStep--;
    }

    public function submit()
    {
        $this->validateStep($this->currentStep);

        DB::transaction(function () {
            if ($this->isEdit) {
                // Update Existing
                $registration = Registration::where('registration_code', $this->registrationCode)->firstOrFail();
                $registration->update([
                    'school_level' => $this->school_level,
                    'status' => RegistrationStatus::PERBAIKAN,
                ]);

                $registration->student()->update([
                    'full_name' => $this->full_name,
                    'email' => $this->email,
                    'phone_number' => $this->phone_number,
                    'gender' => $this->gender,
                    'place_of_birth' => $this->place_of_birth,
                    'date_of_birth' => $this->date_of_birth,
                    'address' => $this->address,
                    'nisn' => $this->nisn,
                    'previous_school' => $this->previous_school,
                ]);

                $registration->parentProfile()->update([
                    'father_name' => $this->father_name,
                    'father_phone' => $this->father_phone,
                    'father_occupation' => $this->father_occupation,
                    'mother_name' => $this->mother_name,
                    'mother_phone' => $this->mother_phone,
                    'mother_occupation' => $this->mother_occupation,
                    'guardian_name' => $this->guardian_name,
                    'guardian_phone' => $this->guardian_phone,
                    'guardian_occupation' => $this->guardian_occupation,
                ]);
            } else {
                // Create New
                $registration = Registration::create([
                    'registration_code' => 'REG-' . date('Y') . '-' . mt_rand(1000, 9999),
                    'school_level' => $this->school_level,
                    'status' => RegistrationStatus::PEMBAYARAN_TERTUNDA,
                    'total_amount' => 150000,
                ]);

                $registration->student()->create([
                    'full_name' => $this->full_name,
                    'email' => $this->email,
                    'phone_number' => $this->phone_number,
                    'gender' => $this->gender,
                    'place_of_birth' => $this->place_of_birth,
                    'date_of_birth' => $this->date_of_birth,
                    'address' => $this->address,
                    'nisn' => $this->nisn,
                    'previous_school' => $this->previous_school,
                ]);

                $registration->parentProfile()->create([
                    'father_name' => $this->father_name,
                    'father_phone' => $this->father_phone,
                    'father_occupation' => $this->father_occupation,
                    'mother_name' => $this->mother_name,
                    'mother_phone' => $this->mother_phone,
                    'mother_occupation' => $this->mother_occupation,
                    'guardian_name' => $this->guardian_name,
                    'guardian_phone' => $this->guardian_phone,
                    'guardian_occupation' => $this->guardian_occupation,
                ]);
            }

            // Save Documents (Upsert logic)
            $docs = [
                'kartu_keluarga' => $this->document_kartu_keluarga,
                'akte_kelahiran' => $this->document_akte_kelahiran,
                'ijazah' => $this->document_ijazah,
            ];

            foreach ($docs as $type => $file) {
                if ($file) {
                    $path = $file->store('documents', 'public');

                    if ($this->isEdit) {
                        $doc = $registration->documents()->where('type', $type)->first();
                        if ($doc) {
                            $doc->update(['file_path' => $path]);
                        } else {
                            $registration->documents()->create(['type' => $type, 'file_path' => $path]);
                        }
                    } else {
                        $registration->documents()->create(['type' => $type, 'file_path' => $path]);
                    }
                }
            }

            if ($this->isEdit) {
                return redirect()->route('status.show', ['code' => $registration->registration_code])->with('message', 'Data berhasil diperbarui!');
            }

            return redirect()->route('status.show', ['code' => $registration->registration_code])
                ->with('success', 'Pendaftaran berhasil diterima! Silakan selesaikan pembayaran di bawah ini.');
        });
    }

    public function render()
    {
        return view('livewire.registration-wizard')
            ->layout('components.layouts.landing');
    }
}
