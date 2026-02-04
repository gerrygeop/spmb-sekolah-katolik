<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'proof_file' => 'payments/dummy-proof-' . fake()->numberBetween(1, 10) . '.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
