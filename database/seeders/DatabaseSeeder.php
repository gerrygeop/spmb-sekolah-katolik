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

        $batch = RegistrationBatch::create([
            'name' => 'Penerimaan Peserta Didik Baru ' . $yearLabel,
            'slug' => str()->slug('ppdb-' . $yearLabel),
            'registration_start' => $now->copy()->startOfDay(),
            'registration_end' => $now->copy()->addMonths(2)->endOfDay(),
            'is_active' => true,
            'registration_fee' => 120000,
            'description' => 'Pendaftaran peserta didik baru tahun ajaran ' . $now->year . '/' . ($now->year + 1),
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

        // Create Selection Schedules based on the timeline manually or systematically
        $batch->selectionSchedules()->createMany([
            [
                'title' => 'Tes Tertulis Gelombang 1',
                'scheduled_at' => $now->copy()->addMonths(3)->addDays(1)->setHour(8)->setMinute(0),
                'end_time' => $now->copy()->addMonths(3)->addDays(1)->setHour(12)->setMinute(0),
                'location' => 'Aula Utama Sekolah Katolik',
                'requirements' => 'Membawa alat tulis dan kartu ujian',
            ],
        ]);

        // Generate Registrations
        // $faker = \Faker\Factory::create();
        // for ($i = 0; $i < 50; $i++) {
        //     // Random created_at between start and end of batch
        //     $createdAt = $faker->dateTimeBetween($batch->registration_start, $batch->registration_end);

        //     $registration = \App\Models\Registration::factory()->create([
        //         'registration_batch_id' => $batch->id,
        //         'created_at' => $createdAt,
        //         'updated_at' => $createdAt,
        //     ]);

        //     \App\Models\StudentProfile::factory()->create([
        //         'registration_id' => $registration->id,
        //     ]);

        //     \App\Models\ParentProfile::factory()->create([
        //         'registration_id' => $registration->id,
        //     ]);

        //     // Payment logic
        //     // If status is NOT PEMBAYARAN_TERTUNDA, payment is required with proof
        //     if ($registration->status !== \App\Enums\RegistrationStatus::PEMBAYARAN_TERTUNDA) {
        //         \App\Models\Payment::factory()->create([
        //             'registration_id' => $registration->id,
        //             'created_at' => Carbon::parse($createdAt)->addDays(rand(0, 3)), // Payment made shortly after registration
        //             'updated_at' => Carbon::parse($createdAt)->addDays(rand(0, 3)),
        //         ]);
        //     }
        // }
    }
}
