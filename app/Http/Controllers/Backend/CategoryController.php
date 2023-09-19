<?php

namespace App\Http\Controllers\Backend;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;
use Brian2694\Toastr\Facades\Toastr;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::latest('id')->select(['id','title','slug'])->paginate();
        $delcategories = Category::onlyTrashed()->latest('id')->select(['id','title','slug'])->paginate();
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
        $create = Category::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title)
        ]);

        if ($create) {
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

        if ($category) {
            Toastr::success("Category store successfully");
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
    
        if ($delcategories) {
            $delcategories->forceDelete();
            Toastr::success("Category permanently deleted");
        } else {
            Toastr::error("Category not found or already deleted");
        }
    
        return back();
    }
    
}
