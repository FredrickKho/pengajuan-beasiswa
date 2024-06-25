<?php

namespace Database\Seeders;

use App\Models\Dekan;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DekanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'user_id' => '3',
                'fakultas_id' => '4',
                'status' => 'Ketua',
            ],
        ];

        foreach ($data as $value) {
            Dekan::insert([
                'user_id' => $value['user_id'],
                'fakultas_id' => $value['fakultas_id'],
                'status' => $value['status'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
