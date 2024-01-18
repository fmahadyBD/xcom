<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


use App\Models\CmsPage;

class CmsPageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      $cmsPagesRecords=[
        ['id'=>1,'title'=>"About us",'description'=>'COnent is comming soon','url'=>'about-us',
         'meta_title'=>'About US','meta_description'=>'About uus Contetnt','meta_keywords'=>'About us','status'=>1
        ],

        ['id'=>2,'title'=>"Trems & Conditions",'description'=>'Trems & Conditions','url'=>'trems-conditions',
         'meta_title'=>'Trems & Conditions','meta_description'=>'Trems & Conditions Contetnt','meta_keywords'=>'Trems & Conditions','status'=>1
        ],
        ['id'=>3,'title'=>"Privicy Policy",'description'=>'COnent is comming soon','url'=>'privacy-policy',
         'meta_title'=>'Privacy  policy','meta_description'=>'Privicy Policy uus Contetnt','meta_keywords'=>'Privicy Policy','status'=>1
        ],
      ];
      CmsPage::insert($cmsPagesRecords);
    }
}
