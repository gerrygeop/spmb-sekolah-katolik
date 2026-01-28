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
            'registration_id' => \App\Models\Registration::factory(),
            'amount' => 150000,
            'status' => fake()->randomElement(['pending', 'success', 'failed', 'expired']),
            'snap_token' => fake()->uuid(),
            'order_id' => fake()->uuid(),
        ];
    }
}
