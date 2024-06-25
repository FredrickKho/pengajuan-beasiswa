<?php

namespace Database\Seeders;

use App\Models\KategoriFakultas;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KategoriFakultasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['name' => 'Fakultas Biologi'],
            ['name' => 'Fakultas Ekonomika dan Bisnis'],
            ['name' => 'Fakultas Farmasi'],
            ['name' => 'Fakultas Filsafat'],
            ['name' => 'Fakultas Geografi'],
            ['name' => 'Fakultas Hukum'],
            ['name' => 'Fakultas Ilmu Budaya'],
            ['name' => 'Fakultas Ilmu Sosial dan Ilmu Politik'],
            ['name' => 'Fakultas Kedokteran Gigi'],
            ['name' => 'Fakultas Kedokteran Hewan'],
            ['name' => 'Fakultas Kedokteran, Kesehatan Masyarakat, dan Keperawatan'],
            ['name' => 'Fakultas Kehutanan'],
            ['name' => 'Fakultas Matematika dan Ilmu Pengetahuan Alam'],
            ['name' => 'Fakultas Pertanian'],
            ['name' => 'Fakultas Peternakan'],
            ['name' => 'Fakultas Psikologi'],
            ['name' => 'Fakultas Teknik'],
            ['name' => 'Fakultas Teknologi Pertanian'],
        ];

        foreach ($data as $value) {
            KategoriFakultas::insert([
                'name' => $value['name'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
