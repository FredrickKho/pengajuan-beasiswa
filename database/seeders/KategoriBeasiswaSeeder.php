<?php

namespace Database\Seeders;

use App\Models\KategoriBeasiswa;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class KategoriBeasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['name' => 'Beasiswa Prestasi'],
            ['name' => 'Bantuan Ekonomi'],
            ['name' => 'Bantuan Sekolah'],
            ['name' => 'ASEAN 2024'],
        ];

        foreach ($data as $value) {
            KategoriBeasiswa::insert([
                'name' => $value['name'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
