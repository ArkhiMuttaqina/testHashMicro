<?php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('departments')->insert([
            [
                'id' => 1,
                'name' => 'DEPO SURABAYA',
                'status' => 'ACTIVE',
                'created_at' => '2024-09-05 22:48:06',
                'updated_at' => '2024-09-05 22:48:06',
            ],
            [
                'id' => 2,
                'name' => 'HRD & GA',
                'status' => 'ACTIVE',
                'created_at' => '2024-09-05 22:48:06',
                'updated_at' => '2024-09-05 22:48:06',
            ],
            [
                'id' => 3,
                'name' => 'MARKETING',
                'status' => 'ACTIVE',
                'created_at' => '2024-09-05 22:48:06',
                'updated_at' => '2024-09-05 22:48:06',
            ],
            [
                'id' => 4,
                'name' => 'PENGIRIMAN',
                'status' => 'ACTIVE',
                'created_at' => '2024-09-05 22:48:06',
                'updated_at' => '2024-09-05 22:48:06',
            ],
            [
                'id' => 5,
                'name' => 'SALES',
                'status' => 'ACTIVE',
                'created_at' => '2024-09-05 22:48:06',
                'updated_at' => '2024-09-05 22:48:06',
            ],
            [
                'id' => 6,
                'name' => 'WAREHOUSE',
                'status' => 'ACTIVE',
                'created_at' => '2024-09-05 22:48:06',
                'updated_at' => '2024-09-05 22:48:06',
            ]
        ]);
    }
}
