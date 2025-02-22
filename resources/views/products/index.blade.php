@extends('layouts.app')

@section('title', 'AdminLTE v4 | Products')
@section('breadcrumb-title', 'Products')

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
@endpush
@section('content')

<a href="{{ route('products.create') }}" class="btn btn-success mb-3">Create a Product</a>

<div class="p-4">
    <table id="products-table" class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Category</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Actions</th>
            </tr>
        </thead>
    </table>
</div>

@endsection

@push('scripts')

<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script>
$(document).ready(function() {
    $('#products-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route("products.index") }}',
            error: function(xhr, error, thrown) {
                console.log('DataTables error:', error);
            }
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'category', name: 'category' },
            { 
                data: 'price', 
                name: 'price',
                render: function(data, type, row) {
                    return `$${parseFloat(data).toFixed(2)}`; 
                }
            },
            { data: 'stock', name: 'stock' },
            { data: 'actions', name: 'actions', orderable: false, searchable: false }
        ]
    });

    $(document).on('click', '.delete-product', function(e) {
        e.preventDefault();
        let button = $(this);
        let productId = button.data('id');
        
        if (confirm('Are you sure you want to delete this product?')) {
            button.prop('disabled', true).text('Deleting...');
            
            $.ajax({
                url: "/products/" + productId,
                type: "DELETE",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                success: function(response) {
                    if (response.success) {
                        $('#products-table').DataTable().ajax.reload();
                        alert(response.message);
                    } else {
                        alert('Error deleting product');
                    }
                },
                error: function(xhr) {
                    console.error('Delete error:', xhr);
                    alert('Error deleting product. Please try again.');
                },
                complete: function() {
                    button.prop('disabled', false).text('Delete');
                }
            });
        }
    });
});
</script>
@endpush
