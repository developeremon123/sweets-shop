<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Backend\CuponController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\TestimonialController;
use App\Http\Controllers\Frontend\Auth\CustomerLoginController;
use App\Http\Controllers\Frontend\Auth\RegisterController;
use App\Http\Controllers\Frontend\CustomerController;

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


// Route::get('/', function () {
//     return view('frontend.layouts.pages.home');
// });

Route::get('/', [HomeController::class,'home'])->name('home');
Route::get('/shop', [HomeController::class,'shopPage'])->name('shop.page');
Route::get('/single-product/{product_slug}', [HomeController::class,'productDetails'])->name('productdetail.page');
Route::get('/shopping-cart', [CartController::class,'cartPage'])->name('cart.page');
Route::post('/add-to-cart', [CartController::class,'addToCart'])->name('add-to.cart');
Route::get('/remove-from-cart/{cart_id}', [CartController::class,'remove_cart'])->name('remove.cart');
/*Admin Auth routes */
Route::prefix('/admin')->as('admin.')->group(function(){
    Route::get('/login',[LoginController::class,'loginPage'])->name('loginPage');
    Route::post('/login',[LoginController::class,'login'])->name('login');
    
    Route::middleware(['auth','is_admin'])->group(function(){
        Route::get('/logout',[LoginController::class,'logout'])->name('logout');
        Route::get('/dashboard',[DashboardController::class,'dashboard'])->name('dashboard');
    });
    /*Resource Controller*/ 
    Route::resource('/category',CategoryController::class);
    Route::resource('/testimonial',TestimonialController::class);
    Route::resource('/product',ProductController::class);
    Route::resource('/cupon',CuponController::class);
    /* restore category route*/
    Route::get('/category/{category}/restore',[CategoryController::class,'restore'])->name('category.restore');
    Route::get('/category/{category}/perDelete',[CategoryController::class,'delete'])->name('category.perDelete');
    /* restore cupon route*/
    Route::get('/cupon/{cupon}/restore',[CuponController::class,'restore'])->name('cupon.restore');
    Route::get('/cupon/{cupon}/delete',[CuponController::class,'delete'])->name('cupon.delete');
    
}) ;

/*Authentication routes for customer/guest */
Route::get('/register',[RegisterController::class,'resigterPage'])->name('resigter.Page');
Route::post('/register',[RegisterController::class,'register'])->name('resigter.store');
Route::get('/login',[CustomerLoginController::class,'loginPage'])->name('login.Page');
Route::post('/login',[CustomerLoginController::class,'login'])->name('login.store');

Route::prefix('/customer')->middleware(['auth','is_customer'])->as('customer.')->group(function(){
    Route::get('/dashboard',[CustomerController::class, 'dashboard'])->name('dashboard');
    Route::get('/logout',[CustomerLoginController::class, 'logout'])->name('logout');
    Route::post('/cart/apply-cupon',[CartController::class, 'cuponApply'])->name('cuponApply');
    Route::get('/cart/remove-cupon/{cuponName}',[CartController::class, 'removeCupon'])->name('removeCupon');
});
