@extends('layouts.master')

@section('content')
    <!-- Breadcrumb start -->
    <div class="row m-1">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div>
                <h4 class="main-title">Employees List</h4>
                <ul class="app-line-breadcrumbs mb-3">
                    <li>
                        <a href="{{ route('dashboard') }}" class="f-s-14 f-w-500">
                            <span>
                                <i class="ph-duotone ph-newspaper f-s-16"></i> Dashboard
                            </span>
                        </a>
                    </li>
                    <li class="active">
                        <a href="#" class="f-s-14 f-w-500">Employees List</a>
                    </li>
                </ul>
            </div>

            <!-- Add Employee Button -->
            <div>
                <a href="{{ route('employees.create') }}" class="btn btn-primary">
                    <i class="ti ti-plus"></i> Add Employee
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
                        <table id="employees-table" class="display app-data-table default-data-table table-sm align-middle">
                            <thead>
                                <tr>
                                    <th>Employee Code</th>
                                    <th>Name</th>
                                    <th>Role</th>
                                    <th>Phone</th>
                                    <th>Present City</th>
                                    <th>Status</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($employees as $e)
                                    <tr>
                                        <td>
                                            <a href="{{ route('employees.show', $e) }}" title="View" class="text-primary text-decoration-underline">
                                                {{ $e->employee_code }}
                                            </a>
                                        </td>
                                        <td>{{ $e->first_name }} {{ $e->last_name }}</td>
                                        <td>{{ $e->officialDetail->role ?? '-' }}</td>
                                        <td>{{ $e->mobile ?? $e->phone }}</td>
                                        <td>{{ optional($e->addresses->first())->city ?? '-' }}</td>
                                        <td>
                                            <button
                                                class="btn btn-sm status-btn w-100 {{ $e->status == 'active' ? 'btn-success' : 'btn-danger' }}"
                                                data-id="{{ $e->id }}">
                                                {{ ucfirst($e->status) }}
                                            </button>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('employees.show', $e) }}"
                                                class="btn btn-light-info icon-btn b-r-4" title="View">
                                                <i class="ti ti-eye text-info"></i>
                                            </a>
                                            <a href="{{ route('employees.edit', $e) }}"
                                                class="btn btn-light-success icon-btn b-r-4" title="Edit">
                                                <i class="ti ti-edit text-success"></i>
                                            </a>
                                            <form action="{{ route('employees.destroy', $e) }}" method="POST"
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
                        {{ $employees->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- <!-- DataTables Buttons CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">

    <!-- DataTables Buttons JS -->
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script> --}}

    <!-- Initialize DataTable with Excel Export -->
    <script>
document.addEventListener("DOMContentLoaded", function() {
    new DataTable('#employees-table', {
        // dom = length dropdown + filter + table + buttons + info + pagination
        dom: '<"top"lBf>rt<"bottom"ip>',
        // Entries dropdown values
        lengthMenu: [
            [10, 25, 50, 100, -1],  // -1 = All
            [10, 25, 50, 100, "All"]
        ],
        pageLength: 10, // default 10 rows
        buttons: [
            {
                extend: 'excelHtml5',
                title: 'Employees List',
                text: '<i class="ti ti-download"></i> Export Excel',
                exportOptions: {
                    // Actions column skip
                    columns: [0,1,2,3,4,5]
                }
            }
        ]
    });
});
</script>

@endsection

<script>
document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll(".status-btn").forEach(button => {
        button.addEventListener("click", function() {
            let id = this.dataset.id;
            let btn = this;
            let currentStatus = btn.textContent.trim().toLowerCase();

            Swal.fire({
                title: currentStatus === 'active' ? 'Make Inactive?' : 'Make Active?',
                text: `Are you sure you want to change this employee status to ${currentStatus === 'active' ? 'Inactive' : 'Active'}?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, change it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/employees/${id}/toggle-status`, {
                            method: "PATCH",
                            headers: {
                                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                                "Content-Type": "application/json"
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                if (data.status === "active") {
                                    btn.classList.remove("btn-danger");
                                    btn.classList.add("btn-success");
                                    btn.textContent = "Active";
                                    Swal.fire({
                                        toast: true,
                                        position: 'top-end',
                                        icon: 'success',
                                        title: 'Employee Activated',
                                        showConfirmButton: false,
                                        timer: 2000
                                    });
                                } else {
                                    btn.classList.remove("btn-success");
                                    btn.classList.add("btn-danger");
                                    btn.textContent = "Inactive";
                                    Swal.fire({
                                        toast: true,
                                        position: 'top-end',
                                        icon: 'warning',
                                        title: 'Employee Deactivated',
                                        showConfirmButton: false,
                                        timer: 2000
                                    });
                                }
                            }
                        });
                }
            });
        });
    });
});
</script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // DELETE CONFIRMATION ALERT
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            let formRef = this;

            Swal.fire({
                title: 'Are you sure?',
                text: "This will permanently delete the employee record!",
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
