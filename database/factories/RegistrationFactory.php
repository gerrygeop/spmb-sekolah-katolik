<?php

namespace Database\Factories;

use App\Enums\RegistrationStatus;
use App\Enums\SchoolLevel;
use App\Models\RegistrationBatch;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Registration>
 */
class RegistrationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'registration_batch_id' => RegistrationBatch::first()?->id ?? 1, 
            'registration_code' => 'REG-' . now()->format('Ymd') . '-' . Str::upper(Str::random(5)),
            'school_level' => fake()->randomElement(SchoolLevel::cases()),
            'status' => fake()->randomElement(RegistrationStatus::cases()),
            'notes' => fake()->optional(0.3)->sentence(),
            'total_amount' => 120000,
        ];
    }
}
