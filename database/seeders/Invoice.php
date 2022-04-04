<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class Invoice extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = Date('Y-m-d h:i:s');
        DB::table('invoices')->insert([
            [  
                'id'=>  "HD202203161",             
                'userID' => 1,
                'employeeID' => 1,
                'shippingName' =>  'Huỳnh Tấn Nghĩa',
                'shippingPhone' => '0123456789',
                'shippingAddress' => 'Quận 6',
                'dateCreated' =>  '2022-03-06 12:45:30',
                 'isPaid' => 1,
                 'total' => 210000,
                'status' => -1,
            ],
            [  
                'id'=>  'HD202203162',             
                'userID' => 1,
                'employeeID' => 1,
                'shippingName' =>  'Hồ Văn Tuân',
                'shippingPhone' => '1234561231',
                'shippingAddress' => 'Quận 5',
                'dateCreated' =>  '2022-03-04 11:10:30',
                 'isPaid' => 1,
                 'total' => 120000,
                'status' => -1,
            ], 
            ]);
    }
}
