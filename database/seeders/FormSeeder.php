<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use App\Models\User;
use App\Models\HSE\hseLocation;

class FormSeeder extends Seeder
{
    public function run(): void
    {
        // Membuat instance Faker
        $faker = Faker::create('id_ID');

        // Menambahkan form secara banyak
        for ($i = 1; $i <= 200; $i++) {
            $createdDate = $faker->dateTimeBetween('2024-01-01', '2025-12-31');
            $updatedDate = (clone $createdDate);
            DB::table('forms')->updateOrInsert(
            ['id' => $i],
            [
                'user_id' => User::inRandomOrder()->first()->id, // User acak
                'status' => $faker->randomElement(['Approved', 'Finished', 'Draft', 'In Review', 'In Approval', 'In Evaluation']), // 'Approved', 'Finished', 'Draft', 'In Review', 'In Approval', 'In Evaluation'
                'created_at' => $createdDate,
                'updated_at' => $updatedDate,
            ]);
        }

        $forms = DB::table('forms')->get();

        // Loop untuk mengisi data ke tabel project_executor
        foreach ($forms as $form) {
            // Ambil lokasi acak dari tabel hse_locations
            $location = hseLocation::inRandomOrder()->first(); // Mengambil lokasi acak

            DB::table('project_executors')->updateOrInsert(
            ['form_id' => $form->id], // Kondisi pencarian (form_id)
            [
                'company_department' => $faker->company, // Acak nama perusahaan/departemen
                'hp_number' => $faker->numerify('08###########'), // Nomor telepon acak
                'start_date' => Carbon::parse($form->created_at)->addDays(7), // Tanggal mulai
                'end_date' => Carbon::parse($form->created_at)->addDays(14), // Tanggal selesai
                'supervisor' => $faker->name, // Nama supervisor acak
                'location' => $location ? $location->name : null, // Ambil nama lokasi dari tabel hse_locations
                'start_time' => $faker->time('H:i'), // Waktu mulai acak
                'end_time' => $faker->time('H:i'), // Waktu selesai acak
                'workers_count' => $faker->numberBetween(5, 50), // Jumlah pekerja acak
                'work_description' => $faker->sentence(10), // Deskripsi pekerjaan acak
                'created_at' => now(), // Timestamp untuk created_at
                'updated_at' => now(), // Timestamp untuk updated_at
            ]);
        }

        foreach($forms as $form){
            if($form->status === 'In Evaluation'){
                DB::table('job_evaluations')->updateOrInsert(
                ['form_id' => $form->id], 
                [
                    'hse_rating' => null,
                    'engineering_rating' => null,
                    'total_rating' => null,
                    'created_at' => now(), // Timestamp untuk created_at
                    'updated_at' => now(), // Timestamp untuk updated_at
                ]);
            }else if($form->status === 'Finished'){
                $rating1 = $faker->randomFloat(1, 0, 5);
                $rating2 = $faker->randomFloat(1, 0, 5);
                DB::table('job_evaluations')->updateOrInsert(
                ['form_id' => $form->id], 
                [
                    'hse_rating' => $rating1, // Angka acak dengan 2 desimal antara 0 dan 10
                    'engineering_rating' => $rating2, // Angka acak dengan 2 desimal antara 0 dan 10
                    'total_rating' => ($rating1 + $rating2)/2,
                    'created_at' => now(), // Timestamp untuk created_at
                    'updated_at' => now(), // Timestamp untuk updated_at
                ]);
            }
        }
        
    }
}
