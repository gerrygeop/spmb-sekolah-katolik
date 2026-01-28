<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StudentProfile>
 */
class StudentProfileFactory extends Factory
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
            'full_name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'phone_number' => fake()->phoneNumber(),
            'gender' => fake()->randomElement(['Laki-laki', 'Perempuan']),
            'place_of_birth' => fake()->city(),
            'date_of_birth' => fake()->date(),
            'address' => fake()->address(),
            'nisn' => fake()->numerify('##########'),
            'previous_school' => fake()->company(),
        ];
    }
}
