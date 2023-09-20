@extends('backend.layouts.master')
@push('admin_style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css"
        integrity="sha512-EZSUkJWTjzDlspOoPSpUFR0o0Xy7jdzW//6qhUkoZ9c4StFkVsp9fbbd0O06p9ELS3H486m4wmrCELjza4JEog=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush
@section('title', 'create-testimonial')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="fw-bold">Create Testimonial Form</h3>
            <div class="d-flex justify-content-start">
                <a href="{{ route('admin.testimonial.index') }}" class="btn btn-primary"><i
                        class="fa-solid fa-backward"></i>Back</a>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.testimonial.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="client-name">Client Name</label>
                    <input type="text" name="client_name" class="form-control @error('client_name') is-invalid @enderror"
                        placeholder="enter client name">
                    @error('client_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="client-designation">Client Designation</label>
                    <input type="text" name="client_designation"
                        class="form-control @error('client_designation') is-invalid @enderror"
                        placeholder="enter client designation">
                    @error('client_designation')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="client-message">Client Message</label>
                    <textarea name="client_message" class="form-control @error('client_message') is-invalid @enderror"
                        placeholder="enter client message"></textarea>
                    @error('client_message')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="client-image">Client Image</label>
                    <input type="file" name="client_image"
                        class="form-control @error('client_image') is-invalid @enderror dropify"
                        placeholder="enter client image">
                    @error('client_image')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-check form-switch mt-2">
                    <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" checked
                        name="is_active">
                    <label class="form-check-label" for="flexSwitchCheckChecked">Active or Inactive</label>
                </div>
                <div class="form-group mt-2">
                    <button type="submit" class="btn btn-success">Store</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('admin_script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"
        integrity="sha512-8QFTrG0oeOiyWo/VM9Y8kgxdlCryqhIxVeRpWSezdRRAvarxVtwLnGroJgnVW9/XBRduxO/z1GblzPrMQoeuew=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $('.dropify').dropify({
            messages: {
                'default': 'Drag and drop a file here or click',
                'replace': 'Drag and drop or click to replace',
                'remove':  'Remove',
                'error':   'Ooops, something wrong happended.'
            }
        });
    </script>
@endpush
