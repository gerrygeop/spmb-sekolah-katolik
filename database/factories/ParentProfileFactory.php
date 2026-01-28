<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ParentProfile>
 */
class ParentProfileFactory extends Factory
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
            'father_name' => fake()->name('male'),
            'father_phone' => fake()->phoneNumber(),
            'father_occupation' => fake()->jobTitle(),
            
            'mother_name' => fake()->name('female'),
            'mother_phone' => fake()->phoneNumber(),
            'mother_occupation' => fake()->jobTitle(),

            'guardian_name' => fake()->optional()->name(),
            'guardian_phone' => fake()->optional()->phoneNumber(),
            'guardian_occupation' => fake()->optional()->jobTitle(),
        ];
    }
}
