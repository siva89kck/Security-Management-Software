@extends('layouts.master')

@section('content')
    <div class="row m-1">
        <div class="col-12">
            <h4 class="main-title">Add Employees</h4>
            <ul class="app-line-breadcrumbs mb-3">
                <li>
                    <a href="{{ route('dashboard') }}" class="f-s-14 f-w-500">
                        <span>
                            <i class="ph-duotone ph-newspaper f-s-16"></i> Dashboard
                        </span>
                    </a>
                </li>
                <li class="active">
                    <a href="#" class="f-s-14 f-w-500">Add Employees</a>
                </li>
            </ul>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="ti ti-circle-check pe-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="ti ti-circle-x pe-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form action="{{ route('employees.store') }}" method="POST" enctype="multipart/form-data"
        class="app-form needs-validation" novalidate>
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="form-wizard">
                            <div class="row">
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
                                            <span class="ms-3">Document & Address</span>
                                        </button>
                                        <button class="nav-link" id="bank-tab" data-bs-toggle="tab"
                                            data-bs-target="#tab-bank" type="button" role="tab">
                                            <i class="ti ti-brand-mastercard pe-2"></i>
                                            <span class="ms-3">Bank Info</span>
                                        </button>
                                        <button class="nav-link" id="official-tab" data-bs-toggle="tab"
                                            data-bs-target="#tab-official" type="button" role="tab">
                                            <i class="ti ti-id-badge pe-2"></i>
                                            <span class="ms-3">Official Details</span>
                                        </button>
                                    </div>
                                </div>

                                <div class="col-xl-9">
                                    <div class="tab-content" id="employee-tabs-content">

                                        <div class="tab-pane fade show active" id="tab-personal" role="tabpanel"
                                            aria-labelledby="personal-tab">
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label f-w-500">First Name <span class="text-danger">*</span></label>
                                                    <input type="text" name="first_name" class="form-control" value="{{ old('first_name') }}" required>
                                                    @error('first_name')<small class="text-danger">{{ $message }}</small>@enderror
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label f-w-500">Last Name</label>
                                                    <input type="text" name="last_name" class="form-control" value="{{ old('last_name') }}">
                                                </div>
                                                {{-- <div class="col-md-6 mb-3">
                                                    <label class="form-label f-w-500">Email <span class="text-danger">*</span></label>
                                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                                                    @error('email')<small class="text-danger">{{ $message }}</small>@enderror
                                                </div> --}}
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label f-w-500">Phone</label>
                                                    <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label f-w-500">Mobile</label>
                                                    <input type="text" name="mobile" class="form-control" value="{{ old('mobile') }}">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label f-w-500">Alternate Mobile</label>
                                                    <input type="text" name="alt_mobile" class="form-control" value="{{ old('alt_mobile') }}">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label f-w-500">Date of Birth</label>
                                                    <input type="date" name="dob" class="form-control" value="{{ old('dob') }}">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label f-w-500">Gender</label>
                                                    <select name="gender" class="form-select">
                                                        <option value="">Select Gender</option>
                                                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                                        <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label f-w-500">Education Qualification</label>
                                                    <input type="text" name="education_qualification" class="form-control" value="{{ old('education_qualification') }}">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label f-w-500">Marital Status</label>
                                                    <input type="text" name="marital_status" class="form-control" value="{{ old('marital_status') }}">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label f-w-500">Nationality</label>
                                                    <input type="text" name="nationality" class="form-control" value="{{ old('nationality') }}">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label f-w-500">Religion</label>
                                                    <input type="text" name="religion" class="form-control" value="{{ old('religion') }}">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label f-w-500">Caste</label>
                                                    <input type="text" name="caste" class="form-control" value="{{ old('caste') }}">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label f-w-500">Sub Caste</label>
                                                    <input type="text" name="sub_caste" class="form-control" value="{{ old('sub_caste') }}">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label f-w-500">Blood Group</label>
                                                    <input type="text" name="blood_group" class="form-control" value="{{ old('blood_group') }}">
                                                </div>
                                                <div class="col-12 mb-3">
                                                    <label class="form-label f-w-500">Remarks</label>
                                                    <textarea name="remarks" class="form-control">{{ old('remarks') }}</textarea>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label f-w-500">Recommended By</label>
                                                    <input type="text" name="recommended_by" class="form-control" value="{{ old('recommended_by') }}">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label f-w-500">Recommended Address</label>
                                                    <input type="text" name="recommended_address" class="form-control" value="{{ old('recommended_address') }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="tab-contact" role="tabpanel" aria-labelledby="contact-tab">
                                            <div class="row">
                                                <div class="col-12 mb-3">
                                                    <label class="form-label f-w-500">Address Line 1</label>
                                                    <input type="text" name="address_line1" class="form-control" value="{{ old('address_line1') }}">
                                                </div>
                                                <div class="col-12 mb-3">
                                                    <label class="form-label f-w-500">Address Line 2</label>
                                                    <input type="text" name="address_line2" class="form-control" value="{{ old('address_line2') }}">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label f-w-500">City</label>
                                                    <input type="text" name="city" class="form-control" value="{{ old('city') }}">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label f-w-500">State</label>
                                                    <input type="text" name="state" class="form-control" value="{{ old('state') }}">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label f-w-500">Pincode</label>
                                                    <input type="text" name="pincode" class="form-control" value="{{ old('pincode') }}">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label f-w-500">Pan Card</label>
                                                    <input type="file" name="pan_card" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                                                    @error('pan_card')<small class="text-danger">{{ $message }}</small>@enderror
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label f-w-500">Address Proof</label>
                                                    <input type="file" name="address_proof" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                                                    @error('address_proof')<small class="text-danger">{{ $message }}</small>@enderror
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label f-w-500">Photo</label>
                                                    <input type="file" name="photo" class="form-control" accept=".jpg,.jpeg,.png">
                                                    @error('photo')<small class="text-danger">{{ $message }}</small>@enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="tab-bank" role="tabpanel" aria-labelledby="bank-tab">
                                            <div class="row">
                                                <div class="col-12 mb-3">
                                                    <label class="form-label f-w-500">Bank Name</label>
                                                    <input type="text" name="bank_name" class="form-control" value="{{ old('bank_name') }}">
                                                </div>
                                                <div class="col-12 mb-3">
                                                    <label class="form-label f-w-500">Account Holder Name</label>
                                                    <input type="text" name="account_holder_name" class="form-control" value="{{ old('account_holder_name') }}">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label f-w-500">Account Number</label>
                                                    <input type="text" name="account_number" class="form-control" value="{{ old('account_number') }}">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label f-w-500">IFSC Code</label>
                                                    <input type="text" name="ifsc_code" class="form-control" value="{{ old('ifsc_code') }}">
                                                </div>
                                                <div class="col-12 mb-3">
                                                    <label class="form-label f-w-500">Branch Name</label>
                                                    <input type="text" name="branch_name" class="form-control" value="{{ old('branch_name') }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="tab-official" role="tabpanel" aria-labelledby="official-tab">
                                            <div class="row">
                                                {{-- <div class="col-md-6 mb-3">
                                                    <label class="form-label f-w-500">Employee Code <span class="text-danger">*</span></label>
                                                    <input type="text" name="employee_code" class="form-control @error('employee_code') is-invalid @enderror" value="{{ old('employee_code') }}" required>
                                                    @error('employee_code')<small class="text-danger">{{ $message }}</small>@enderror
                                                </div> --}}
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label f-w-500">Role</label>
                                                    <select name="role" class="form-select">
                                                        <option value="Security Guard">Security Guard</option>
                                                        <option value="Admin">Admin</option>
                                                        <option value="Supervisor">Supervisor</option>
                                                        <option value="Field Officer">Field Officer</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label f-w-500">Date of Joining</label>
                                                    <input type="date" name="date_of_join" class="form-control" value="{{ old('date_of_join') }}">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label f-w-500">Employee Type</label>
                                                    <select name="employee_type" class="form-select">
                                                        <option value="Permanent">Permanent</option>
                                                        <option value="Temporary">Temporary</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label f-w-500">Salary</label>
                                                    <input type="number" step="0.01" name="salary" class="form-control" value="{{ old('salary') }}">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label f-w-500">PF Number</label>
                                                    <input type="text" name="pf_number" class="form-control" value="{{ old('pf_number') }}">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label f-w-500">ESI Number</label>
                                                    <input type="text" name="esi_number" class="form-control" value="{{ old('esi_number') }}">
                                                </div>
                                                <div class="col-md-6 mb-3 form-check form-switch pt-3">
                                                    <input class="form-check-input" type="checkbox" role="switch" name="pf_calculation" id="pfCalculationSwitch" {{ old('pf_calculation') ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="pfCalculationSwitch">PF Calculation</label>
                                                </div>
                                                <div class="col-md-6 mb-3 form-check form-switch pt-3">
                                                    <input class="form-check-input" type="checkbox" role="switch" name="esi_calculation" id="esiCalculationSwitch" {{ old('esi_calculation') ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="esiCalculationSwitch">ESI Calculation</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="text-end mt-4">
                                            <button type="submit" class="btn btn-primary px-4">
                                                <i class="ti ti-device-floppy pe-1"></i> Submit
                                            </button>
                                        </div>
                                    </div> </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
