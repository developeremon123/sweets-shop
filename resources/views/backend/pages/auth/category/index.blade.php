@extends('backend.layouts.master')

@push('admin_style')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.28/dist/sweetalert2.min.css" integrity="sha256-VJuwjrIWHWsPSEvQV4DiPfnZi7axOaiWwKfXaJnR5tA=" crossorigin="anonymous">
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
                    <th>Category Image</th>
                    <th>Last Modified</th>
                    <th>Category Name</th>
                    <th>Category Slug</th>
                    <th>Options</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $key => $category)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td><img src="{{ asset('upload/category') }}/{{ $category->category_image }}" alt="" class="img-fluid rounded h-20 w-20"></td>
                        <td>{{ $category->updated_at->format('d M Y') }}</td>
                        <td>{{ $category->title }}</td>
                        <td>{{ $category->slug }}</td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-info dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Settings
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('admin.category.edit',$category->slug) }}"><i class="fa-solid fa-pen-to-square"></i>Edit</a></li>
                                    <li>
                                        <form action="{{ route('admin.category.destroy',$category->slug) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button class="dropdown-item"><i class="fa-solid fa-trash"></i>Delete</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <h4>Trash List</h4>
    </div>
    <div class="col-12 my-2">
        <table class="table table-striped table-bordered" id="dataTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Category Image</th>
                    <th>Category Name</th>
                    <th>Last Modified</th>
                    <th>Category Slug</th>
                    <th>Options</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($delcategories as $key => $category)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td><img src="{{ asset('upload/category') }}/{{ $category->category_image }}" alt=""class="img-fluid rounded h-30 w-30"></td>
                        <td>{{ $category->updated_at->format('d M Y') }}</td>
                        <td>{{ $category->title }}</td>
                        <td>{{ $category->slug }}</td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-info dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Settings
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('admin.category.restore',$category->slug) }}"><i class="fa-solid fa-pen-to-square"></i>Restore</a></li>
                                    <li>
                                        <form action="{{ route('admin.category.perDelete', $category->slug) }}" method="" id="deleteForm">
                                            @csrf
                                            <button class="dropdown-item delete_confirm"><i class="fa-solid fa-trash"></i>Delete</button>
                                        </form>
                                        
                                    </li>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.28/dist/sweetalert2.all.min.js" integrity="sha256-Cci6HROOxRjlhukr+AVya7ZcZnNZkLzvB7ccH/5aDic=" crossorigin="anonymous"></script>
{!! Toastr::message() !!}
<script>
    $(document).ready(function(){
        $('#dataTable').DataTable({
            pagingType:'first_last_numbers',
        });
    });

    $('.delete_confirm').click(function(event){
        event.preventDefault();
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
            if (result.isConfirmed) {
                $('#deleteForm').submit();
                Swal.fire(
                'Deleted!',
                'Your file has been deleted.',
                'success'
                )
            }
        })
    })
</script>
@endpush