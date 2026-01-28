<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

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
            'registration_code' => 'REG-' . date('Y') . '-' . fake()->unique()->numerify('####'),
            'school_level' => fake()->randomElement(['sd', 'smp', 'sma']),
            'status' => fake()->randomElement(['draft', 'pending_payment', 'payment_verified', 'verification_pending', 'need_revision', 'approved', 'rejected']),
            'notes' => fake()->sentence(),
            'total_amount' => 150000,
        ];
    }
}
