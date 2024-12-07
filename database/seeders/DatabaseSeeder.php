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
        $this->call(CitiesTableSeeder::class);
        $this->call(DepartmentTableSeeder::class);
        $this->call(JobTitlesTableSeeder::class);
        $this->call(UsersTableSeeder::class); // EXAMPLE PURPOSE ONLY FOR TEST RECRUITMENT

    }
}
