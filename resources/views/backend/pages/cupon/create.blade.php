@extends('backend.layouts.master')
@push('admin_style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css"
        integrity="sha512-EZSUkJWTjzDlspOoPSpUFR0o0Xy7jdzW//6qhUkoZ9c4StFkVsp9fbbd0O06p9ELS3H486m4wmrCELjza4JEog=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush
@section('title', 'create-cupon')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="fw-bold">Create Cupon Form</h3>
            <div class="d-flex justify-content-start">
                <a href="{{ route('admin.cupon.index') }}" class="btn btn-primary"><i class="fa-solid fa-backward"></i>Back</a>
            </div>
        </div>
        <div class="card-body">
            <form class="row g-3" method="post" action="{{ route('admin.cupon.store') }}">
                @csrf
                <div class="col-12 form-group">
                    <label for="cuponName" class="form-label">Cupon</label>
                    <input type="text" class="form-control" name="cuponName" placeholder="enter cupon code" @error('cuponName') is-invalid @enderror>
                     @error('cuponName')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="col-12 form-group">
                    <label for="discount-amount" class="form-label">Discount</label>
                    <input type="number" class="form-control" name="discount_amount"
                        placeholder="enter discount amount" @error('discount_amount') is-invalid @enderror min="0">
                         @error('discount_amount')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="col-12 form-group">
                    <label for="minimum-purchase-amount" class="form-label">Minimum Purchase Amount</label>
                    <input type="number" class="form-control" name="minimum_purchase_amount"
                        placeholder="enter minimum purchase amount" @error('minimum_purchase_amount') is-invalid @enderror min="0">
                         @error('minimum_purchase_amount')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="col-12 form-group">
                    <label for="validity-till" class="form-label">Expiry Date</label>
                    <input type="date" class="form-control" name="validity_till" min="0" @error('validity_till') is-invalid @enderror>
                     @error('validity_till')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" checked
                        name="is_active">
                    <label class="form-check-label" for="is-active">Active or Inactive</label>
                    @error('is_active')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
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
