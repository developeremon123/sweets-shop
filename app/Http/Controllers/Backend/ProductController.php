<?php

namespace App\Http\Controllers\Backend;

use Exception;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Intervention\Image\Facades\Image;
use App\Http\Requests\ProductstoreRequest;
use App\Http\Requests\ProductUpdateRequest;

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

        return view('backend.pages.product.index',compact('products'));
        
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
        $this->multiple_image_upload($request, $products->id);
        

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
        $this->multiple_image_upload($request, $products->id);

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
        $multiple_images = ProductImage::where('product_id', $product->id)->get();
        foreach ($multiple_images as $multiple_image) {
            if ($multiple_image->product_multiple_image != 'default-product.png') {
                // Delete the image file from the product folder
                $photo_location = 'public/upload/product/';
                $old_photo_location = $photo_location . $multiple_image->product_multiple_image;
                
                if (file_exists(base_path($old_photo_location))) {
                    unlink(base_path($old_photo_location));
                }
            }
            // Delete the record from the database
            $multiple_image->delete();
        }
        $product_folder = 'public/upload/product/' . $product->id;
        if (is_dir(base_path($product_folder))) {
            rmdir(base_path($product_folder));
        }
        if($product->product_image){
            $photo_location = 'upload/product/'.$product->product_image;
            unlink($photo_location);
        }
    
        if ($product) {
            $product->delete();
            Toastr::success("Product deleted!");
        } else {
            Toastr::error("Product not delete!");
        }
    
        return back();
    }
    

    public function image($request, $id){
        $product = Product::findOrFail($id);

        if ($request->hasFile('product_image')) {
            if ($product->product_image != 'default-product.png') {
                $image_location = public_path('upload/product/'); // Adjust the path accordingly
                $old_image_path = $image_location . $product->product_image;
                // Check if the file exists before attempting to delete it
                if (file_exists($old_image_path)) {

                    unlink($old_image_path);
                }
            }

            $image_location = public_path('upload/product/'); // Adjust the path accordingly
            $upload_image = $request->file('product_image');
            $new_image_name = $product->id . '.' . $upload_image->getClientOriginalExtension();
            $new_photo_location = $image_location . $new_image_name;

            Image::make($upload_image)->resize(105, 105)->save($new_photo_location, 40);

            $check = $product->update([
                'product_image' => $new_image_name
            ]);
        }
    }


    public function multiple_image_upload($request, $product_id){
        if ($request->hasFile('product_multiple_image')) {

            // delete old photo first
            $multiple_images = ProductImage::where('product_id', $product_id)->get();
            foreach ($multiple_images as $multiple_image) {
                if ($multiple_image->product_multiple_photo_name  != 'default-product.png') {
                    //delete old photo
                    $photo_location = 'public/upload/product/';
                    $old_photo_location = $photo_location . $multiple_image->product_multiple_photo_name ;
                    unlink(base_path($old_photo_location));
                }
                // delete old value of db table
                $multiple_image->delete();
            }

            $flag = 1; // Assign a flag variable

            foreach ($request->file('product_multiple_image') as $single_photo) {
                $photo_location = 'public/upload/product/';
                $new_photo_name = $product_id.'-'.$flag.'.'. $single_photo->getClientOriginalExtension();
                $new_photo_location = $photo_location . $new_photo_name;
                Image::make($single_photo)->resize(600, 622)->save(base_path($new_photo_location), 40);
                ProductImage::create([
                    'product_id' => $product_id,
                    'product_multiple_image' => $new_photo_name,
                ]);
                $flag++;
            }
        }
    }

  
   
}



