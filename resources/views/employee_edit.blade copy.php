@extends('layouts.master')

@section('content')
    <!-- Breadcrumb start -->
    <div class="row m-1">
        <div class="col-12">
            <h4 class="main-title">Edit Employees</h4>
            <ul class="app-line-breadcrumbs mb-3">
                <li>
                    <a href="{{ route('dashboard') }}" class="f-s-14 f-w-500">
                        <span>
                            <i class="ph-duotone ph-newspaper f-s-16"></i> Dashboard
                        </span>
                    </a>
                </li>
                <li class="active">
                    <a href="#" class="f-s-14 f-w-500">Edit Employees</a>
                </li>
            </ul>
        </div>
    </div>

    <!-- ✅ Success Flash Message -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="ti ti-circle-check pe-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form action="{{ route('employees.update', $employee->id) }}" method="POST" enctype="multipart/form-data"
        class="app-form needs-validation" novalidate>
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    {{-- <div class="card-header bg-light">
                        <h5 class="mb-0">Edit Employees Info</h5>
                    </div> --}}
                    <div class="card-body">
                        <div class="form-wizard">
                            <div class="row">

                                <!-- Sidebar Tabs -->
                                <div class="col-xl-3 mb-3">
                                    <div class="nav navstpes flex-column" id="Basic" role="tablist">
                                        <button class="nav-link active" id="personal-tab" data-bs-toggle="tab"
                                            data-bs-target="#tab-personal" type="button" role="tab">
                                            <i class="ti ti-user-circle pe-2"></i>
                                            <span class="ms-3">Personal Info</span>
                                        </button>
                                        <button class="nav-link" id="contact-tab" data-bs-toggle="tab"
                                            data-bs-target="#tab-contact" type="button" role="tab">
                                            <i class="ti ti-info-circle pe-2"></i>
                                            <span class="ms-3">Document Proof</span>
                                        </button>
                                        <button class="nav-link" id="bank-tab" data-bs-toggle="tab"
                                            data-bs-target="#tab-bank" type="button" role="tab">
                                            <i class="ti ti-brand-mastercard pe-2"></i>
                                            <span class="ms-3">Bank Info</span>
                                        </button>
                                    </div>
                                </div>

                                <!-- Tab Content -->
                                <div class="col-xl-9">
                                    <div class="tab-content" id="employee-tabs-content">

                                        <!-- Personal Info -->
                                        <div class="tab-pane fade show active" id="tab-personal" role="tabpanel"
                                            aria-labelledby="personal-tab">
                                            <div class="row">
                                                <div class="col-12 mb-3">
                                                    <label class="form-label f-w-500">Name <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" name="name"
                                                        class="form-control @error('name') is-invalid @enderror"
                                                        value="{{ old('name', $employee->name) }}" required>
                                                    <div class="invalid-feedback">Please enter a name.</div>
                                                    @error('name')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>

                                                <div class="col-12 mb-3">
                                                    <label class="form-label f-w-500">Email <span
                                                            class="text-danger">*</span></label>
                                                    <input type="email" name="email"
                                                        class="form-control @error('email') is-invalid @enderror"
                                                        value="{{ old('email', $employee->email) }}" required>
                                                    <div class="invalid-feedback">Please enter a valid email.</div>
                                                    @error('email')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>

                                                <div class="col-12 mb-3">
                                                    <label class="form-label f-w-500">Phone</label>
                                                    <input type="text" name="phone"
                                                        class="form-control @error('phone') is-invalid @enderror"
                                                        value="{{ old('phone', $employee->phone) }}">
                                                    @error('phone')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>

                                                <div class="col-12 mb-3">
                                                    <label class="form-label f-w-500">Employee Code <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" name="employee_code"
                                                        class="form-control @error('employee_code') is-invalid @enderror"
                                                        value="{{ old('employee_code', $employee->employee_code) }}"
                                                        required>
                                                    <div class="invalid-feedback">Employee code required.</div>
                                                    @error('employee_code')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Contact Info -->
                                        <div class="tab-pane fade" id="tab-contact" role="tabpanel"
                                            aria-labelledby="contact-tab">
                                            <div class="row">
                                                <div class="col-12 mb-3">
                                                    <label class="form-label f-w-500">Address</label>
                                                    <textarea name="address" class="form-control">{{ old('address', $employee->address) }}</textarea>
                                                    @error('address')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>

                                                <div class="col-12 mb-3">
                                                    <label class="form-label f-w-500">PAN Card</label>
                                                    <input type="file" name="pan_card"
                                                        class="form-control @error('pan_card') is-invalid @enderror"
                                                        accept=".pdf,.jpg,.jpeg,.png">
                                                    @if ($employee->pan_card)
                                                        <small class="d-block mt-1">Current: <a
                                                                href="{{ asset('storage/' . $employee->pan_card) }}"
                                                                target="_blank">View File</a></small>
                                                    @endif
                                                    <div class="invalid-feedback">Invalid file format.</div>
                                                    @error('pan_card')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>

                                                <div class="col-12 mb-3">
                                                    <label class="form-label f-w-500">Address Proof</label>
                                                    <input type="file" name="address_proof"
                                                        class="form-control @error('address_proof') is-invalid @enderror"
                                                        accept=".pdf,.jpg,.jpeg,.png">
                                                    @if ($employee->address_proof)
                                                        <small class="d-block mt-1">Current: <a
                                                                href="{{ asset('storage/' . $employee->address_proof) }}"
                                                                target="_blank">View File</a></small>
                                                    @endif
                                                    <div class="invalid-feedback">Invalid file format.</div>
                                                    @error('address_proof')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>

                                                <div class="col-12 mb-3">
                                                    <label class="form-label f-w-500">Photo</label>
                                                    <input type="file" name="photo"
                                                        class="form-control @error('photo') is-invalid @enderror"
                                                        accept=".jpg,.jpeg,.png">
                                                    @if ($employee->photo)
                                                        <small class="d-block mt-1">Current: <a
                                                                href="{{ asset('storage/' . $employee->photo) }}"
                                                                target="_blank">View Photo</a></small>
                                                    @endif
                                                    <div class="invalid-feedback">Invalid image format.</div>
                                                    @error('photo')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Bank Info -->
                                        <div class="tab-pane fade" id="tab-bank" role="tabpanel"
                                            aria-labelledby="bank-tab">
                                            <div class="row">
                                                <div class="col-12 mb-3">
                                                    <label class="form-label f-w-500">Bank Name</label>
                                                    <input type="text" name="bank_name" class="form-control"
                                                        value="{{ old('bank_name', $employee->bank_name) }}">
                                                </div>

                                                <div class="col-12 mb-3">
                                                    <label class="form-label f-w-500">Branch Name</label>
                                                    <input type="text" name="branch_name" class="form-control"
                                                        value="{{ old('branch_name', $employee->branch_name) }}">
                                                </div>

                                                <div class="col-12 mb-3">
                                                    <label class="form-label f-w-500">Account Holder Name</label>
                                                    <input type="text" name="account_holder_name" class="form-control"
                                                        value="{{ old('account_holder_name', $employee->account_holder_name) }}">
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label f-w-500">Account Number</label>
                                                    <input type="text" name="account_number" class="form-control"
                                                        value="{{ old('account_number', $employee->account_number) }}">
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label f-w-500">IFSC Code</label>
                                                    <input type="text" name="ifsc_code" class="form-control"
                                                        value="{{ old('ifsc_code', $employee->ifsc_code) }}">
                                                </div>

                                                @if (Auth::user()->role === 'admin')
                                                    <div class="col-12 mb-3">
                                                        <label class="form-label f-w-500">Status</label>
                                                        <select name="status" class="form-select">
                                                            <option value="active"
                                                                {{ old('status', $employee->status) == 'active' ? 'selected' : '' }}>
                                                                Active</option>
                                                            <option value="inactive"
                                                                {{ old('status', $employee->status) == 'inactive' ? 'selected' : '' }}>
                                                                Inactive</option>
                                                        </select>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Submit -->
                                        <div class="text-end mt-4">
                                            <button type="submit" class="btn btn-primary px-4">
                                                <i class="ti ti-device-floppy pe-1"></i> Update
                                            </button>
                                        </div>
                                    </div> <!-- tab-content -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!-- Breadcrumb end -->

    <!-- ✅ Bootstrap 5 Client-side Validation -->
    <script>
        (function() {
            'use strict';
            let forms = document.querySelectorAll('.needs-validation');
            Array.prototype.slice.call(forms).forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        })();
    </script>
@endsection
