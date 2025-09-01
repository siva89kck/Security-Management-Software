

</style>
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

    /* Icon and text between gap */
    .form-wizard .navstpes .nav-link span {
        margin-left: 6px; /* icon + text spacing */
    }
</style>

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

    <form action="{{ route('employees.store') }}" method="POST" enctype="multipart/form-data"
        class="app-form needs-validation" novalidate>
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="form-wizard">
                            <div class="row">
                                <!-- Wizard Tabs -->
                                <div class="col-xl-3 mb-3">
                                    <div class="nav navstpes flex-column" id="employeeWizard" role="tablist">
                                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab-personal" type="button">
                                            <i class="ti ti-user-circle pe-2"></i><span class="ms-2">Personal Info</span>
                                        </button>
                                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-official" type="button">
                                            <i class="ti ti-id-badge pe-2"></i><span class="ms-2">Official Details</span>
                                        </button>
                                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-address" type="button">
                                            <i class="ti ti-home pe-2"></i><span class="ms-2">Address Info</span>
                                        </button>
                                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-languages" type="button">
                                            <i class="ti ti-language pe-2"></i><span class="ms-2">Languages</span>
                                        </button>
                                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-family" type="button">
                                            <i class="ti ti-users pe-2"></i><span class="ms-2">Family Members</span>
                                        </button>
                                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-experiences" type="button">
                                            <i class="ti ti-briefcase pe-2"></i><span class="ms-2">Experiences</span>
                                        </button>
                                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-payroll" type="button">
                                            <i class="ti ti-cash-banknote pe-2"></i><span class="ms-2">Payroll Info</span>
                                        </button>
                                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-banks" type="button">
                                            <i class="ti ti-building-bank pe-2"></i><span class="ms-2">Bank Details</span>
                                        </button>
                                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-enclosures" type="button">
                                            <i class="ti ti-file-text pe-2"></i><span class="ms-2">Enclosures</span>
                                        </button>
                                    </div>
                                </div>

                                <!-- Wizard Content -->
                                <div class="col-xl-9">
                                    <div class="tab-content" id="employeeWizardContent">
                                        <div class="tab-pane fade show active" id="tab-personal">@include('employees.parts._personal')</div>
                                        <div class="tab-pane fade" id="tab-official">@include('employees.parts._official')</div>
                                        <div class="tab-pane fade" id="tab-address">@include('employees.parts._address')</div>
                                        <div class="tab-pane fade" id="tab-languages">@include('employees.parts._languages')</div>
                                        <div class="tab-pane fade" id="tab-family">@include('employees.parts._family')</div>
                                        <div class="tab-pane fade" id="tab-experiences">@include('employees.parts._experiences')</div>
                                        <div class="tab-pane fade" id="tab-payroll">@include('employees.parts._payroll')</div>
                                        <div class="tab-pane fade" id="tab-banks">@include('employees.parts._banks')</div>
                                        <div class="tab-pane fade" id="tab-enclosures">@include('employees.parts._enclosures')</div>
                                    </div>

                                    <div class="text-end mt-4">
                                        <button type="submit" class="btn btn-primary px-4">
                                            <i class="ti ti-device-floppy pe-1"></i> Submit
                                        </button>
                                        <a href="{{ route('employees.index') }}" class="btn btn-outline-secondary">Cancel</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
