<?php

namespace Database\Seeders;

use App\Models\ProgramStudi;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProgramStudiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'user_id' => '4',
                'program_studi_id' => 2,
            ],[
                'user_id' => '8',
                'program_studi_id' => 4,
            ],[
                'user_id' => '9',
                'program_studi_id' => 3,
            ],
        ];

        foreach ($data as $value) {
            ProgramStudi::insert([
                'user_id' => $value['user_id'],
                'program_studi_id' => $value['program_studi_id'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
