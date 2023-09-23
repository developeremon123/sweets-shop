<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
    {
        $testimonials = Testimonial::where('is_active',1)
        ->latest('id')
        ->limit(3)
        ->select(['id','client_name','client_designation','client_image','client_message'])
        ->get();

        $categories = Category::where('is_active',1)
        ->latest('id')
        ->limit(5)
        ->select(['id','title','category_image','slug'])
        ->get();

        $products = Product::where('is_active',1)
        ->latest('id')
        ->select(['id','name','slug','product_price','product_stock','product_rating','product_image'])
        ->Paginate(12);
        return view('frontend.layouts.pages.home',compact('testimonials','categories','products'));
    }
}
