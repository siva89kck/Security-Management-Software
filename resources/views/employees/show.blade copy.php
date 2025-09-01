@extends('layouts.master')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <h4 class="mb-3">Employee Details</h4>
        </div>
    </div>

    <div class="row">
        <!-- Left Tabs -->
        <div class="col-md-3 mb-3">
            <div class="list-group" id="employee-tab" role="tablist">
                @php
                    $tabs = ['personal'=>'Personal', 'official'=>'Official', 'address'=>'Address', 'family'=>'Family', 'languages'=>'Languages', 'experience'=>'Experience', 'bank'=>'Bank', 'payslip'=>'Payslip', 'enclosures'=>'Documents'];
                @endphp
                @foreach($tabs as $id => $name)
                    <button class="list-group-item list-group-item-action @if($loop->first) active @endif" id="{{ $id }}-tab" data-bs-toggle="list" data-bs-target="#{{ $id }}" type="button" role="tab">
                        {{ $name }}
                    </button>
                @endforeach
            </div>
        </div>

        <!-- Tab Content -->
        <div class="col-md-9">
            <div class="tab-content border p-3 rounded shadow-sm" id="employee-tabContent">

                <!-- Personal -->
                <div class="tab-pane fade show active" id="personal" role="tabpanel">
                    <div class="row g-3">
                        @foreach([
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
                            'Blood Group' => $employee->blood_group
                        ] as $label => $value)
                            <div class="col-md-6">
                                <label class="fw-bold">{{ $label }}</label>
                                <p class="mb-1">{{ $value ?? '-' }}</p>
                            </div>
                        @endforeach

                        <!-- Photo -->
                        <div class="col-md-6">
                            <label class="fw-bold">Photo</label><br>
                            @if(!empty($employee->photo))
                                <img src="{{ asset('storage/'.$employee->photo) }}" class="img-fluid rounded shadow-sm" style="max-width:150px;">
                            @else
                                <span class="text-muted">No Photo</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Official -->
                <div class="tab-pane fade" id="official" role="tabpanel">
                    <div class="row g-2">
                        @foreach([
                            'Role' => optional($employee->officialDetail)->role,
                            'Date of Join' => optional($employee->officialDetail->date_of_join)?->format('d-m-Y'),
                            'Employee Type' => optional($employee->officialDetail)->employee_type,
                            'Salary' => optional($employee->officialDetail)->salary ? number_format($employee->officialDetail->salary,2) : '-',
                            'PF Number' => optional($employee->officialDetail)->pf_number,
                            'ESI Number' => optional($employee->officialDetail)->esi_number,
                            'PF Calculation' => isset($employee->officialDetail->pf_calculation) ? ($employee->officialDetail->pf_calculation ? 'Yes':'No') : '-',
                            'ESI Calculation' => isset($employee->officialDetail->esi_calculation) ? ($employee->officialDetail->esi_calculation ? 'Yes':'No') : '-',
                        ] as $label => $value)
                            <div class="col-md-6 mb-2">
                                <strong>{{ $label }}:</strong> {{ $value ?? '-' }}
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Address -->
                <div class="tab-pane fade" id="address" role="tabpanel">
                    @forelse($employee->addresses as $addr)
                        <div class="card mb-2 shadow-sm">
                            <div class="card-body">
                                <p class="mb-1"><strong>Type:</strong> {{ ucfirst($addr->type ?? '-') }}</p>
                                <p class="mb-1"><strong>Address:</strong> {{ $addr->address_line1 ?? '-' }} {{ $addr->address_line2 ?? '' }}</p>
                                <p class="mb-1"><strong>City:</strong> {{ $addr->city ?? '-' }}</p>
                                <p class="mb-1"><strong>State:</strong> {{ $addr->state ?? '-' }}</p>
                                <p class="mb-1"><strong>Pincode:</strong> {{ $addr->pincode ?? '-' }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted">No addresses available</p>
                    @endforelse
                </div>

                <!-- Family Members -->
                <div class="tab-pane fade" id="family" role="tabpanel">
                    @forelse($employee->familyMembers as $member)
                        <div class="card mb-2 shadow-sm">
                            <div class="card-body row">
                                <div class="col-md-4"><strong>Name:</strong> {{ $member->name ?? '-' }}</div>
                                <div class="col-md-4"><strong>DOB:</strong> {{ $member->dob ? \Carbon\Carbon::parse($member->dob)->format('d-m-Y') : '-' }}</div>
                                <div class="col-md-4"><strong>Relationship:</strong> {{ $member->relationship ?? '-' }}</div>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted">No family members available</p>
                    @endforelse
                </div>

                <!-- Languages -->
                <div class="tab-pane fade" id="languages" role="tabpanel">
                    @forelse($employee->languages as $lang)
                        <div class="card mb-2 shadow-sm">
                            <div class="card-body row">
                                <div class="col-md-3"><strong>Language:</strong> {{ $lang['language'] ?? '-' }}</div>
                                <div class="col-md-3"><strong>Read:</strong> {{ !empty($lang['read']) ? 'Yes':'No' }}</div>
                                <div class="col-md-3"><strong>Write:</strong> {{ !empty($lang['write']) ? 'Yes':'No' }}</div>
                                <div class="col-md-3"><strong>Speak:</strong> {{ !empty($lang['speak']) ? 'Yes':'No' }}</div>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted">No languages available</p>
                    @endforelse
                </div>

                <!-- Experience -->
                <div class="tab-pane fade" id="experience" role="tabpanel">
                    @forelse($employee->experiences as $exp)
                        <div class="card mb-2 shadow-sm">
                            <div class="card-body row">
                                <div class="col-md-4"><strong>Company:</strong> {{ $exp->company_name ?? '-' }}</div>
                                <div class="col-md-4"><strong>Designation:</strong> {{ $exp->designation ?? '-' }}</div>
                                <div class="col-md-4"><strong>Years:</strong> {{ $exp->experience ?? '-' }}</div>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted">No experiences available</p>
                    @endforelse
                </div>

                <!-- Bank -->
                <div class="tab-pane fade" id="bank" role="tabpanel">
                    @forelse($employee->bankDetails as $bank)
                        <div class="card mb-2 shadow-sm">
                            <div class="card-body row">
                                <div class="col-md-6"><strong>Account Holder:</strong> {{ $bank->account_holder_name ?? '-' }}</div>
                                <div class="col-md-6"><strong>Bank Name:</strong> {{ $bank->bank_name ?? '-' }}</div>
                                <div class="col-md-6"><strong>Account No:</strong> {{ $bank->account_no ?? '-' }}</div>
                                <div class="col-md-6"><strong>IFSC:</strong> {{ $bank->ifsc_code ?? '-' }}</div>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted">No bank details available</p>
                    @endforelse
                </div>

                <!-- Payslip -->
                <div class="tab-pane fade" id="payslip" role="tabpanel">
                    <ul class="list-group">
                        @foreach($employee->payslipConfig?->toArray() ?? [] as $key => $value)
                            <li class="list-group-item d-flex justify-content-between">
                                <span>{{ ucwords(str_replace('_',' ',$key)) }} (%)</span>
                                <span>{{ $value ?? '-' }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Documents -->
                <div class="tab-pane fade" id="enclosures" role="tabpanel">
                    @forelse($employee->enclosures as $doc)
                        <div class="card mb-2 shadow-sm">
                            <div class="card-body">
                                <p><strong>Type:</strong> {{ $doc->document_type }}</p>
                                <p><strong>Copy:</strong> {{ $doc->original_copy }}</p>
                                <p><strong>Proof No:</strong> {{ $doc->proof_no }}</p>
                                <p><strong>File:</strong>
                                    @if($doc->file)
                                        <a href="{{ asset('storage/'.$doc->file) }}" target="_blank">View File</a>
                                    @else - @endif
                                </p>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted">No documents available</p>
                    @endforelse
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
