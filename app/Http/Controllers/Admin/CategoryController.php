<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function categories(){
        // $categories=Category::with('parentCategory')->get()->toArray();
        // dd($categories);
        $categories=Category::with('parentCategory')->get();

        return view('admin.categories.categories')->with(compact('categories'));
    }
}
