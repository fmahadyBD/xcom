<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CmsController;
use App\Http\Controllers\Admin\ProductController;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('welcome');
});
Route::prefix('/admin')->namespace('App\Http\Controllers\Admin')->group(function(){


    Route::match(['get','post'],'login','AdminController@login') ;

    Route::group(['middleware'=>['admin']],function(){
        Route::get('dashboard','AdminController@dashboard') ;


        // Route::match(['get','post'],'update-details','AdminController@updateDetails') ;
        // Route::get(['get','post'],'update-details','AdminController@updateDetails') ;
        Route::get('/edit/', [AdminController::class, 'edit'])->name('edit');
        Route::post('/updateDetails/', [AdminController::class, 'updateDetails'])->name('updateDetails');


        Route::match(['get','post'],'update-password','AdminController@updatePassword') ;
        Route::post('check-current-password','AdminController@checkCurrentPassword') ;
        Route::get('logout','AdminController@logout') ;

        //Cms CRUE

        Route::get('/cms-page','CmsController@index');
        Route::get('/cms-pages/', [CmsController::class, 'index'])->name('cms-pages');
        Route::post('update-cms-pages-page-status','CmsController@update');
        Route::match(['get','post'],'add-edit-cms-page/{id?}','CmsController@edit');
        Route::get('delete-cms-page/{id?}','CmsController@destroy');

        // /sub admin
        Route::get('subadmins','AdminController@subAdmins');
        Route::post('/update-subadmin-status','AdminController@updateSubadminStatus');

        Route::get('delete-subadmin/{id?}','AdminController@deletesbadmin');
        Route::match(['get','post'],'add-subadmin/{id?}','AdminController@editSubadmin');
        Route::post('check-email','AdminController@checkemail') ;
        Route::post('check-mobile','AdminController@checkmobilenumber') ;
        // Route::post('update-subadmin-Details','AdminController@updateSubadminDetailes') ;
        // Route::match(['get','post'],'update-subadmin-Details/{id?}','AdminController@updateSubadminDetailes');
        Route::match(['get', 'post'], 'update-subadmin-Details/{id?}', 'AdminController@updateSubadminDetailes')->name('update-subadmin-Details');
        Route::match(['get','post'],'update-role/{id}','AdminController@updateRole');



        //category
        Route::get('categories','CategoryController@categories');
        Route::post('update-category-status','CategoryController@updateCategoryStatus');
        Route::get('delete-category/{id?}','CategoryController@destroy');
        Route::match(['get','post'],'add-edit-category/{id?}','CategoryController@editAddSubadmin')->name('add-edit-category');

        //product
        Route::get('/products-page', [ProductController::class, 'productsf'])->name('products-page');
        Route::get('delete-product/{id?}','ProductController@destroy');
        Route::post('update-products-status','ProductController@UpdateproductsStatus');
        Route::match(['get','post'],'add-edit-products/{id?}','ProductController@editAddProduct')->name('add-edit-products');

    });
});
