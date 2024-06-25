<?php

namespace Database\Seeders;

use App\Models\Mahasiswa;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'user_id' => '2',
                'jurusan_id' => '2',
            ],[
                'user_id' => '5',
                'jurusan_id' => '4',
            ],[
                'user_id' => '6',
                'jurusan_id' => '1',
            ],[
                'user_id' => '7',
                'jurusan_id' => '5',
            ],
        ];

        foreach ($data as $value) {
            Mahasiswa::insert([
                'user_id' => $value['user_id'],
                'jurusan_id' => $value['jurusan_id'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
