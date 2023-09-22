<?php

use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Backend\TestimonialController;
use App\Http\Controllers\Backend\ProductController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', function () {
    return view('frontend.layouts.pages.home');
});
/* testimonial route*/ 
Route::get('/', [HomeController::class,'home']);
/*Admin Auth routes */
Route::prefix('/admin')->as('admin.')->group(function(){
    Route::get('/login',[LoginController::class,'loginPage'])->name('loginPage');
    Route::post('/login',[LoginController::class,'login'])->name('login');
    Route::get('/logout',[LoginController::class,'logout'])->name('logout');

    Route::middleware('auth')->group(function(){
        Route::get('/dashboard',[DashboardController::class,'dashboard'])->name('dashboard');
    });
    /*Resource Controller*/ 
    Route::resource('/category',CategoryController::class);
    Route::resource('/testimonial',TestimonialController::class);
    Route::resource('/product',ProductController::class);
    /* restore category route*/
    Route::get('/category/{category}/restore',[CategoryController::class,'restore'])->name('category.restore');
    Route::get('/category/{category}/perDelete',[CategoryController::class,'delete'])->name('category.perDelete');
    /* restore product route*/
    Route::get('/product/{product}/restore',[ProductController::class,'restore'])->name('product.restore');
    Route::get('/product/{product}/proDelete',[ProductController::class,'delete'])->name('product.proDelete');
}) ;