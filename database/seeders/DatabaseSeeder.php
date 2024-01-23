<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {
        // after 16
        // $this->call(AdminsTableSeeder::class);
        // why in here problem?
        
        $this->call(CmsPageTableSeeder::class);
        $this->call(CategoryTableSeeder::class);
    }
}
