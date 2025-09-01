@extends('layouts.master')

@section('content')
<!-- Breadcrumb start -->
<div class="row m-1">
  <div class="col-12 d-flex justify-content-between align-items-center">
    <div>
      <h4 class="main-title">View Employee</h4>
      <ul class="app-line-breadcrumbs mb-3">
        <li>
          <a href="{{ route('dashboard') }}" class="f-s-14 f-w-500">
            <span>
              <i class="ph-duotone ph-newspaper f-s-16"></i> Dashboard
            </span>
          </a>
        </li>
        <li class="active">
          <a href="#" class="f-s-14 f-w-500">View Employee</a>
        </li>
      </ul>
    </div>

    <!-- 🔹 Back Button -->
    <div>
      <a href="{{ route('employees.index') }}" class="btn btn-secondary">
        <i class="ti ti-arrow-left"></i> Back To List
      </a>
    </div>
  </div>
</div>

<div class="card border-0 rounded-3">
  <div class="card-body">
    <div class="row">
      <!-- Left Column -->
      <div class="col-md-8">
        <h5 class="mb-3 text-primary"><i class="ti ti-user"></i> Personal Details</h5>
        <div class="row mb-3">
          <div class="col-md-6">
            <p><strong>Name:</strong> {{ $employee->name }}</p>
          </div>
          <div class="col-md-6">
            <p><strong>Email:</strong> {{ $employee->email }}</p>
          </div>
          <div class="col-md-6">
            <p><strong>Phone:</strong> {{ $employee->phone ?? '-' }}</p>
          </div>
          <div class="col-md-6">
            <p><strong>Employee Code:</strong> {{ $employee->employee_code }}</p>
          </div>
          <div class="col-md-12">
            <p><strong>Address:</strong> {{ $employee->address ?? '-' }}</p>
          </div>
          <div class="col-md-6">
            <p><strong>Status:</strong>
              @if($employee->status == 'active')
                <span class="badge bg-success">Active</span>
              @else
                <span class="badge bg-danger">Inactive</span>
              @endif
            </p>
          </div>
        </div>

        <h5 class="mt-4 mb-3 text-primary"><i class="ti ti-id"></i> Documents</h5>
        <div class="row mb-3">
          <div class="col-md-6">
            <p><strong>PAN Card:</strong>
              @if($employee->pan_card)
                <a href="{{ asset('storage/' . $employee->pan_card) }}"
                   target="_blank"
                   class="btn btn-sm btn-outline-primary">View</a>
              @else
                Not Uploaded
              @endif
            </p>
          </div>
          <div class="col-md-6">
            <p><strong>Address Proof:</strong>
              @if($employee->address_proof)
                <a href="{{ asset('storage/' . $employee->address_proof) }}"
                   target="_blank"
                   class="btn btn-sm btn-outline-primary">View</a>
              @else
                Not Uploaded
              @endif
            </p>
          </div>
        </div>

        <h5 class="mt-4 mb-3 text-primary"><i class="ti ti-building-bank"></i> Bank Details</h5>
        <div class="row">
          <div class="col-md-6">
            <p><strong>Bank Name:</strong> {{ $employee->bank_name ?? '-' }}</p>
          </div>
          <div class="col-md-6">
            <p><strong>Branch:</strong> {{ $employee->branch_name ?? '-' }}</p>
          </div>
          <div class="col-md-6">
            <p><strong>Account Holder:</strong> {{ $employee->account_holder_name ?? '-' }}</p>
          </div>
          <div class="col-md-6">
            <p><strong>Account Number:</strong> {{ $employee->account_number ?? '-' }}</p>
          </div>
          <div class="col-md-6">
            <p><strong>IFSC Code:</strong> {{ $employee->ifsc_code ?? '-' }}</p>
          </div>
        </div>
      </div>

      <!-- Right Column (Photo) -->
      <div class="col-md-4 text-center">
        <h5 class="mb-3 text-primary"><i class="ti ti-photo"></i> Photo</h5>
        @if($employee->photo)
          <img src="{{ asset('storage/' . $employee->photo) }}"
               class="img-thumbnail rounded-circle mb-3"
               style="width: 200px; height: 200px; object-fit: cover;">
        @else
          <img src="https://via.placeholder.com/200"
               class="img-thumbnail rounded-circle mb-3"
               alt="No Photo">
        @endif
      </div>
    </div>
  </div>
</div>
@endsection
