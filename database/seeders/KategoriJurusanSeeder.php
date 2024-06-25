<?php

namespace Database\Seeders;

use App\Models\KategoriJurusan;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KategoriJurusanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['name' => 'Manajemen'],
            ['name' => 'Ilmu Ekonomi'],
            ['name' => 'Akuntansi'],
            ['name' => 'Matematika'],
            ['name' => 'Teknik Informatika'],
            ['name' => 'Teknik Sipil'],
            ['name' => 'Global Bussiness Marketing'],
            ['name' => 'Kimia'],
            ['name' => 'Fisika'],
            ['name' => 'Dokter Gigi'],
            ['name' => 'Pendidikan Dokter'],
            ['name' => 'Ilmu Farmasi'],
            ['name' => 'Teknik Elektro'],
            ['name' => 'Teknik Mesin'],
            ['name' => 'Teknik Kimia'],
            ['name' => 'Arsitektur'],
            ['name' => 'Pertanian'],
            ['name' => 'Ilmu Keolahragaan'],
        ];

        foreach ($data as $value) {
            KategoriJurusan::insert([
                'name' => $value['name'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
