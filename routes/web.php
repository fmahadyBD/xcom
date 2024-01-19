<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CmsController;
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
    });
});
