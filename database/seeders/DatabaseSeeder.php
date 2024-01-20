<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {
        // after 16
        $this->call(AdminsTableSeeder::class);
        // $this->call(CmsPageTableSeeder::class);
    }
}
