<?php

namespace Database\Seeders;

use App\Models\Document;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'role' => \App\Enums\UserRole::ADMIN->value,
        ]);

        Document::insert([
            [
                'name' => 'Ijazah / Raport Terakhir',
                'is_required' => true,
            ],
            [
                'name' => 'Kartu Keluarga',
                'is_required' => true,
            ],
            [
                'name' => 'Akta Kelahiran',
                'is_required' => true,
            ]
        ]);
    }
}
