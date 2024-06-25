<?php

namespace Database\Seeders;

use App\Models\Period;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PeriodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => '2020, Odd Semester',
                'start_date' => Carbon::create(2020,1,1),
                'end_date' => Carbon::create(2020,6,1)
            ],[
                'name' => '2020, Even Semester',
                'start_date' => Carbon::create(2020,7,1),
                'end_date' => Carbon::create(2020,12,1)
            ],[
                'name' => '2020, Short Semester',
                'start_date' => Carbon::create(2020,4,1),
                'end_date' => Carbon::create(2020,8,1)
            ],[
                'name' => '2021, Odd Semester',
                'start_date' => Carbon::create(2021,1,1),
                'end_date' => Carbon::create(2021,6,1)
            ],[
                'name' => '2021, Even Semester',
                'start_date' => Carbon::create(2021,7,1),
                'end_date' => Carbon::create(2021,12,1)
            ],[
                'name' => '2021, Short Semester',
                'start_date' => Carbon::create(2021,4,1),
                'end_date' => Carbon::create(2021,8,1)
            ],[
                'name' => '2022, Odd Semester',
                'start_date' => Carbon::create(2022,1,1),
                'end_date' => Carbon::create(2022,6,1)
            ]
        ];
        foreach ($data as $value) {
            Period::insert([
                'name' => $value['name'],
                'start_date' => $value['start_date'],
                'end_date' => $value['end_date'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
