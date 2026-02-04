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
            'father_name' => fake()->name('male'),
            'father_phone' => fake()->phoneNumber(),
            'father_occupation' => fake()->randomElement(['Karyawan Swasta', 'PNS', 'Wiraswasta', 'TNI/Polri', 'Guru', 'Dokter', 'Insinyur']),
            'mother_name' => fake()->name('female'),
            'mother_phone' => fake()->phoneNumber(),
            'mother_occupation' => fake()->randomElement(['Ibu Rumah Tangga', 'Karyawan Swasta', 'PNS', 'Wiraswasta', 'Guru', 'Perawat', 'Apoteker']),
            'guardian_name' => null,
            'guardian_phone' => null,
            'guardian_occupation' => null,
        ];
    }
}
