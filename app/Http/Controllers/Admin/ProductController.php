<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductsImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;

class ProductController extends Controller
{

    public function productsf()
    {
        $products = Product::with('category')->get();
        $categories = Category::pluck('category_name', 'id')->toArray();
        // id is value and category_name is value

        return view('admin.product.product')->with(compact('products', 'categories'));
    }


    public function destroy($id)
    {


        Product::where('id', $id)->delete();
        return redirect()->back()->with('success_message', 'Product delete successfuly');
    }
    // public function editAddProduct(Request $request, $id = null)
    // {
    //     $title = $id ? "Edit malea" : "Add New Product";
    //     $productEA = $id ? product::find($id) : new product();
    //     $message = $id ? "product Updated successfully" : "product Added successfully";



    //     // $parentCategories = product::where('id', '!=', $id)->get();
    //     $categoryEA = $id ? Category::find($id) : new Category();
    //     $parentCategories = Category::where('id', '!=', $id)->get();

    //     if ($request->isMethod('post')) {
    //         $data = $request->all();

    //         // dd($data);
    //         // die;

    //         $productEA->product_name = $data['product_name'];
    //         $productEA->product_code = $data['product_code'];
    //         $productEA->product_color = $data['product_color'];

    //         $productEA->family_color = $data['family_color'];

    //         $productEA->category_id = $data['parent_category_id'];
    //         $productEA->group_code = $data['group_code'];
    //         $productEA->product_price = $data['product_price'];
    //         $productEA->product_discount = $data['product_discount'];
    //         $productEA->discount_type = $data['discount_type'];
    //         $productEA->description = $data['description'];
    //         $productEA->wish_care = $data['wish_care'];
    //         $productEA->keywords = $data['keywords'];
    //         $productEA->final_price = 0;
    //         if ($request->hasFile('product_video_file')) {
    //             $file = $request->file('product_video_file');
    //             $fileName = time() . '_' . $file->getClientOriginalName();
    //             $file->move(public_path('admin/videos'), $fileName);

    //             // Save file name to the database
    //             $productEA->product_video = $fileName;
    //         }



    //         $productEA->id_featured = 'yes';
    //         $productEA->status = 1;
    //         $productEA->meta_title = $data['meta_title'];
    //         $productEA->meta_description = $data['meta_description'];
    //         $productEA->meta_keywords = $data['meta_keywords'];

    //         // $productEA->fabric = $data['fabric'];
    //         // $productEA->pattern = $data['pattern'];
    //         // $productEA->sleeve = $data['sleeve'];
    //         // $productEA->fit = $data['fit'];
    //         // $productEA->ocassion = $data['ocassion'];
    //         $productEA->fabric = isset($data['fabric']) ? $data['fabric'] : 'no';
    //         $productEA->pattern = isset($data['pattern']) ? $data['pattern'] : 'no';
    //         $productEA->sleeve = isset($data['sleeve']) ? $data['sleeve'] : 'no';
    //         $productEA->fit = isset($data['fit']) ? $data['fit'] : 'no';
    //         $productEA->ocassion = isset($data['ocassion']) ? $data['ocassion'] : 'no';



    //         $productEA->status = 1;
    //         if ($id == "") {
    //             $product_id = DB::getPds()->lastInsertId();
    //         } else {
    //             $product_id = $id;
    //         }
    //         //upload image

    //         // if ($request->hasFile('product_images')) {
    //         //     $imagePaths = ProductsImage::typeImage($request->file('product_images'), $product_id);
    //         // }
    //         if ($request->hasFile('product_images')) {
    //             // dd('hhi');
    //             // die;
    //         }
    //         $productImageModel = app(ProductsImage::class);
    //         $imagePaths = $productImageModel->typeImage($request, $product_id);

    //         try {
    //             $result = $productEA->save();
    //             return redirect()->back()->with('success_message', $message);
    //         } catch (\Exception $e) {
    //             dd($e->getMessage());
    //         }






    //         $parentCategories = $this->addLevelToCategories($parentCategories);
    //     }

    //     return view('admin.product.add_edit_products', compact('title', 'productEA',  'parentCategories'));
    // }



    public function editAddProduct(Request $request, $id = null)
    {
        $title = $id ? "Edit malea" : "Add New Product";
        $productEA = $id ? product::find($id) : new product();
        $message = $id ? "product Updated successfully" : "product Added successfully";

        $categoryEA = $id ? Category::find($id) : new Category();
        $parentCategories = Category::where('id', '!=', $id)->get();

        if ($request->isMethod('post')) {
            $data = $request->all();

            // ... existing code ...
           $productEA->status = 1;
            if ($id == "") {
                // $product_id = DB::getPds()->lastInsertId();
            } else {
                $product_id = $id;
            }
            //upload image
            if ($request->hasFile('product_images')) {
                // $productImageModel = app(ProductsImage::class);
                // $imagePaths = $productImageModel->typeImage($request, $product_id);


                $manager=new ImageManager(new Driver());
                $name_gen=hexdec(uniqid()).'.'.$request->file('image')->getClientOriginalName();
                $im=$manager->read($request->file('product_images'));
                $im=$im->resize(370,246);
                $im->toJpeg(80)->save(base_path('public/front/images/products/large/'.$name_gen));

            }

            try {
                $result = $productEA->save();
                return redirect()->back()->with('success_message', $message);
            } catch (\Exception $e) {
                dd($e->getMessage());
            }

            $parentCategories = $this->addLevelToCategories($parentCategories);
        }

        return view('admin.product.add_edit_products', compact('title', 'productEA', 'parentCategories'));
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
    public function UpdateproductsStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            if ($data['status'] == 'Active') {
                $status = 0;
            } else {
                $status = 1;
            }
            Product::where('id', $data['product_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'product_id' => $data['product_id']]);
        }
    }
}
