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

    <!-- 🔹 Add Employee Button -->
    <div>
      <a href="{{ route('employees.create') }}" class="btn btn-primary">
        <i class="ti ti-plus"></i> Add Employee
      </a>
    </div>
  </div>
</div>
<!-- Breadcrumb end -->

<!-- ✅ Success Flash Message -->
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
          <table id="employees-table" class="display app-data-table default-data-table">
            <thead>
              <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Employee Code</th>
                <th>Status</th>
                <th class="text-center">Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach($employees as $employee)
              <tr>
                <td>{{ $employee->name }}</td>
                <td>{{ $employee->email }}</td>
                <td>{{ $employee->phone ?? '-' }}</td>
                <td>{{ $employee->employee_code }}</td>
                <td>
                  @if($employee->status == 'active')
                    <span class="badge text-light-success">Active</span>
                  @else
                    <span class="badge text-light-danger">Inactive</span>
                  @endif
                </td>
                <td class="text-center">
                  @if(!$employee->trashed())
                    <!-- Edit -->
                    <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-light-success icon-btn b-r-4" title="Edit">
                      <i class="ti ti-edit text-success"></i>
                    </a>

                    <!-- View -->
                    <a href="{{ route('employees.show', $employee->id) }}" class="btn btn-light-info icon-btn b-r-4" title="View">
                    <i class="ti ti-eye text-info"></i>
                    </a>

                    <!-- Soft Delete -->
                    <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" class="d-inline"
                      onsubmit="return confirm('Are you sure you want to delete this employee?');">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-light-danger icon-btn b-r-4" title="Delete">
                        <i class="ti ti-trash"></i>
                      </button>
                    </form>
                  @else
                    <!-- Restore -->
                    <form action="{{ route('employees.restore', $employee->id) }}" method="POST" class="d-inline"
                      onsubmit="return confirm('Restore this employee?');">
                      @csrf
                      <button type="submit" class="btn btn-light-info icon-btn b-r-4" title="Delete">
                        <i class="ti ti-refresh"></i>
                      </button>
                    </form>

                    <!-- Force Delete -->
                    <form action="{{ route('employees.forceDelete', $employee->id) }}" method="POST" class="d-inline"
                      onsubmit="return confirm('Permanently delete this employee? This cannot be undone.');">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-light-danger icon-btn b-r-4" title="Delete">
                        <i class="ti ti-trash"></i>
                      </button>
                    </form>
                  @endif
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- ✅ Initialize DataTable -->
<script>
  document.addEventListener("DOMContentLoaded", function () {
      new DataTable('#employees-table');
  });
</script>
@endsection
