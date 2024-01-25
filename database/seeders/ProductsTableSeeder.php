<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products=[
            [
                'category_id'=>'8','brand_id'=>'0','product_name'=>'Blue T-shirt','product_weight'=>'0',
                'product_code'=>'ss','product_color'=>'s','family_color'=>'',
                'group_code'=>'','product_price'=>'0','product_discount'=>'0',
                'discount_type'=>'','description'=>'','wish_care'=>'','keywords'=>'',
                'final_price'=>'0','product_video'=>'','fabric'=>'','pattern'=>'',
                'sleeve'=>'','fit'=>'','ocassion'=>'','meta_title'=>'',
                'meta_description'=>'','meta_keywords'=>'','id_featured'=>'Yes',
                'status'=>1,
            ],
        ];
        Product::insert($products);

    }
}
