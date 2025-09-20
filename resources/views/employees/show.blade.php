@extends('layouts.master')

@section('content')
<style>
    /* Wizard Left Side Tabs */
    .form-wizard .navstpes .nav-link {
        padding-top: 6px;
        padding-bottom: 6px;
        font-size: 14px;
        display: flex;
        align-items: center;
    }

    /* Icon size reduce */
    .form-wizard .navstpes .nav-link i {
        font-size: 16px;
        width: auto;
        min-width: 20px;
        text-align: center;
    }

    /* Icon and text spacing */
    .form-wizard .navstpes .nav-link span {
        margin-left: 6px;
    }

    /* New styles for the redesigned right side */
    .employee-profile-header {
        display: flex;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid #e9ecef;
    }

    .profile-image-container {
        position: relative;
        margin-right: 1.5rem;
    }

    .profile-image {
        width: 100px;
        height: 100px;
        border-radius: 12px;
        object-fit: cover;
        border: 3px solid #fff;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .status-badge {
        position: absolute;
        bottom: 5px;
        right: 5px;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        border: 2px solid #fff;
    }

    .status-active {
        background-color: #28a745;
    }

    .status-inactive {
        background-color: #6c757d;
    }

    .employee-basic-info h3 {
        margin-bottom: 0.25rem;
        font-weight: 600;
        color: #2c3e50;
    }

    .employee-id {
        color: #6c757d;
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
    }

    .employee-position {
        color: #4a6cf7;
        font-weight: 500;
        margin-bottom: 0.5rem;
    }

    .employee-department {
        color: #6c757d;
        font-size: 0.9rem;
    }

    /* .detail-card {
        background: #fff;
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 1rem;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        border: 1px solid #e9ecef;
    } */

    .detail-card {
       background: #f9fafd;
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 20px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    }

    .detail-card:hover {
    box-shadow: 0 4px 12px rgba(0,0,0,0.12);
}


    .detail-card .label {
        font-size: 0.8rem;
        color: #6c757d;
        margin-bottom: 0.25rem;
    }

    .detail-card .value {
        font-weight: 500;
        color: #2c3e50;
        margin-bottom: 0;
    }

    .section-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid #e9ecef;
    }

    .tab-content {
        background: #fff;
        border-radius: 8px;
        padding: 1.5rem;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
    }
</style>
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
        <li class="">
          <a href="{{ route('employees.index') }}" class="f-s-14 f-w-500">List Employee</a>
        </li>
        <li class="active">
          <a href="#" class="f-s-14 f-w-500">View Employee</a>
        </li>
      </ul>
    </div>

    <!-- Add Employee Button -->
    <div>
      <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-success">
        <i class="ti ti-edit"></i> Edit Employee
      </a>
    </div>
  </div>
</div>
<!-- Breadcrumb end -->

