<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class Admin extends Authenticatable
{
    use HasFactory;

    protected $guard = 'admin';

    protected $fillable = ['name', 'email', 'password', 'image', 'mobile'];

    protected $hidden = [
        'password',
    ];

    private static $admin, $image, $imageName, $directory, $imageUrl;

    public static function imageUpload($request)
    {
        self::$image      = $request->file('admin_image');
        self::$imageName  = self::$image->getClientOriginalName();
        self::$directory  = "admin/images/photos/";
        self::$image->move(self::$directory, self::$imageName);
        return self::$directory . self::$imageName;
    }
    public static function updateDetailsx($request, $id)
    {
        self::$admin = Admin::find($id);
        if ($request->file('admin_image')) {
            if (Storage::disk('public')->exists(self::$admin->image)) {
                Storage::disk('public')->delete(self::$admin->image);
            }
            self::$imageUrl = self::imageUpload($request);
        } else {
            self::$imageUrl = self::$admin->image;
        }
        self::$admin->name = $request->admin_name;


        self::$admin->image = self::$imageUrl;


        try {
            $result = self::$admin->update();
            // dd($result);
            return $result;
        } catch (\Exception $e) {
            dd($e->getMessage()); // Log or display the exception message
        }
    }
}
