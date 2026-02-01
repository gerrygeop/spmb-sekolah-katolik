<?php

namespace Database\Seeders;

use App\Models\Document;
use App\Models\RegistrationBatch;
use App\Models\User;
use Carbon\Carbon;
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

        $now = Carbon::now();
        $yearLabel = $now->year . '-' . ($now->year + 1);

        RegistrationBatch::create([
            'name' => 'Penerimaan Peserta Didik Baru ' . $yearLabel,
            'slug' => str()->slug('ppdb-' . $yearLabel),
            'registration_start' => $now->copy()->startOfDay(),
            'registration_end' => $now->copy()->addMonths(2)->endOfDay(),
            'is_active' => true,
            'description' => 'Pendaftaran peserta didik baru tahun ajaran '
                . $now->year . '/' . ($now->year + 1),

            'timeline' => [
                [
                    'title' => 'Pendaftaran Online',
                    'start_date' => $now->copy()->startOfDay(),
                    'end_date' => $now->copy()->addMonths(2)->endOfDay(),
                ],
                [
                    'title' => 'Verifikasi Dokumen',
                    'start_date' => $now->copy()->addMonths(2)->addDays(1)->startOfDay(),
                    'end_date' => $now->copy()->addMonths(2)->addDays(10)->endOfDay(),
                ],
                [
                    'title' => 'Tes Seleksi',
                    'start_date' => $now->copy()->addMonths(3)->startOfDay(),
                    'end_date' => $now->copy()->addMonths(3)->addDays(5)->endOfDay(),
                ],
                [
                    'title' => 'Pengumuman Hasil',
                    'start_date' => $now->copy()->addMonths(3)->addDays(10)->startOfDay(),
                    'end_date' => null,
                ],
                [
                    'title' => 'Daftar Ulang',
                    'start_date' => $now->copy()->addMonths(3)->addDays(11)->startOfDay(),
                    'end_date' => $now->copy()->addMonths(4)->endOfDay(),
                ],
            ],
        ]);
    }
}
