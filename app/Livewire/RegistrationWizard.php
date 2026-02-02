<?php

namespace App\Livewire;

use App\Enums\RegistrationStatus;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Registration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class RegistrationWizard extends Component
{
    use WithFileUploads;

    public $currentStep = 1;
    public $totalSteps = 5;
    public $isEdit = false;
    public bool $isSubmitting = false;

    // Step 1: School Level
    public $registrationCode;
    public $school_level;

    // Step 2: Student Profile
    public $studentProfileId;
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
    public $documents;
    public array $uploadedDocuments = [];
    public array $existingDocumentIds = [];
    public array $existingDocuments = [];

    public $payment;
    public $payment_proof;

    public $batch;
    public $batchId;

    public function mount($code = null)
    {
        $this->documents = \App\Models\Document::all();
        $batch = \App\Models\RegistrationBatch::query()
            ->active()
            ->first();

        $this->batch = $batch;
        $this->batchId = $batch?->id;

        // Jika bukan mode edit dan tidak ada batch aktif, tolak akses
        if (!$this->isEdit && !$this->batchId) {
            return redirect()->back();
        }

        if ($code) {
            $registration = Registration::with(['student', 'parent', 'payment', 'documents'])->where('registration_code', $code)->firstOrFail();

            abort_if($registration->status !== RegistrationStatus::PERBAIKAN, 403);

            foreach ($registration->documents as $doc) {
                $this->existingDocuments[$doc->document_id] = $doc->file_path;
                $this->uploadedDocuments[$doc->document_id] = null;
            }

            $this->payment = $registration->payment;

            $this->existingDocumentIds = $registration->documents
                ->pluck('document_id')
                ->toArray();

            $this->registrationCode = $code;
            $this->isEdit = true;
            $this->school_level = $registration->school_level->value;

            // Student
            $this->studentProfileId = $registration->student->id;

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
            $this->father_name = $registration->parent->father_name;
            $this->father_phone = $registration->parent->father_phone;
            $this->father_occupation = $registration->parent->father_occupation;
            $this->mother_name = $registration->parent->mother_name;
            $this->mother_phone = $registration->parent->mother_phone;
            $this->mother_occupation = $registration->parent->mother_occupation;
            $this->guardian_name = $registration->parent->guardian_name;
            $this->guardian_phone = $registration->parent->guardian_phone;
            $this->guardian_occupation = $registration->parent->guardian_occupation;
        }
    }

    public function hasUploadedFile($documentId): bool
    {
        return isset($this->uploadedDocuments[$documentId])
            && $this->uploadedDocuments[$documentId] instanceof TemporaryUploadedFile;
    }

    public function validateStep($step)
    {
        if ($step == 1) {
            $this->validate([
                'school_level' => ['required', 'in:smp,sma'],
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
                'nisn' => [
                    'required',
                    'string',
                    'max:10',
                    Rule::unique('student_profiles', 'nisn')
                        ->ignore(
                            $this->isEdit ? $this->studentProfileId : null
                        ),
                ],
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
            $rules = [];

            foreach ($this->documents as $document) {
                $key = "uploadedDocuments.{$document->id}";
                $hasExistingFile = $this->isEdit && in_array($document->id, $this->existingDocumentIds);
                $documentRules = ['file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'];

                if ($document->is_required && !$hasExistingFile) {
                    array_unshift($documentRules, 'required');
                } else {
                    array_unshift($documentRules, 'nullable');
                }

                $rules[$key] = $documentRules;
            }

            if ($this->isEdit) {
                $rules['payment_proof'] = 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048';
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
        if ($this->isSubmitting) return;

        if (!$this->isEdit) {
            $currentBatch = \App\Models\RegistrationBatch::query()->active()->first();
            if (!$currentBatch) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('submit', 'Pendaftaran telah ditutup saat Anda mengisi form.');
            }
            $this->batchId = $currentBatch->id;
        }

        $this->isSubmitting = true;
        $this->validateStep($this->currentStep);

        try {
            $registration = DB::transaction(function () {
                if ($this->isEdit) {
                    $registration = Registration::where('registration_code', $this->registrationCode)
                        ->lockForUpdate()
                        ->firstOrFail();

                    $registration->changeStatus(
                        RegistrationStatus::VERIFIKASI,
                        'Pendaftar mengedit data'
                    );

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

                    $registration->parent()->update([
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
                    $registration = Registration::createNew(
                        $this->batch,
                        $this->school_level
                    );

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

                    $registration->parent()->create([
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

                // Save Documents
                foreach ($this->uploadedDocuments as $documentId => $file) {
                    if (!$file) continue;

                    $old = $registration->documents()
                        ->where('document_id', $documentId)
                        ->first();

                    if ($old && $old->file_path) {
                        Storage::disk('public')->delete($old->file_path);
                    }

                    $path = $file->store('documents', 'public');
                    $registration->documents()->updateOrCreate(
                        ['document_id' => $documentId],
                        ['file_path' => $path]
                    );
                }

                // Bukti pembayaran
                if ($this->payment_proof && $this->isEdit) {
                    $path = $this->payment_proof->store('payment-proofs', 'public');
                    $oldPath = $registration->payment?->proof_file;

                    $registration->payment()->updateOrCreate(
                        ['registration_id' => $registration->id],
                        ['proof_file' => $path]
                    );

                    if ($oldPath) {
                        Storage::disk('public')->delete($oldPath);
                    }
                }

                return $registration;
            });

            return redirect()
                ->route('status.show', ['code' => $registration->registration_code])
                ->with(
                    $this->isEdit ? 'message' : 'success',
                    $this->isEdit
                        ? 'Data berhasil diperbarui!'
                        : 'Pendaftaran berhasil diterima! Silakan selesaikan pembayaran di bawah ini.'
                );
        } catch (\Throwable $th) {
            logger()->error('Error during registration submission: ' . $th->getMessage());
            return redirect()
                ->back()
                ->withInput()
                ->with('submit', 'Terjadi kesalahan saat memproses pendaftaran. Silakan coba lagi.');
        } finally {
            $this->isSubmitting = false;
        }
    }

    public function render()
    {
        return view('livewire.registration-wizard')
            ->layout('components.layouts.landing');
    }
}
