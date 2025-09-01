@extends('layouts.employees.app')
@section('title','Employees List')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h3 class="mb-0">Employees</h3>
  <a href="{{ route('employees.create') }}" class="btn btn-primary">+ Add Employee</a>
</div>

<form class="row g-2 mb-3" method="get">
  <div class="col-sm-4">
    <input type="text" name="q" class="form-control" placeholder="Search name/email/code" value="{{ $q }}">
  </div>
  <div class="col-sm-3">
    <select name="status" class="form-select">
      <option value="">All Status</option>
      <option value="active"   @selected($status==='active')>active</option>
      <option value="inactive" @selected($status==='inactive')>inactive</option>
    </select>
  </div>
  <div class="col-sm-2">
    <button class="btn btn-outline-secondary w-100">Filter</button>
  </div>
</form>

<div class="card">
  <div class="table-responsive">
    <table class="table table-striped align-middle mb-0">
      <thead>
        <tr>
          <th>#</th><th>Name</th><th>Email</th><th>Code</th><th>Status</th><th>Actions</th>
        </tr>
      </thead>
      <tbody>
      @forelse($employees as $emp)
        <tr>
          <td>{{ $emp->id }}</td>
          <td>{{ $emp->name }}</td>
          <td>{{ $emp->email }}</td>
          <td>{{ $emp->employee_code }}</td>
          <td>
            <span class="badge bg-{{ $emp->status==='active'?'success':'secondary' }}">
              {{ $emp->status }}
            </span>
          </td>
          <td class="d-flex gap-2">
            <a href="{{ route('employees.edit',$emp) }}" class="btn btn-sm btn-warning">Edit</a>
            <form action="{{ route('employees.destroy',$emp) }}" method="post" onsubmit="return confirm('Delete this employee?')">
              @csrf @method('DELETE')
              <button class="btn btn-sm btn-danger">Delete</button>
            </form>
          </td>
        </tr>
      @empty
        <tr><td colspan="6" class="text-center p-4">No employees found</td></tr>
      @endforelse
      </tbody>
    </table>
  </div>
  <div class="card-footer">
    {{ $employees->links() }}
  </div>
</div>
@endsection
