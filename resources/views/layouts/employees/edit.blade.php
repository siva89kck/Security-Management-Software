@extends('layouts.employees.app')
@section('title','Edit Employee')

@section('content')
<h3 class="mb-3">Edit: {{ $employee->name }}</h3>

<form action="{{ route('employees.update',$employee) }}" method="post" enctype="multipart/form-data" class="card p-3">
  @csrf @method('PUT')
  <div class="row g-3">
    <div class="col-md-6">
      <label class="form-label">Name *</label>
      <input name="name" class="form-control" value="{{ old('name',$employee->name) }}">
      @error('name') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6">
      <label class="form-label">Email *</label>
      <input name="email" type="email" class="form-control" value="{{ old('email',$employee->email) }}">
      @error('email') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6">
      <label class="form-label">Phone</label>
      <input name="phone" class="form-control" value="{{ old('phone',$employee->phone) }}">
    </div>
    <div class="col-md-6">
      <label class="form-label">Employee Code *</label>
      <input name="employee_code" class="form-control" value="{{ old('employee_code',$employee->employee_code) }}">
      @error('employee_code') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>
    <div class="col-12">
      <label class="form-label">Address</label>
      <textarea name="address" class="form-control" rows="2">{{ old('address',$employee->address) }}</textarea>
    </div>
    <div class="col-md-6">
      <label class="form-label">Address Proof (replace)</label>
      <input name="address_proof" type="file" class="form-control">
      @if($employee->address_proof)
        <small class="text-muted">Current: {{ $employee->address_proof }}</small>
      @endif
    </div>
    <div class="col-md-6">
      <label class="form-label">Photo (replace)</label>
      <input name="photo" type="file" class="form-control">
      @if($employee->photo)
        <small class="text-muted">Current: {{ $employee->photo }}</small>
      @endif
    </div>
    <div class="col-md-4">
      <label class="form-label">Status *</label>
      <select name="status" class="form-select">
        <option value="active"   @selected(old('status',$employee->status)==='active')>active</option>
        <option value="inactive" @selected(old('status',$employee->status)==='inactive')>inactive</option>
      </select>
    </div>
  </div>

  <div class="mt-3 d-flex gap-2">
    <button class="btn btn-primary">Update</button>
    <a href="{{ route('employees.index') }}" class="btn btn-secondary">Back</a>
  </div>
</form>
@endsection
