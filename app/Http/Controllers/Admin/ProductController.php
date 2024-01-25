<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function productsf()
    {
        $products = Product::with('category')->get();
        $categories = Category::pluck('category_name', 'id')->toArray();
        // id is value and category_name is value

        return view('admin.product.product')->with(compact('products', 'categories'));
    }
}
