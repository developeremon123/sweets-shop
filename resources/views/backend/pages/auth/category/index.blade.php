@extends('backend.layouts.master')

@push('admin_style')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
@endpush

@section('title','category-page')

@section('content')
<div class="row">
    <div class="col-12">
        <h4>Categories List Table</h4>
        <div class="d-flex justify-content-end">
            <a href="{{ route('admin.category.create') }}" class="btn btn-primary"><i class="fa-solid fa-plus"></i>Add New Category</a>
        </div>
    </div>
    <div class="col-12 my-2">
        <table class="table table-striped table-bordered" id="dataTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Category Name</th>
                    <th>Category Slug</th>
                    <th>Options</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $key => $category)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $category->title }}</td>
                        <td>{{ $category->slug }}</td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-info dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Settings
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#"><i class="fa-solid fa-pen-to-square"></i>Edit</a></li>
                                    <li><a class="dropdown-item" href="#"><i class="fa-solid fa-trash"></i>Delete</a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('admin_script')
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
{!! Toastr::message() !!}
<script>
    $(document).ready(function(){
        $('#dataTable').DataTable({
            pagingType:'first_last_numbers',
        });
    });
</script>
@endpush