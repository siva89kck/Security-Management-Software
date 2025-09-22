@extends('layouts.master')

@section('content')
<style>
/* Tabs Left Side Fix */
.form-wizard .navstpes .nav-link {
    padding: 10px 12px;        /* Increased padding for proper spacing */
    font-size: 14px;
    display: flex;
    align-items: center;
    border-radius: 8px;
    margin-bottom: 6px;
    transition: all 0.3s;
}
.form-wizard .navstpes .nav-link i {
    font-size: 16px;
    width: 24px;               /* Proper width for icon */
    min-width: 24px;
    text-align: center;
}
.form-wizard .navstpes .nav-link span {
    margin-left: 8px;
}

/* Right Side Profile Section */
.employee-profile-header {
    display: flex;
    align-items: center;
    margin-bottom: 1.5rem;
    padding-bottom: 1.5rem;
    border-bottom: 1px solid #e9ecef;
    background: #fdfdfd;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    padding: 15px;
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
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
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
.status-active { background-color: #28a745; }
.status-inactive { background-color: #6c757d; }

.employee-basic-info h3 {
    margin-bottom: 0.25rem;
    font-weight: 600;
    color: #2c3e50;
}
.employee-id { color: #6c757d; font-size: 0.9rem; margin-bottom: 0.25rem; }
.employee-position { color: #4a6cf7; font-weight: 500; margin-bottom: 0.25rem; }
.employee-department { color: #6c757d; font-size: 0.9rem; }

</style>

<div class="row m-1">
  <div class="col-12 d-flex justify-content-between align-items-center">
    <div>
      <h4 class="main-title">Employees List</h4>
      <ul class="app-line-breadcrumbs mb-3">
        <li><a href="{{ route('dashboard') }}"><i class="ph-duotone ph-newspaper f-s-16"></i> Dashboard</a></li>
        <li><a href="{{ route('employees.index') }}">List Employee</a></li>
        <li class="active">View Employee</li>
      </ul>
    </div>
    <div>
      <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-success"><i class="ti ti-edit"></i> Edit</a>
      <button class="btn btn-primary" onclick="printEmployeeInfo()"><i class="ti ti-printer"></i> Print</button>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-12">
    <div class="card shadow-sm">
      <div class="card-body">
        <div class="form-wizard">
          <div class="row">
            <!-- Tabs -->
            <div class="col-xl-3 mb-3">
              <div class="nav navstpes flex-column" id="employeeWizard" role="tablist">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab-personal" type="button"><i class="ti ti-user-circle"></i> Personal Info</button>
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-official" type="button"><i class="ti ti-id-badge"></i> Official Details</button>
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-address" type="button"><i class="ti ti-home"></i> Address</button>
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-languages" type="button"><i class="ti ti-language"></i> Languages</button>
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-family" type="button"><i class="ti ti-users"></i> Family</button>
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-experiences" type="button"><i class="ti ti-briefcase"></i> Experiences</button>
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-payroll" type="button"><i class="ti ti-cash-banknote"></i> Payroll</button>
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-banks" type="button"><i class="ti ti-building-bank"></i> Banks</button>
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-enclosures" type="button"><i class="ti ti-file-text"></i> Enclosures</button>
              </div>
            </div>

            <!-- Tab Content -->
            <div class="col-xl-9">
              <div class="tab-content" id="employeeWizardContent">

                @php $tabs = [
                  'personal' => 'Personal Info',
                  'official' => 'Official Details',
                  'address' => 'Addresses',
                  'languages' => 'Languages',
                  'family' => 'Family Members',
                  'experiences' => 'Work Experience',
                  'payroll' => 'Payroll Info',
                  'banks' => 'Bank Accounts',
                  'enclosures' => 'Documents'
                ]; @endphp

                <!-- Personal Info -->
                <div class="tab-pane fade show active" id="tab-personal">
                  <div class="employee-profile-header">
                    <div class="profile-image-container">
                      @if($employee->photo)
                        <img src="{{ asset('storage/'.$employee->photo) }}" class="profile-image" alt="Photo">
                      @else
                        <img src="http://security-software.test/assets/images/avtar/woman.jpg" class="profile-image" alt="Avatar">
                      @endif
                      <span class="status-badge {{ $employee->status=='active'?'status-active':'status-inactive' }}"></span>
                    </div>
                    <div class="employee-basic-info">
                      <h3>{{ $employee->first_name }} {{ $employee->last_name }}</h3>
                      <div class="employee-id">ID: EMP-{{ str_pad($employee->id, 4,'0',STR_PAD_LEFT) }}</div>
                      <div>{{ optional($employee->officialDetail)->role ?? '-' }}</div>
                      <div>{{ optional($employee->officialDetail)->employee_type ?? '-' }}</div>
                    </div>
                  </div>
                  <div class="row g-3">
                    @foreach([
                      'First Name'=>$employee->first_name,
                      'Last Name'=>$employee->last_name,
                      'Father Name'=>$employee->father_name,
                      'DOB'=>$employee->dob?->format('d-m-Y')??'-',
                      'Gender'=>$employee->gender,
                      'Age'=>$employee->age,
                      'Mobile'=>$employee->mobile,
                      'Alt Mobile'=>$employee->alt_mobile,
                      'Phone'=>$employee->phone,
                      'Nationality'=>$employee->nationality,
                      'Religion'=>$employee->religion,
                      'Caste'=>$employee->caste,
                      'Sub Caste'=>$employee->sub_caste,
                      'Identification Marks'=>$employee->identification_marks,
                      'Remarks'=>$employee->remarks,
                      'Recommended By'=>$employee->recommended_by,
                      'Recommended Address'=>$employee->recommended_address,
                      'Education'=>$employee->education_qualification,
                      'Marital Status'=>$employee->marital_status,
                      'Blood Group'=>$employee->blood_group
                    ] as $label=>$value)
                      <div class="col-md-6">
                        <div class="detail-card">
                          <div class="label">{{ $label }}</div>
                          <div class="value">{{ $value ?? '-' }}</div>
                        </div>
                      </div>
                    @endforeach
                  </div>
                </div>

                <!-- Official Details -->
                <div class="tab-pane fade" id="tab-official">
                  <h5 class="section-title">Official Details</h5>
                  <div class="row g-2">
                    @foreach([
                      'Role'=>optional($employee->officialDetail)->role,
                      'Date of Join'=>optional($employee->officialDetail?->date_of_join)?->format('d-m-Y'),
                      'Employee Type'=>optional($employee->officialDetail)->employee_type,
                      'Salary'=>optional($employee->officialDetail)->salary?number_format($employee->officialDetail->salary,2):'-',
                      'PF Number'=>optional($employee->officialDetail)->pf_number,
                      'ESI Number'=>optional($employee->officialDetail)->esi_number
                    ] as $label=>$value)
                      <div class="col-md-6">
                        <div class="detail-card">
                          <div class="label">{{ $label }}</div>
                          <div class="value">{{ $value ?? '-' }}</div>
                        </div>
                      </div>
                    @endforeach
                  </div>
                </div>

                <!-- Address -->
                <div class="tab-pane fade" id="tab-address">
                  <h5 class="section-title">Addresses</h5>
                  @forelse($employee->addresses as $addr)
                    <div class="detail-card mb-3">
                      <div class="row">
                        <div class="col-md-6"><div class="label">Type</div><div class="value">{{ ucfirst($addr->type ?? '-') }}</div></div>
                        <div class="col-md-12"><div class="label">Address</div><div class="value">{{ $addr->address_line1 ?? '-' }}{{ $addr->address_line2?', '.$addr->address_line2:'' }}</div></div>
                        <div class="col-md-4"><div class="label">City</div><div class="value">{{ $addr->city ?? '-' }}</div></div>
                        <div class="col-md-4"><div class="label">State</div><div class="value">{{ $addr->state ?? '-' }}</div></div>
                        <div class="col-md-4"><div class="label">Pincode</div><div class="value">{{ $addr->pincode ?? '-' }}</div></div>
                      </div>
                    </div>
                  @empty
                    <div class="detail-card">No addresses available</div>
                  @endforelse
                </div>

                <!-- Languages -->
                <div class="tab-pane fade" id="tab-languages">
                  <h5 class="section-title">Languages</h5>
                  @forelse($employee->languages as $lang)
                    <div class="detail-card mb-3">
                      <div class="row">
                        <div class="col-md-3"><div class="label">Language</div><div class="value">{{ $lang['language']??'-' }}</div></div>
                        <div class="col-md-3"><div class="label">Read</div><div class="value">{{ !empty($lang['read'])?'Yes':'No' }}</div></div>
                        <div class="col-md-3"><div class="label">Write</div><div class="value">{{ !empty($lang['write'])?'Yes':'No' }}</div></div>
                        <div class="col-md-3"><div class="label">Speak</div><div class="value">{{ !empty($lang['speak'])?'Yes':'No' }}</div></div>
                      </div>
                    </div>
                  @empty
                    <div class="detail-card">No languages available</div>
                  @endforelse
                </div>

                <!-- Family -->
                <div class="tab-pane fade" id="tab-family">
                  <h5 class="section-title">Family Members</h5>
                  @forelse($employee->familyMembers as $member)
                    <div class="detail-card mb-3">
                      <div class="row">
                        <div class="col-md-4"><div class="label">Name</div><div class="value">{{ $member->name??'-' }}</div></div>
                        <div class="col-md-4"><div class="label">Age</div><div class="value">{{ $member->age??'-' }}</div></div>
                        <div class="col-md-4"><div class="label">Relationship</div><div class="value">{{ $member->relationship??'-' }}</div></div>
                        <div class="col-md-4"><div class="label">Mobile</div><div class="value">{{ $member->mobile_number??'-' }}</div></div>
                      </div>
                    </div>
                  @empty
                    <div class="detail-card">No family members available</div>
                  @endforelse
                </div>

                <!-- Experiences -->
                <div class="tab-pane fade" id="tab-experiences">
                  <h5 class="section-title">Work Experience</h5>
                  @forelse($employee->experiences as $exp)
                    <div class="detail-card mb-3">
                      <div class="row">
                        <div class="col-md-4"><div class="label">Company</div><div class="value">{{ $exp->company_name??'-' }}</div></div>
                        <div class="col-md-4"><div class="label">Designation</div><div class="value">{{ $exp->designation??'-' }}</div></div>
                        <div class="col-md-4"><div class="label">Experience</div><div class="value">{{ $exp->experience??'-' }} years</div></div>
                      </div>
                    </div>
                  @empty
                    <div class="detail-card">No experiences available</div>
                  @endforelse
                </div>

                <!-- Payroll -->
                <div class="tab-pane fade" id="tab-payroll">
                  <h5 class="section-title">Payroll Info</h5>
                  @php $payslip = $employee->payslipConfig; @endphp
                  <div class="row g-2">
                    @foreach([
                      'Basic %'=>$payslip?->basic,
                      'Allowance1 %'=>$payslip?->allowance1,
                      'HRA %'=>$payslip?->hra,
                      'Allowance2 %'=>$payslip?->allowance2,
                      'DA %'=>$payslip?->da,
                      'Gratuity %'=>$payslip?->gratuity,
                      'Travel Allowance %'=>$payslip?->travel_allowance,
                      'Bonus %'=>$payslip?->bonus,
                      'Leave Allowance %'=>$payslip?->leave_allowance,
                      'Other Allowance %'=>$payslip?->other_allowance
                    ] as $label=>$value)
                      <div class="col-md-6"><div class="detail-card"><div class="label">{{ $label }}</div><div class="value">{{ $value??'-' }}</div></div></div>
                    @endforeach
                  </div>
                </div>

                <!-- Banks -->
                <div class="tab-pane fade" id="tab-banks">
                  <h5 class="section-title">Bank Accounts</h5>
                  @forelse($employee->bankDetails as $bank)
                    <div class="detail-card mb-3">
                      <div class="row">
                        <div class="col-md-6"><div class="label">Holder</div><div class="value">{{ $bank->account_holder_name??'-' }}</div></div>
                        <div class="col-md-6"><div class="label">Bank</div><div class="value">{{ $bank->bank_name??'-' }}</div></div>
                        <div class="col-md-6"><div class="label">Account No</div><div class="value">{{ $bank->account_no??'-' }}</div></div>
                        <div class="col-md-6"><div class="label">IFSC</div><div class="value">{{ $bank->ifsc_code??'-' }}</div></div>
                      </div>
                    </div>
                  @empty
                    <div class="detail-card">No bank details available</div>
                  @endforelse
                </div>

                <!-- Enclosures -->
                <div class="tab-pane fade" id="tab-enclosures">
                  <h5 class="section-title">Documents</h5>
                  @forelse($employee->enclosures as $doc)
                    <div class="detail-card mb-3">
                      <div class="row">
                        <div class="col-md-4"><div class="label">Doc Type</div><div class="value">{{ $doc->document_type }}</div></div>
                        <div class="col-md-4"><div class="label">Copy Type</div><div class="value">{{ $doc->original_copy }}</div></div>
                        <div class="col-md-4"><div class="label">Proof No</div><div class="value">{{ $doc->proof_no }}</div></div>
                        <div class="col-md-12"><div class="label">Remarks</div><div class="value">{{ $doc->remarks }}</div></div>
                      </div>
                    </div>
                  @empty
                    <div class="detail-card">No documents available</div>
                  @endforelse
                </div>

              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
function printEmployeeInfo() {
    var allTabs = document.querySelectorAll('.tab-pane');
    var combinedContent = '';

    allTabs.forEach(function(tab){
        combinedContent += '<h3>' + (tab.querySelector('.section-title') ? tab.querySelector('.section-title').innerText : '') + '</h3>';
        combinedContent += tab.innerHTML;
        combinedContent += '<hr style="margin:20px 0; border-top:1px dashed #ccc;">';
    });

    var a = window.open('', '', 'height=900, width=1000');
    a.document.write('<html><head><title>Employee Full Info</title>');
    a.document.write('<style>body{font-family:Arial,sans-serif;padding:20px;} h3,h5{color:#2c3e50;} .detail-card{background:#f9fafd;border-radius:12px;padding:10px;margin-bottom:10px;box-shadow:0 2px 6px rgba(0,0,0,0.05);} .label{font-size:0.85rem;color:#6c757d;margin-bottom:0.25rem;} .value{font-weight:500;color:#2c3e50;margin-bottom:0;}</style>');
    a.document.write('</head><body>');
    a.document.write(combinedContent);
    a.document.write('</body></html>');
    a.document.close();
    a.print();
}
</script>

{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script> --}}
@endsection
