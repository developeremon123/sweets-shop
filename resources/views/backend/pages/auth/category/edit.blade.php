@extends('backend.layouts.master')
@push('admin_style')
@endpush
@section('title', 'edit-category')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="fw-bold">Edit Category</h3>
            <div class="d-flex justify-content-start">
                {{-- <a href="{{ route('admin.category.index') }}" class="btn btn-primary">Back</a> --}}
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.category.update',$category->slug) }}" method="post">
                @method('PUT')
                @csrf
                <div class="form-group">
                    <label for="category-title">Category Title</label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ $category->title }}" placeholder="enter category title">
                    @error('title')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-check form-switch mt-2">
                    <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" @if ($category->is_active) checked @endif name="is_active">
                    <label class="form-check-label" for="flexSwitchCheckChecked">Active or Inactive</label>
                  </div>
                <div class="form-group mt-2">
                    <button type="submit" class="btn btn-warning">Update</button>
                </div>
            </form>
        </div>
    </div>
@endsection
