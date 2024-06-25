<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                "name" => "Alvin",
                "email" => "admin@gmail.com",
                "password" => "admin123",
                "role_id" => 1,
                "gender" => "Laki-laki",
                "phone_number" => "085218273383",
                "isActive" => true,
            ],[
                "name" => "Budi",
                "email" => "budi@gmail.com",
                "password" => "budi123",
                "role_id" => 2,
                "gender" => "Laki-laki",
                "phone_number" => "081377263253",
                "isActive" => true,
            ],[
                "name" => "Nadya",
                "email" => "nadya@gmail.com",
                "password" => "nadya123",
                "role_id" => 3,
                "gender" => "Perempuan",
                "phone_number" => "085388937384",
                "isActive" => true,
            ],[
                "name" => "Diana",
                "email" => "diana@gmail.com",
                "password" => "diana123",
                "role_id" => 4,
                "gender" => "Perempuan",
                "phone_number" => "081222736482",
                "isActive" => true,
            ],[
                "name" => "Andi",
                "email" => "andi@gmail.com",
                "password" => "andi123",
                "role_id" => 2,
                "gender" => "Laki-laki",
                "phone_number" => "0837829382",
                "isActive" => true,
            ],[
                "name" => "Sally",
                "email" => "sally@gmail.com",
                "password" => "sally123",
                "role_id" => 2,
                "gender" => "Perempuan",
                "phone_number" => "08122736482",
                "isActive" => false,
            ],[
                "name" => "Dika",
                "email" => "dika@gmail.com",
                "password" => "dika123",
                "role_id" => 2,
                "gender" => "Laki-laki",
                "phone_number" => "088372732482",
                "isActive" => false,
            ],[
                "name" => "Anais",
                "email" => "anais@gmail.com",
                "password" => "anais123",
                "role_id" => 4,
                "gender" => "Laki-laki",
                "phone_number" => "088375842",
                "isActive" => true,
            ],[
                "name" => "Sheva",
                "email" => "sheva@gmail.com",
                "password" => "sheva123",
                "role_id" => 4,
                "gender" => "Perempuan",
                "phone_number" => "08999548382",
                "isActive" => true,
            ]];

            foreach ($data as $value) {
                User::insert([
                    'name' => $value['name'],
                    'email' => $value['email'],
                    'password'=> Hash::make($value['password']),
                    'role_id' => $value['role_id'],
                    'gender' => $value['gender'],
                    'phone_number' => $value['phone_number'],
                    'isActive' => $value['isActive'],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
    }
}
