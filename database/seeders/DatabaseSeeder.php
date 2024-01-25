<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {
        // after 16
        // why in here problem?

        // $this->call(AdminsTableSeeder::class);
        // $this->call(CmsPageTableSeeder::class);
        // $this->call(CategoryTableSeeder::class);
        $this->call(ProductsTableSeeder::class);
    }
}
