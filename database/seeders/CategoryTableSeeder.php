<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // parent id will be sub amdin category, cloth id is 1, that's why men,women,kids parent id is 1
       $categoryRecord=[
        [
            'id'=>1,'parent_id'=>0,'category_name'=>'Clothing',
            'category_image'=>'','category_discount'=>'',
            'description'=>'','url'=>'clothing','meta_title'=>'',
            'meta_description'=>'','meta_keywords'=>'',
            'status'=>1,
        ],
        [
            'id'=>2,'parent_id'=>1,'category_name'=>'Men',
            'category_image'=>'','category_discount'=>'',
            'description'=>'','url'=>'men','meta_title'=>'',
            'meta_description'=>'','meta_keywords'=>'',
            'status'=>1,
        ],
        [
            'id'=>3,'parent_id'=>1,'category_name'=>'Women',
            'category_image'=>'','category_discount'=>'',
            'description'=>'','url'=>'women','meta_title'=>'',
            'meta_description'=>'','meta_keywords'=>'',
            'status'=>1,
        ],
        [
            'id'=>4,'parent_id'=>1,'category_name'=>'Kids',
            'category_image'=>'','category_discount'=>'',
            'description'=>'','url'=>'kids','meta_title'=>'',
            'meta_description'=>'','meta_keywords'=>'',
            'status'=>1,
        ],
        [
            'id'=>5,'parent_id'=>0,'category_name'=>'Electronic',
            'category_image'=>'','category_discount'=>'',
            'description'=>'','url'=>'electronic','meta_title'=>'',
            'meta_description'=>'','meta_keywords'=>'',
            'status'=>1,
        ],

       ];

       // now insert it into databse
       Category::insert($categoryRecord);
    }
}