<form action="{{ route('employees.update', $employee->id) }}" method="POST" enctype="multipart/form-data"
    class="app-form needs-validation" novalidate>
    @csrf
    @method('PUT')

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="form-wizard">
                        <div class="row">
                            <!-- Wizard Tabs -->
                            <div class="col-xl-3 mb-3">
                                <div class="nav navstpes flex-column" id="employeeWizard" role="tablist">
                                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab-personal"
                                        type="button">
                                        <i class="ti ti-user-circle pe-2"></i><span class="ms-2">Personal Info</span>
                                    </button>
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-address"
                                        type="button">
                                        <i class="ti ti-home pe-2"></i><span class="ms-2">Address Info</span>
                                    </button>
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-languages"
                                        type="button">
                                        <i class="ti ti-language pe-2"></i><span class="ms-2">Languages</span>
                                    </button>
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-family"
                                        type="button">
                                        <i class="ti ti-users pe-2"></i><span class="ms-2">Family Members</span>
                                    </button>
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-experiences"
                                        type="button">
                                        <i class="ti ti-briefcase pe-2"></i><span class="ms-2">Experiences</span>
                                    </button>
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-official"
                                        type="button">
                                        <i class="ti ti-id-badge pe-2"></i><span class="ms-2">Official Details</span>
                                    </button>
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-payroll"
                                        type="button">
                                        <i class="ti ti-cash-banknote pe-2"></i><span class="ms-2">Payroll Info</span>
                                    </button>
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-banks"
                                        type="button">
                                        <i class="ti ti-building-bank pe-2"></i><span class="ms-2">Bank Details</span>
                                    </button>
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-enclosures"
                                        type="button">
                                        <i class="ti ti-file-text pe-2"></i><span class="ms-2">Enclosures</span>
                                    </button>
                                </div>
                            </div>

                            <!-- Wizard Content -->
                            <div class="col-xl-9">
                                <div class="tab-content" id="employeeWizardContent">
                                    <div class="tab-pane fade show active" id="tab-personal">
                                        <!-- Employee Profile Header -->
                                        <div class="employee-profile-header">
                                            <div class="profile-image-container">
                                                @if (!empty($employee->photo))
                                                    <img src="{{ asset('storage/' . $employee->photo) }}" class="profile-image" alt="Employee Photo">
                                                @else
                                                    <img src="http://security-software.test/assets/images/avtar/woman.jpg" class="profile-image" alt="User Avatar">
                                                @endif
                                                <span class="status-badge {{ $employee->status == 'active' ? 'status-active' : 'status-inactive' }}"></span>
                                                <div>
                                                    @if($employee->status == 'active')
                                                    <button class="btn btn-success btn-sm w-100">Active</button>
                                                    @else
                                                    <button class="btn btn-danger btn-sm w-100">Inactive</button>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="employee-basic-info">
                                                <h3>{{ $employee->first_name }} {{ $employee->last_name }}</h3>
                                                <div class="employee-id">ID: EMP-{{ str_pad($employee->id, 4, '0', STR_PAD_LEFT) }}</div>
                                                <div class="employee-position">{{ optional($employee->officialDetail)->role ?? 'Not specified' }}</div>
                                                <div class="employee-department">{{ optional($employee->officialDetail)->employee_type ?? 'Not specified' }}</div>
                                            </div>
                                        </div>

                                        <div class="row g-3">
                                            @foreach ([
                                                'First Name' => $employee->first_name,
                                                'Last Name' => $employee->last_name,
                                                'Father Name' => $employee->father_name,
                                                'DOB' => $employee->dob?->format('d-m-Y') ?? '-',
                                                'Gender' => $employee->gender,
                                                'Age' => $employee->age,
                                                'Mobile' => $employee->mobile,
                                                'Alt Mobile' => $employee->alt_mobile,
                                                'Phone' => $employee->phone,
                                                'Nationality' => $employee->nationality,
                                                'Religion' => $employee->religion,
                                                'Caste' => $employee->caste,
                                                'Sub Caste' => $employee->sub_caste,
                                                'Identification Marks' => $employee->identification_marks,
                                                'Remarks' => $employee->remarks,
                                                'Recommended By' => $employee->recommended_by,
                                                'Recommended Address' => $employee->recommended_address,
                                                'Education' => $employee->education_qualification,
                                                'Marital Status' => $employee->marital_status,
                                                'Blood Group' => $employee->blood_group,
                                            ] as $label => $value)
                                                <div class="col-md-6">
                                                    <div class="detail-card">
                                                        <div class="label">{{ $label }}</div>
                                                        <div class="value">{{ $value ?? '-' }}</div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="tab-address">
                                        <h5 class="section-title">Address Information</h5>
                                        @forelse($employee->addresses as $addr)
                                            <div class="detail-card mb-3">
                                                <div class="row">
                                                    <div class="col-md-6 mb-2">
                                                        <div class="label">Type</div>
                                                        <div class="value">{{ ucfirst($addr->type ?? '-') }}</div>
                                                    </div>
                                                    <div class="col-md-12 mb-2">
                                                        <div class="label">Address</div>
                                                        <div class="value">
                                                            {{ $addr->address_line1 ?? '-' }}
                                                            @if($addr->address_line2)
                                                                , {{ $addr->address_line2 }}
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 mb-2">
                                                        <div class="label">City</div>
                                                        <div class="value">{{ $addr->city ?? '-' }}</div>
                                                    </div>
                                                    <div class="col-md-4 mb-2">
                                                        <div class="label">State</div>
                                                        <div class="value">{{ $addr->state ?? '-' }}</div>
                                                    </div>
                                                    <div class="col-md-4 mb-2">
                                                        <div class="label">Pincode</div>
                                                        <div class="value">{{ $addr->pincode ?? '-' }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="detail-card">
                                                <div class="value text-center text-muted py-3">No addresses available</div>
                                            </div>
                                        @endforelse
                                    </div>

                                    <div class="tab-pane fade" id="tab-languages">
                                        <h5 class="section-title">Language Proficiency</h5>
                                        @forelse($employee->languages as $lang)
                                            <div class="detail-card mb-3">
                                                <div class="row">
                                                    <div class="col-md-3 mb-2">
                                                        <div class="label">Language</div>
                                                        <div class="value">{{ $lang['language'] ?? '-' }}</div>
                                                    </div>
                                                    <div class="col-md-3 mb-2">
                                                        <div class="label">Read</div>
                                                        <div class="value">{{ !empty($lang['read']) ? 'Yes' : 'No' }}</div>
                                                    </div>
                                                    <div class="col-md-3 mb-2">
                                                        <div class="label">Write</div>
                                                        <div class="value">{{ !empty($lang['write']) ? 'Yes' : 'No' }}</div>
                                                    </div>
                                                    <div class="col-md-3 mb-2">
                                                        <div class="label">Speak</div>
                                                        <div class="value">{{ !empty($lang['speak']) ? 'Yes' : 'No' }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="detail-card">
                                                <div class="value text-center text-muted py-3">No languages available</div>
                                            </div>
                                        @endforelse
                                    </div>

                                    <div class="tab-pane fade" id="tab-family">
                                        <h5 class="section-title">Family Members</h5>
                                        @forelse($employee->familyMembers as $member)
                                            <div class="detail-card mb-3">
                                                <div class="row">
                                                    <div class="col-md-4 mb-2">
                                                        <div class="label">Name</div>
                                                        <div class="value">{{ $member->name ?? '-' }}</div>
                                                    </div>
                                                    <div class="col-md-4 mb-2">
                                                        <div class="label">Date of Birth</div>
                                                        <div class="value">{{ $member->dob ? \Carbon\Carbon::parse($member->dob)->format('d-m-Y') : '-' }}</div>
                                                    </div>
                                                    <div class="col-md-4 mb-2">
                                                        <div class="label">Age</div>
                                                        <div class="value">{{ $member->age ?? '-' }}</div>
                                                    </div>
                                                    <div class="col-md-4 mb-2">
                                                        <div class="label">Relationship</div>
                                                        <div class="value">{{ $member->relationship ?? '-' }}</div>
                                                    </div>
                                                    <div class="col-md-4 mb-2">
                                                        <div class="label">Mobile Number</div>
                                                        <div class="value">{{ $member->mobile_number ?? '-' }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="detail-card">
                                                <div class="value text-center text-muted py-3">No family members available</div>
                                            </div>
                                        @endforelse
                                    </div>

                                    <div class="tab-pane fade" id="tab-experiences">
                                        <h5 class="section-title">Work Experience</h5>
                                        @forelse($employee->experiences as $exp)
                                            <div class="detail-card mb-3">
                                                <div class="row">
                                                    <div class="col-md-4 mb-2">
                                                        <div class="label">Company</div>
                                                        <div class="value">{{ $exp->company_name ?? '-' }}</div>
                                                    </div>
                                                    <div class="col-md-4 mb-2">
                                                        <div class="label">Designation</div>
                                                        <div class="value">{{ $exp->designation ?? '-' }}</div>
                                                    </div>
                                                    <div class="col-md-4 mb-2">
                                                        <div class="label">Experience</div>
                                                        <div class="value">{{ $exp->experience ?? '-' }} years</div>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="detail-card">
                                                <div class="value text-center text-muted py-3">No experiences available</div>
                                            </div>
                                        @endforelse
                                    </div>

                                    <div class="tab-pane fade" id="tab-official">
                                        <h5 class="section-title">Official Details</h5>
                                        <div class="row g-2">
                                            @foreach ([
                                                'Role' => optional($employee->officialDetail)->role,
                                                'Date of Join' => optional($employee->officialDetail?->date_of_join)?->format('d-m-Y'),
                                                'Employee Type' => optional($employee->officialDetail)->employee_type,
                                                'Salary' => optional($employee->officialDetail)->salary ? number_format($employee->officialDetail->salary, 2) : '-',
                                                'PF Number' => optional($employee->officialDetail)->pf_number,
                                                'ESI Number' => optional($employee->officialDetail)->esi_number,
                                                'PF Calculation' => isset($employee->officialDetail->pf_calculation) ? ($employee->officialDetail->pf_calculation ? 'Yes' : 'No') : '-',
                                                'ESI Calculation' => isset($employee->officialDetail->esi_calculation) ? ($employee->officialDetail->esi_calculation ? 'Yes' : 'No') : '-',
                                            ] as $label => $value)
                                                <div class="col-md-6 mb-2">
                                                    <div class="detail-card">
                                                        <div class="label">{{ $label }}</div>
                                                        <div class="value">{{ $value ?? '-' }}</div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="tab-payroll">
                                        <h5 class="section-title">Payroll Information</h5>
                                        <div class="row g-2">
                                            @foreach ([
                                                'Basic %' => optional($payslip)->basic,
                                                'Allowance1 %' => optional($payslip)->allowance1,
                                                'HRA %' => optional($payslip)->hra,
                                                'Allowance2 %' => optional($payslip)->allowance2,
                                                'DA %' => optional($payslip)->da,
                                                'Gratuity %' => optional($payslip)->gratuity,
                                                'Travel Allowance %' => optional($payslip)->travel_allowance,
                                                'Bonus %' => optional($payslip)->bonus,
                                                'Leave Allowance %' => optional($payslip)->leave_allowance,
                                                'Other Allowance %' => optional($payslip)->other_allowance,
                                            ] as $label => $value)
                                                <div class="col-md-6 mb-2">
                                                    <div class="detail-card">
                                                        <div class="label">{{ $label }}</div>
                                                        <div class="value">{{ $value !== null ? $value : '-' }}</div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="tab-banks">
                                        <h5 class="section-title">Bank Account Details</h5>
                                        @forelse($employee->bankDetails as $bank)
                                            <div class="detail-card mb-3">
                                                <div class="row">
                                                    <div class="col-md-6 mb-2">
                                                        <div class="label">Account Holder</div>
                                                        <div class="value">{{ $bank->account_holder_name ?? '-' }}</div>
                                                    </div>
                                                    <div class="col-md-6 mb-2">
                                                        <div class="label">Bank Name</div>
                                                        <div class="value">{{ $bank->bank_name ?? '-' }}</div>
                                                    </div>
                                                    <div class="col-md-6 mb-2">
                                                        <div class="label">Account No</div>
                                                        <div class="value">{{ $bank->account_no ?? '-' }}</div>
                                                    </div>
                                                    <div class="col-md-6 mb-2">
                                                        <div class="label">IFSC Code</div>
                                                        <div class="value">{{ $bank->ifsc_code ?? '-' }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="detail-card">
                                                <div class="value text-center text-muted py-3">No bank details available</div>
                                            </div>
                                        @endforelse
                                    </div>

                                    <div class="tab-pane fade" id="tab-enclosures">
                                        <h5 class="section-title">Document Enclosures</h5>
                                        @forelse($employee->enclosures as $doc)
                                            <div class="detail-card mb-3">
                                                <div class="row">
                                                    <div class="col-md-4 mb-2">
                                                        <div class="label">Document Type</div>
                                                        <div class="value">{{ $doc->document_type }}</div>
                                                    </div>
                                                    <div class="col-md-4 mb-2">
                                                        <div class="label">Copy Type</div>
                                                        <div class="value">{{ $doc->original_copy }}</div>
                                                    </div>
                                                    <div class="col-md-4 mb-2">
                                                        <div class="label">Proof Number</div>
                                                        <div class="value">{{ $doc->proof_no }}</div>
                                                    </div>
                                                    <div class="col-md-12 mb-2">
                                                        <div class="label">File</div>
                                                        <div class="value">
                                                            @if ($doc->file_path)
                                                                <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                                    <i class="ti ti-download me-1"></i> View Document
                                                                </a>
                                                            @else
                                                                -
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="detail-card">
                                                <div class="value text-center text-muted py-3">No documents available</div>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div> <!-- row -->
                    </div> <!-- wizard -->
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
