@extends('backend.layouts.master')
@push('admin_style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css"
        integrity="sha512-EZSUkJWTjzDlspOoPSpUFR0o0Xy7jdzW//6qhUkoZ9c4StFkVsp9fbbd0O06p9ELS3H486m4wmrCELjza4JEog=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush
@section('title', 'create-product')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="fw-bold">Create Product Form</h3>
            <div class="d-flex justify-content-start">
                <a href="{{ route('admin.product.index') }}" class="btn btn-primary"><i class="fa-solid fa-backward"></i>Back</a>
            </div>
        </div>
        <div class="card-body">
            <form class="row g-3" method="post" action="{{ route('admin.product.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="col-12 form-group">
                    <label for="category_id" class="form-label">Select Category</label>
                    <select name="category_id" class="form-control">
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 form-group">
                    <label for="name" class="form-label">Product Name</label>
                    <input type="text" class="form-control" name="name">
                </div>
                <div class="col-md-6 form-group">
                    <label for="product_code" class="form-label">Product Code</label>
                    <input type="number" class="form-control" name="product_code"
                        placeholder="enter a unique product code">
                </div>
                <div class="col-md-6 form-group">
                    <label for="product_price" class="form-label">Product Price</label>
                    <input type="text" class="form-control" name="product_price" min="0">
                </div>
                <div class="col-md-6 form-group">
                    <label for="product_stock" class="form-label">Initial Stock</label>
                    <input type="number" class="form-control" name="product_stock" min="1">
                </div>
                <div class="col-md-6 form-group">
                    <label for="alert_quantity" class="form-label">Alert Quantity</label>
                    <input type="number" class="form-control" name="alert_quantity" min="1">
                </div>
                <div class="col-12 form-group">
                    <label for="short_description" class="form-label">Short Description</label>
                    <textarea type="text" class="form-control" name="short_description" cols="30" rows="5"></textarea>
                </div>
                <div class="col-12 form-group">
                    <label for="long_description" class="form-label">Long Description</label>
                    <textarea type="text" class="form-control" name="long_description" cols="30" rows="5"></textarea>
                </div>
                <div class="col-12 form-group">
                    <label for="additional_info" class="form-label">Addition Information</label>
                    <textarea type="text" class="form-control" name="additional_info" cols="30" rows="5"></textarea>
                </div>
                <div class="form-group col-12">
                    <label for="product_image">Product image</label>
                    <input type="file" name="product_image"
                        class="form-control @error('product_image') is-invalid @enderror dropify">
                    @error('product_image')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group col-12">
                    <label for="product_multiple_image">Product Multiple image</label>
                    <input type="file" multiple name="product_multiple_image[]"
                        class="form-control @error('product_multiple_image') is-invalid @enderror">
                    @error('product_multiple_image')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" checked
                        name="is_active">
                    <label class="form-check-label" for="is_active">Active or Inactive</label>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success">Store</button>
                </div>
            </form>
        </div>

        
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
