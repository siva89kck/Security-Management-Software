@extends('layouts.employees.app')
@section('title','Add Employee')

@section('content')
<h3 class="mb-3">Add Employee</h3>

<form action="{{ route('employees.store') }}" method="post" enctype="multipart/form-data" class="card p-3">
  @csrf
  <div class="row g-3">
    <div class="col-md-6">
      <label class="form-label">Name *</label>
      <input name="name" class="form-control" value="{{ old('name') }}">
      @error('name') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6">
      <label class="form-label">Email *</label>
      <input name="email" type="email" class="form-control" value="{{ old('email') }}">
      @error('email') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6">
      <label class="form-label">Phone</label>
      <input name="phone" class="form-control" value="{{ old('phone') }}">
    </div>
    <div class="col-md-6">
      <label class="form-label">Employee Code *</label>
      <input name="employee_code" class="form-control" value="{{ old('employee_code') }}">
      @error('employee_code') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>
    <div class="col-12">
      <label class="form-label">Address</label>
      <textarea name="address" class="form-control" rows="2">{{ old('address') }}</textarea>
    </div>
    <div class="col-md-6">
      <label class="form-label">Address Proof (jpg/png/pdf)</label>
      <input name="address_proof" type="file" class="form-control">
    </div>
    <div class="col-md-6">
      <label class="form-label">Photo (jpg/png)</label>
      <input name="photo" type="file" class="form-control">
    </div>
    <div class="col-md-4">
      <label class="form-label">Status *</label>
      <select name="status" class="form-select">
        <option value="active" {{ old('status')==='active'?'selected':'' }}>active</option>
        <option value="inactive" {{ old('status')==='inactive'?'selected':'' }}>inactive</option>
      </select>
    </div>
  </div>

  <div class="mt-3 d-flex gap-2">
    <button class="btn btn-primary">Save</button>
    <a href="{{ route('employees.index') }}" class="btn btn-secondary">Cancel</a>
  </div>
</form>
@endsection
