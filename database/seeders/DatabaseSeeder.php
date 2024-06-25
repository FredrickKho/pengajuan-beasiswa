<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            KategoriFakultasSeeder::class,
            KategoriJurusanSeeder::class,
            UserRoleSeeder::class,
            UserSeeder::class,
            PeriodSeeder::class,
            KategoriBeasiswaSeeder::class,
            MahasiswaSeeder::class,
            DekanSeeder::class,
            ProgramStudiSeeder::class,
        ]);
    }
}
