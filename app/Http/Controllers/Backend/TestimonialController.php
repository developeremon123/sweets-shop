<?php

namespace App\Http\Controllers\Backend;

use App\Models\Testimonial;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Intervention\Image\Facades\Image;
use App\Http\Requests\TestimonialStoreRequest;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $testimonials = Testimonial::latest('id')->paginate(5);
        return view('backend.pages.auth.testimonial.index',compact('testimonials'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.pages.auth.testimonial.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TestimonialStoreRequest $request)
    {
        $testimonials = Testimonial::create([
            'client_name' => $request->client_name,
            'client_name_slug' => Str::slug($request->client_name),
            'client_designation' => $request->client_designation,
            'client_message' => $request->client_message,

        ]);
        $this->image($request, $testimonials->id);
        Toastr::success('Data stored successfully');
        return redirect()->route('admin.testimonial.index');
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function image($request,$id)
    {
        $testimonials = Testimonial::findOrFail($id);
        if ($request->hasFile('client_image')) {
            if ($testimonials->client_image != 'default-client.jpg') {
                $location = 'public/upload/testimonial';
                $old_location = $location.$testimonials->client_image;
                unlink(base_path($old_location));
            }
            $image_location = 'public/upload/testimonial/';
            $upload_image = $request->file('client_image');
            $new_image_name = $testimonials->id.'.'.$upload_image->getClientOriginalExtension();
            $new_photo_location = $image_location.$new_image_name;
            Image::make($upload_image)->resize(105,105)->save(base_path($new_photo_location),40);

            $check = $testimonials->update([
                'client_image' => $new_image_name
            ]);

        }
    }
}
