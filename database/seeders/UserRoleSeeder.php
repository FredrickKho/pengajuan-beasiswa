<?php

namespace Database\Seeders;

use App\Models\UserRole;

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['name' => 'Administrator'],
            ['name' => 'Mahasiswa'],
            ['name' => 'Dekan'],
            ['name' => 'Program Studi']
        ];

        foreach ($data as $value) {
            UserRole::insert([
                'name' => $value['name'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
