<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class Notification extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('notifications')->insert([
            [
                'id' => 1,               
                'title' => 'Giảm giá Dâu Tây 20%',
                'content' => 'Nhanh tay mua ngay, tăng vitaminC nào',           
                'image' => 'strawBerry.jpg',           
                'dateCreated' => Date('Y-m-d H:i:s'),           
            ],
        ]);
    }
}
