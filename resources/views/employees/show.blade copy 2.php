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
    </style>
    <div class="row m-1">
        <div class="col-12">
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
    </div>

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
                                                        <label class="fw-bold">{{ $label }}</label>
                                                        <p class="mb-1">{{ $value ?? '-' }}</p>
                                                    </div>
                                                @endforeach

                                                <!-- Photo -->
                                                <div class="col-md-6">
                                                    <label class="fw-bold">Photo</label><br>
                                                    @if (!empty($employee->photo))
                                                        <img src="{{ asset('storage/' . $employee->photo) }}"
                                                            class="img-fluid rounded shadow-sm" style="max-width:150px;">
                                                    @else
                                                        <span class="text-muted">No Photo</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="tab-address">
                                            @forelse($employee->addresses as $addr)
                                                <div class="card mb-2 shadow-sm">
                                                    <div class="card-body">
                                                        <p class="mb-1"><strong>Type:</strong>
                                                            {{ ucfirst($addr->type ?? '-') }}</p>
                                                        <p class="mb-1"><strong>Address:</strong>
                                                            {{ $addr->address_line1 ?? '-' }}
                                                            {{ $addr->address_line2 ?? '' }}</p>
                                                        <p class="mb-1"><strong>City:</strong> {{ $addr->city ?? '-' }}
                                                        </p>
                                                        <p class="mb-1"><strong>State:</strong> {{ $addr->state ?? '-' }}
                                                        </p>
                                                        <p class="mb-1"><strong>Pincode:</strong>
                                                            {{ $addr->pincode ?? '-' }}</p>
                                                    </div>
                                                </div>
                                            @empty
                                                <p class="text-muted">No addresses available</p>
                                            @endforelse
                                        </div>
                                        <div class="tab-pane fade" id="tab-languages">
                                            @forelse($employee->languages as $lang)
                                                <div class="card mb-2 shadow-sm">
                                                    <div class="card-body row">
                                                        <div class="col-md-3"><strong>Language:</strong>
                                                            {{ $lang['language'] ?? '-' }}</div>
                                                        <div class="col-md-3"><strong>Read:</strong>
                                                            {{ !empty($lang['read']) ? 'Yes' : 'No' }}</div>
                                                        <div class="col-md-3"><strong>Write:</strong>
                                                            {{ !empty($lang['write']) ? 'Yes' : 'No' }}</div>
                                                        <div class="col-md-3"><strong>Speak:</strong>
                                                            {{ !empty($lang['speak']) ? 'Yes' : 'No' }}</div>
                                                    </div>
                                                </div>
                                            @empty
                                                <p class="text-muted">No languages available</p>
                                            @endforelse
                                        </div>
                                        <div class="tab-pane fade" id="tab-family">
                                            @forelse($employee->familyMembers as $member)
                                                <div class="card mb-2 shadow-sm">
                                                    <div class="card-body row">
                                                        <div class="col-md-4"><strong>Name:</strong>
                                                            {{ $member->name ?? '-' }}</div>
                                                        <div class="col-md-4"><strong>DOB:</strong>
                                                            {{ $member->dob ? \Carbon\Carbon::parse($member->dob)->format('d-m-Y') : '-' }}
                                                        </div>
                                                        <div class="col-md-4"><strong>Relationship:</strong>
                                                            {{ $member->relationship ?? '-' }}</div>
                                                    </div>
                                                </div>
                                            @empty
                                                <p class="text-muted">No family members available</p>
                                            @endforelse
                                        </div>
                                        <div class="tab-pane fade" id="tab-experiences">
                                            @forelse($employee->experiences as $exp)
                                                <div class="card mb-2 shadow-sm">
                                                    <div class="card-body row">
                                                        <div class="col-md-4"><strong>Company:</strong>
                                                            {{ $exp->company_name ?? '-' }}</div>
                                                        <div class="col-md-4"><strong>Designation:</strong>
                                                            {{ $exp->designation ?? '-' }}</div>
                                                        <div class="col-md-4"><strong>Years:</strong>
                                                            {{ $exp->experience ?? '-' }}</div>
                                                    </div>
                                                </div>
                                            @empty
                                                <p class="text-muted">No experiences available</p>
                                            @endforelse
                                        </div>
                                        <div class="tab-pane fade" id="tab-official">
                                            <div class="row g-2">
                                                @foreach ([
            'Role' => optional($employee->officialDetail)->role,
            'Date of Join' => optional($employee->officialDetail->date_of_join)?->format('d-m-Y'),
            'Employee Type' => optional($employee->officialDetail)->employee_type,
            'Salary' => optional($employee->officialDetail)->salary ? number_format($employee->officialDetail->salary, 2) : '-',
            'PF Number' => optional($employee->officialDetail)->pf_number,
            'ESI Number' => optional($employee->officialDetail)->esi_number,
            'PF Calculation' => isset($employee->officialDetail->pf_calculation) ? ($employee->officialDetail->pf_calculation ? 'Yes' : 'No') : '-',
            'ESI Calculation' => isset($employee->officialDetail->esi_calculation) ? ($employee->officialDetail->esi_calculation ? 'Yes' : 'No') : '-',
        ] as $label => $value)
                                                    <div class="col-md-6 mb-2">
                                                        <strong>{{ $label }}:</strong> {{ $value ?? '-' }}
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="tab-payroll">
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
            <strong>{{ $label }}:</strong> {{ $value !== null ? $value : '-' }}
        </div>
    @endforeach
</div>


                                        </div>
                                        <div class="tab-pane fade" id="tab-banks">
                                            @forelse($employee->bankDetails as $bank)
                                                <div class="card mb-2 shadow-sm">
                                                    <div class="card-body row">
                                                        <div class="col-md-6"><strong>Account Holder:</strong>
                                                            {{ $bank->account_holder_name ?? '-' }}</div>
                                                        <div class="col-md-6"><strong>Bank Name:</strong>
                                                            {{ $bank->bank_name ?? '-' }}</div>
                                                        <div class="col-md-6"><strong>Account No:</strong>
                                                            {{ $bank->account_no ?? '-' }}</div>
                                                        <div class="col-md-6"><strong>IFSC:</strong>
                                                            {{ $bank->ifsc_code ?? '-' }}</div>
                                                    </div>
                                                </div>
                                            @empty
                                                <p class="text-muted">No bank details available</p>
                                            @endforelse
                                        </div>
                                        <div class="tab-pane fade" id="tab-enclosures">
                                            @forelse($employee->enclosures as $doc)
                                                <div class="card mb-2 shadow-sm">
                                                    <div class="card-body">
                                                        <p><strong>Type:</strong> {{ $doc->document_type }}</p>
                                                        <p><strong>Copy:</strong> {{ $doc->original_copy }}</p>
                                                        <p><strong>Proof No:</strong> {{ $doc->proof_no }}</p>
                                                        <p><strong>File:</strong>
                                                            @if ($doc->file_path)
                                                                <a href="{{ asset('storage/' . $doc->file_path) }}"
                                                                    target="_blank">View File</a>
                                                            @else
                                                                -
                                                            @endif
                                                        </p>
                                                    </div>
                                                </div>
                                            @empty
                                                <p class="text-muted">No documents available</p>
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
