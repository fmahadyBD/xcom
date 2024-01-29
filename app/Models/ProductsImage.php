<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ProductsImage extends Model
{
    use HasFactory;

    public static function typeImage($request, $product_id)
    {
        $images = $request->file('product_images');
        $imagePaths = [];

        foreach ($images as $key => $image) {
            $imageName = 'product-' . rand(111, 9999999) . '_' . $image->getClientOriginalName();
            $largeImagePath = 'front/images/products/large/' . $imageName;
            $smallImagePath = 'front/images/products/small/' . $imageName;
            $mediumImagePath = 'front/images/products/medium/' . $imageName;

            // Resize and save the original image
            self::resizeAndSaveImage($image, public_path($largeImagePath), 1040, 1200);
            self::resizeAndSaveImage($image, public_path($mediumImagePath), 800, 600);
            self::resizeAndSaveImage($image, public_path($smallImagePath), 400, 300);

            $imagePaths[] = $imageName;
        }

        // Save image paths in the database
        self::saveImagePaths($product_id, $imagePaths);

        return $imagePaths;
    }

    private static function resizeAndSaveImage($image, $destinationPath, $width, $height)
    {
        // Move the original image to the destination directory
        $image_name = rand(111111, 888999) * time() . '.' . $image->getClientOriginalExtension();
        $image->move($destinationPath, $image_name);

        // Create the full path for the original image
        $orgImgPath = $destinationPath . '/' . $image_name;

        // Resize the original image using the convert command
        $resizeCommand = "convert $orgImgPath -resize {$width}x{$height}\\! $orgImgPath";
        shell_exec($resizeCommand);
    }

    private static function saveImagePaths($product_id, $imagePaths)
    {
        foreach ($imagePaths as $imageName) {
            $image = new ProductsImage;
            $image->image = $imageName;
            $image->product_id = $product_id;
            $image->status = 1;
            $image->save();
        }
    }
}
