<?php

namespace App\Http\Controllers\Backend;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Intervention\Image\Facades\Image;
use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::latest('id')
        ->select(['id','title','slug','category_image','updated_at'])
        ->paginate();
        $delcategories = Category::onlyTrashed()
        ->latest('id')
        ->select(['id','title','slug','category_image','updated_at'])
        ->paginate();
        return view('backend.pages.auth.category.index',compact('categories','delcategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.pages.auth.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryStoreRequest $request)
    {
        $category = Category::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title)
        ]);

        $this->image($request, $category->id);

        if ($category) {
            Toastr::success("New Category Store successfully");
            return redirect()->route('admin.category.index');
        }else {
            Toastr::error("Something went wrong!!");
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
        $category = Category::whereSlug($slug)->first();
        return view('backend.pages.auth.category.edit',compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryUpdateRequest $request, string $slug)
    {
        $category = Category::whereSlug($slug)->first();
        $category->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'is_active' => $request->filled('is_active')
        ]);

        $this->image($request, $category->id);

        if ($category) {
            Toastr::success("Category updated successfully");
            return redirect()->route('admin.category.index');
        }else {
            Toastr::error("Something went wrong!!");
            return back();
        }
    }


    public function restore($slug)
    {
        $delcategories = Category::onlyTrashed()->whereSlug($slug)->first()->restore();
        if ($delcategories) {
            Toastr::success("Category restored");
            return back();
        }else {
            Toastr::error("Category not restored! Somethings went worng");
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $slug)
    {
        $delcategories = Category::whereSlug($slug)->first()->delete();
        if ($delcategories) {
            Toastr::error("Category trashed!");
            return back();
        }else {
            Toastr::error("Category not delete!");
            return back();
        }
    }

    public function delete($slug)
    {
        $delcategories = Category::onlyTrashed()->whereSlug($slug)->first();
        if($delcategories->category_image){
            $location = 'upload/category/'.$delcategories->category_image;
            unlink($location);
        }
    
        if ($delcategories) {
            $delcategories->forceDelete();
            Toastr::success("Category permanently deleted");
        } else {
            Toastr::error("Category not found or already deleted");
        }
    
        return back();
    }

    public function image($request,$id)
    {
        $category = Category::findOrFail($id);
        if ($request->hasFile('category_image')) {
            if ($category->category_image != 'default-image.jpeg') {
                $location = 'public/upload/category/';
                $old_location = $location.$category->category_image;
                unlink(base_path($old_location));
            }
            $image_location = 'public/upload/category/';
            $upload_image = $request->file('category_image');
            $new_image_name = $category->id.'.'.$upload_image->getClientOriginalExtension();
            $new_photo_location = $image_location.$new_image_name;
            Image::make($upload_image)->resize(105,105)->save(base_path($new_photo_location),40);

            $check = $category->update([
                'category_image' => $new_image_name
            ]);

        }
    }
    
}
