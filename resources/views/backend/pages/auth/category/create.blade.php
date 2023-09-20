@extends('backend.layouts.master')
@push('admin_style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css"
        integrity="sha512-EZSUkJWTjzDlspOoPSpUFR0o0Xy7jdzW//6qhUkoZ9c4StFkVsp9fbbd0O06p9ELS3H486m4wmrCELjza4JEog=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush
@section('title', 'create-category')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="fw-bold">Create Category Form</h3>
            <div class="d-flex justify-content-start">
                <a href="{{ route('admin.category.index') }}" class="btn btn-primary">Back</a>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.category.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="category-title">Category Title</label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                        placeholder="enter category title">
                    @error('title')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="category-image">Category image</label>
                    <input type="file" name="category_image"
                        class="form-control @error('category_image') is-invalid @enderror dropify">
                    @error('category_image')
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
                'remove': 'Remove',
                'error': 'Ooops, something wrong happended.'
            }
        });
    </script>
@endpush
