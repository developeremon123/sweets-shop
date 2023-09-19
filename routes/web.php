<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Backend\CategoryController;

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
}) ;