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
        $gender = fake()->randomElement(['Laki-laki', 'Perempuan']);
        $firstName = $gender == 'Laki-laki' ? fake()->firstNameMale() : fake()->firstNameFemale();
        $lastName = fake()->lastName();

        $schools = [
            'SMP Santa Ursula', 'SMP Kanisius', 'SMP Pangudi Luhur', 'SMP Tarakanita 1', 
            'SMPK 1 BPK PENABUR', 'SMP Marsudirini', 'SMP Strada Santa Maria', 'SMP Mater Dei',
            'SMP Negeri 1 Jakarta', 'SMP Negeri 115 Jakarta', 'SMP Negeri 19 Jakarta'
        ];

        return [
            'full_name' => "$firstName $lastName",
            'nisn' => fake()->numerify('00########'), // NISN usually starts with 00 (year) and has 10 digits
            'email' => strtolower("$firstName.$lastName") . fake()->numerify('##') . '@gmail.com',
            'phone_number' => fake()->phoneNumber(),
            'gender' => $gender,
            'place_of_birth' => fake()->city(),
            'date_of_birth' => fake()->dateTimeBetween('-16 years', '-14 years')->format('Y-m-d'), // Typical age for SMA/SMK entry
            'address' => fake()->address(),
            'previous_school' => fake()->randomElement($schools),
        ];
    }
}
