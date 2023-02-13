<?php

use App\Http\Controllers\Dashboard\CatgeoryController;
use App\Http\Controllers\Dashboard\IndexController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\SettingController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/index',[IndexController::class , 'index'])->name('admin');


Route::group(['as'=>'dashboard.'],function(){

    Route::get('/settings', [SettingController::class,'index'])->name('settings.index');
    Route::put('settings/{setting}/update', [SettingController::class,'update'])->name('settings.update');
   
    
    // Route::get('categories/ajax',[CatgeoryController::class,'getall'])->name('categories.getall');
    // Route::delete('categories/delete',[CatgeoryController::class,'delete'])->name('categories.delete');
    // Route::resource('categories',CatgeoryController::class);

    Route::controller(CatgeoryController::class)
    ->name('categories.')
    ->prefix('categories')
    ->group(function(){
        Route::get('ajax','getall')->name('getall');
        Route::delete('delete','delete')->name('delete');
    });

   Route::resource('categories',CatgeoryController::class)->except('destroy','show','create');
  

   Route::controller(ProductController::class)
    ->name('products.')
    ->prefix('products')
    ->group(function(){
        Route::get('ajax','getall')->name('getall');
        Route::delete('delete','delete')->name('delete');

    });
   Route::resource('products',ProductController::class)->except("destroy");

   Route::get('/export', [ExportController::class,'export'])->name('export');

});



