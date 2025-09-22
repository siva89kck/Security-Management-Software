@extends('layouts.master')

@section('content')
    <!-- Breadcrumb start -->
    <div class="row m-1">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div>
                <h4 class="main-title">Stock List</h4>
                <ul class="app-line-breadcrumbs mb-3">
                    <li>
                        <a href="{{ route('dashboard') }}" class="f-s-14 f-w-500">
                            <span>
                                <i class="ph-duotone ph-newspaper f-s-16"></i> Dashboard
                            </span>
                        </a>
                    </li>
                    <li class="active">
                        <a href="#" class="f-s-14 f-w-500">Stock List</a>
                    </li>
                </ul>
            </div>

            <!-- Add Purchase Button -->
            <div>
                <a href="{{ route('purchases.create') }}" class="btn btn-primary">
                    <i class="ti ti-plus"></i> Add Stock
                </a>
            </div>
        </div>
    </div>
    <!-- Breadcrumb end -->

    <!-- Success Flash Message -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="ti ti-circle-check pe-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body p-0">
                    <div class="app-datatable-default overflow-auto">
                        <table id="purchase-table" class="display app-data-table default-data-table table-sm align-middle">
                            <thead>
                                <tr>
                                    <th>Purchase Number</th>
                                    <th>Purchase Date</th>
                                    <th>Supplier Name</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($purchases as $purchase)
                                    <tr>
                                        <td>
                                            <a href="{{ route('purchases.show', $purchase) }}" title="View"
                                                class="text-primary text-decoration-underline">
                                                {{ $purchase->purchase_number }}
                                            </a>
                                        </td>
                                        <td>{{ $purchase->purchase_date }}</td>
                                        <td>{{ $purchase->supplier_name }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('purchases.show', $purchase) }}"
                                                class="btn btn-light-info icon-btn b-r-4" title="View">
                                                <i class="ti ti-eye text-info"></i>
                                            </a>
                                            <a href="{{ route('purchases.edit', $purchase) }}"
                                                class="btn btn-light-success icon-btn b-r-4" title="Edit">
                                                <i class="ti ti-edit text-success"></i>
                                            </a>
                                            <form action="{{ route('purchases.destroy', $purchase) }}" method="POST"
                                                class="d-inline delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-light-danger icon-btn b-r-4" title="Delete">
                                                    <i class="ti ti-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="p-2">
                        {{ $purchases->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- DataTable Initialize with Excel Export -->
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        new DataTable('#purchase-table', {
            // dom = length dropdown + filter + table + buttons + info + pagination
            dom: '<"top"lBf>rt<"bottom"ip>',
            // Entries dropdown values
            lengthMenu: [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
            pageLength: 10, // default 10 rows
            buttons: [
                {
                    extend: 'excelHtml5',
                    title: 'Purchase List',
                    text: '<i class="ti ti-download"></i> Export Excel',
                    exportOptions: {
                        // skip actions column
                        columns: [0,1,2]
                    }
                }
            ]
        });
    });
    </script>
@endsection

<script>
document.addEventListener("DOMContentLoaded", function() {
    // DELETE CONFIRMATION ALERT
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            let formRef = this;

            Swal.fire({
                title: 'Are you sure?',
                text: "This will permanently delete the purchase record!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    formRef.submit();
                }
            });
        });
    });
});
</script>
