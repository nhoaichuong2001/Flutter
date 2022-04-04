<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('employees')->insert([

            [
                'id'=> 1,
                'username'=> 'layer01',
                'password' => Hash::make('23112001'),
                'email' => 'russian2311@gmail.com',
                'fullName' => 'Nguyễn Hoài Chương',
                'address' => 'Gò vấp',
                'type' => 'admin',
                'phone' => '0123456789',
                'salary' =>10000000,
                'avatar' => 'avatar1.png',
                'status' => 1,
            ],

            [
                'id' => 2,
                'username' => 'layer02',
                'password' => Hash::make('987654321'),
                'email' => 'tuannghia@gmail.com',
                'fullName' => 'Huỳnh Tấn Nghĩa',
                'address' => 'Quận 6',
                'type' => 'NV kiểm kho',
                'phone' => '0123456789',
                'salary' =>10000000,
                 'avatar' => 'avatar2.png',
                'status' => 1,
            ],
            [
                'id' => 3,
                'username' => 'layer03',
                'password' => Hash::make('123456789'),
                'email' => 'vantuan@gmail.com',
                'fullName' => 'Hồ Văn Tuân',
                'address' => 'Quận 5',
                'type' => 'NV thanh toán',
                'phone' => '0123456789',
                'salary' =>10000000,
                 'avatar' => 'avatar3.png',
                'status' => 1,
            ],
           
        ]);
    }
}