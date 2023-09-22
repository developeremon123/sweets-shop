<?php

namespace App\Http\Controllers\Backend;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Intervention\Image\Facades\Image;
use App\Http\Requests\ProductstoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Testimonial;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::where('is_active',1)
        ->with('category')
        ->latest('id')
        ->select(['id','name','slug','category_id','product_image','product_price','product_stock','alert_quantity','product_rating','updated_at'])
        ->paginate(25);
        $delproducts = Product::onlyTrashed()
        ->where('is_active',1)
        ->with('category')
        ->latest('id')
        ->select(['id','name','slug','category_id','product_image','product_price','product_stock','alert_quantity','product_rating','updated_at'])
        ->paginate(25);
        return view('backend.pages.product.index',compact('products','delproducts'));
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::latest('id')
        ->select(['id','title'])
        ->get();
        return view('backend.pages.product.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductstoreRequest $request)
    {
        $products = Product::create([
            'category_id'       => $request->category_id,
            'name'              => $request->name,
            'slug'              => Str::slug($request->name),
            'product_code'      => $request->product_code,
            'product_price'     => $request->product_price,
            'product_stock'     => $request->product_stock,
            'alert_quantity'    => $request->alert_quantity,
            'long_description'  => $request->long_description,
            'short_description' => $request->short_description,
            'additional_info'   => $request->additional_info,
        ]);

        $this->image($request, $products->id);

        if ($products) {
            Toastr::success("New product Store successfully");
            return redirect()->route('admin.product.index');
        }else {
            Toastr::warning("Something went wrong!!");
            return back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $slug)
    {
        $products = Product::whereSlug($slug)->first();
        $categories = Category::select(['id','title'])->get();
        return view('backend.pages.product.edit',compact('products','categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductUpdateRequest $request, string $slug)
    {
        $products = Product::whereSlug($slug)->first();
        $products->update([
            'category_id'       => $request->category_id,
            'name'              => $request->name,
            'slug'              => Str::slug($request->name),
            'product_code'      => $request->product_code,
            'product_price'     => $request->product_price,
            'product_stock'     => $request->product_stock,
            'alert_quantity'    => $request->alert_quantity,
            'long_description'  => $request->long_description,
            'short_description' => $request->short_description,
            'additional_info'   => $request->additional_info,
        ]);

        $this->image($request, $products->id);

        if ($products) {
            Toastr::success("Product updated successfully");
            return redirect()->route('admin.product.index');
        }else {
            Toastr::warning("Something went wrong!!");
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $slug)
    {
        $product = Product::whereSlug($slug)->first();

        if ($product) {
            $product->delete();
            Toastr::success("Product trashed!");
        } else {
            Toastr::error("Product not found!");
        }

        return back();
    }


    public function image($request,$id)
    {
        $products = Product::findOrFail($id);
        if ($request->hasFile('product_image')) {
            if ($products->product_image != 'default-product.png') {
                $location = 'public/upload/product/';
                $old_location = $location.$products->product_image;
                unlink(base_path($old_location));
            }
            $image_location = 'public/upload/product/';
            $upload_image = $request->file('product_image');
            $new_image_name = $products->id.'.'.$upload_image->getClientOriginalExtension();
            $new_photo_location = $image_location.$new_image_name;
            Image::make($upload_image)->resize(105,105)->save(base_path($new_photo_location),40);

            $check = $products->update([
                'product_image' => $new_image_name
            ]);

        }
    }
    public function restore($slug)
    {
        $delproduct = Product::onlyTrashed()->whereSlug($slug)->first()->restore();
        if ($delproduct) {
            Toastr::success("Product restored");
            return back();
        }else {
            Toastr::error("Product not restored! Somethings went worng");
            return back();
        }
    }
    public function delete($slug)
    {
        $delproducts = Product::onlyTrashed()->whereSlug($slug)->first();
        if($delproducts->product_image){
            $location = 'upload/product/'.$delproducts->product_image;
            unlink($location);
        }
    
        if ($delproducts) {
            $delproducts->forceDelete();
            Toastr::success("Product permanently deleted");
        } else {
            Toastr::error("Product not found or already deleted");
        }
    
        return back();
    }
}
