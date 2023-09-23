@extends('backend.layouts.master')

@push('admin_style')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.28/dist/sweetalert2.min.css"
        integrity="sha256-VJuwjrIWHWsPSEvQV4DiPfnZi7axOaiWwKfXaJnR5tA=" crossorigin="anonymous">

    <style>
        img {
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 2px;
            width: 100px;
        }
    </style>
@endpush

@section('title', 'Products-Index-Page')

@section('content')
    <div class="row">
        <div class="col-12">
            <h4>Products List Table</h4>
            <div class="d-flex justify-content-end">
                <a href="{{ route('admin.product.create') }}" class="btn btn-primary"><i class="fa-solid fa-plus"></i>Add
                    New Product</a>
            </div>
        </div>
        <div class="col-12 my-2">
            <table class="table table-striped table-bordered" id="dataTable">
                <thead>
                    <tr>
                        <th scope="row">#</th>
                        <th scope="row">Image</th>
                        <th scope="row">Last Modified</th>
                        <th scope="row">Category Name</th>
                        <th scope="row">Name</th>
                        <th scope="row">Slug</th>
                        <th scope="row">Price</th>
                        <th scope="row">Stock/Alert</th>
                        <th scope="row">Rating</th>
                        <th scope="row">Options</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <th>{{ $products->firstItem() + $loop->index }}</th>
                            <td>
                                <img src="{{ asset('upload/product') }}/{{ $product->product_image }}"
                                    class="img-fluid rounded-circle h-20 w-20">
                            </td>
                            <td>{{ $product->updated_at->format('d M Y') }}</td>
                            <td>{{ $product->category->title }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->slug }}</td>
                            <td>{{ $product->product_price }}</td>
                            <td>
                                <span class="badge bg-success">{{ $product->product_stock }}</span>/
                                <span class="badge bg-danger">{{ $product->alert_quantity }}</span>
                            </td>
                            <td>{{ $product->product_rating }}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-info dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        Settings
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item"
                                                href="{{ route('admin.product.edit', $product->slug) }}"><i
                                                    class="fa-solid fa-pen-to-square"></i>Edit</a></li>
                                        <li>
                                            <form action="{{ route('admin.product.destroy', $product->slug) }}"
                                                method="post" id="deleteForm">
                                                @csrf
                                                @method('DELETE')
                                                <button class="dropdown-item delete_confirm"><i
                                                        class="fa-solid fa-trash"></i>Delete</button>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.28/dist/sweetalert2.all.min.js"
        integrity="sha256-Cci6HROOxRjlhukr+AVya7ZcZnNZkLzvB7ccH/5aDic=" crossorigin="anonymous"></script>
    {!! Toastr::message() !!}
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
                pagingType: 'first_last_numbers',
            });
        });

        $('.delete_confirm').click(function(event) {
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
