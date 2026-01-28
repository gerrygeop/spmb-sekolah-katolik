<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Document>
 */
class DocumentFactory extends Factory
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
            'type' => fake()->randomElement(['kartu_keluarga', 'akte_kelahiran', 'ijazah']),
            'file_path' => 'documents/' . fake()->uuid() . '.pdf',
        ];
    }
}
