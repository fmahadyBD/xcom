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
        $title = $id ? "Edit Category" : "Add Category";
        $categoryEA = $id ? Category::find($id) : new Category();
        $message = $id ? "Category Updated successfully" : "Category Added successfully";
        $x = true;

        $parentCategories = Category::where('id', '!=', $id)->get();

        if ($request->isMethod('post')) {
            $data = $request->all();

            if ($request->hasFile('image')) {
                $imageUrl = Category::subadminimageUpload($request);
            } else {
                $imageUrl = $categoryEA->image;
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
                return redirect()->back()->with('success_message', $message);
            } catch (\Exception $e) {
                dd($e->getMessage());
            }
        }

        // Adding 'level' property to each category for hierarchical structure
        $parentCategories = $this->addLevelToCategories($parentCategories);

        return view('admin.categories.add_edit_categories', compact('title', 'categoryEA', 'parentCategories', 'x'));
    }

    private function addLevelToCategories($categories, $parent_id = 0, $level = 0)
    {
        $result = [];
        foreach ($categories as $category) {
            if ($category->parent_id == $parent_id) {
                $category->level = $level;
                $result[] = $category;
                $result = array_merge($result, $this->addLevelToCategories($categories, $category->id, $level + 1));
            }
        }
        return $result;
    }


}
