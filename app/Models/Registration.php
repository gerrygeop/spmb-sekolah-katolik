<?php

namespace App\Models;

use App\Enums\RegistrationStatus;
use App\Enums\UserRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Registration extends Model
{
    use HasFactory;

    protected $fillable = [
        'registration_batch_id',
        'registration_code',
        'school_level',
        'notes',
    ];

    protected $casts = [
        'school_level' => \App\Enums\SchoolLevel::class,
        'status' => \App\Enums\RegistrationStatus::class,
    ];

    public function student()
    {
        return $this->hasOne(StudentProfile::class);
    }

    public function parent()
    {
        return $this->hasOne(ParentProfile::class);
    }

    public function documents()
    {
        return $this->hasMany(RegistrationDocument::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function logs(): HasMany
    {
        return $this->hasMany(RegistrationLog::class);
    }

    public function batch(): BelongsTo
    {
        return $this->belongsTo(RegistrationBatch::class, 'registration_batch_id');
    }

    public function changeStatus(RegistrationStatus $toStatus, ?string $description = null, ?string $notes = null): void
    {
        $fromStatus = $this?->status;
        if ($fromStatus === $toStatus) return;

        $this->status = $toStatus;
        $this->notes = $notes;
        $this->save();

        $this->logs()->create([
            'user_id' => auth()->check() && auth()->user()->role === UserRole::ADMIN ? auth()->id() : null,
            'from_status' => $fromStatus,
            'to_status' => $toStatus,
            'description' => $description
        ]);
    }

    public static function createNew(
        int $batchId,
        string $schoolLevel,
        array $additionalData = []
    ): self {
        $registration = static::create(array_merge([
            'registration_batch_id' => $batchId,
            'registration_code' => 'REG-' . now()->format('Ymd') . '-' . Str::upper(Str::random(5)),
            'school_level' => $schoolLevel,
        ], $additionalData));

        // Set default values untuk field yang di-guard
        $registration->status = RegistrationStatus::PEMBAYARAN_TERTUNDA;
        $registration->total_amount = 150000;
        $registration->save();

        return $registration;
    }
}
