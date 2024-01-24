<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function categories()
    {
        // $categories=Category::with('parentCategory')->get()->toArray();
        // dd($categories);
        $categories = Category::with('parentCategory')->get();

        return view('admin.categories.categories')->with(compact('categories'));
    }

    public function updateCategoryStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            if ($data['status'] == 'Active') {
                $status = 0;
            } else {
                $status = 1;
            }
            Category::where('id', $data['category_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'category_id' => $data['category_id']]);
        }
    }
    public function destroy($id)
    {
        //delete
        Category::where('id', $id)->delete();
        return redirect()->back()->with('success_message', 'Category delete successfuly');
    }

    public function editAddSubadmin(Request $request, $id = null)
    {
        if ($id) {
            // Load form for editing categoryEA
            $title = "Edit Category";
            $categoryEA = Category::find($id);
            // if there have id then find by this id of the suadmin to
            $message = "Category Update successfully";
            $parentCategories = Category::where('id', '!=', $id)->get();
            $x = true;
        } else {
            // Load form for adding categoryEA
            $title = "ADD Category ";
            $categoryEA = new Category();
            $message = "Category Added successfully";
            $x = false;
            $parentCategories = Category::all(); // Assuming you want all categories for the parent selector
        }

        if ($request->isMethod('post')) {
            $data = $request->all();
            // dd($data);
            // die;
            if ($request->hasFile('image')) {
                $imageUrl = Category::subadminimageUpload($request);
            } else {
                $imageUrl = $categoryEA->image; // Make sure $subadmin is defined
            }

            $categoryEA->category_name = $data['category_name'];
            $categoryEA->category_discount = $data['category_discount'];
            $categoryEA->description = $data['description'];
            $categoryEA->url = $data['url'];
            $categoryEA->meta_title = $data['meta_title'];
            $categoryEA->meta_description = $data['meta_description'];
            $categoryEA->meta_keywords = $data['meta_keywords'];
            if ($request->has('is_parent_category')) {
                $categoryEA->parent_id = 0;
            } else {
                $categoryEA->parent_id = $data['parent_category_id'];
            }

                  $categoryEA->image = $imageUrl;
            $categoryEA->status = 1;
            try {
                $result = $categoryEA->save();
                return redirect()->back()->with('success_message', 'Added Sussessfully');
            } catch (\Exception $e) {
                dd($e->getMessage());
            }
        }

        return view('admin.categories.add_edit_categories', compact('title', 'categoryEA', 'parentCategories', 'x'));
    }
}
