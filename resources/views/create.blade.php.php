@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>Create New Employee</h3>
                </div>
                <div class="card-body">
                    <form id="employeeForm" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <!-- Left side tabs -->
                            <div class="col-md-3">
                                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                    <a class="nav-link active" id="personal-tab" data-toggle="pill" href="#personal" role="tab">Personal Info</a>
                                    <a class="nav-link" id="address-tab" data-toggle="pill" href="#address" role="tab">Address Info</a>
                                    <a class="nav-link" id="languages-tab" data-toggle="pill" href="#languages" role="tab">Languages Info</a>
                                    <a class="nav-link" id="family-tab" data-toggle="pill" href="#family" role="tab">Family Members</a>
                                    <a class="nav-link" id="experiences-tab" data-toggle="pill" href="#experiences" role="tab">Experiences Info</a>
                                    <a class="nav-link" id="official-tab" data-toggle="pill" href="#official" role="tab">Official Details</a>
                                    <a class="nav-link" id="payroll-tab" data-toggle="pill" href="#payroll" role="tab">Payroll Info</a>
                                    <a class="nav-link" id="bank-tab" data-toggle="pill" href="#bank" role="tab">Bank Details</a>
                                    <a class="nav-link" id="enclosures-tab" data-toggle="pill" href="#enclosures" role="tab">Enclosures</a>
                                </div>
                            </div>

                            <!-- Right side content -->
                            <div class="col-md-9">
                                <div class="tab-content" id="v-pills-tabContent">
                                    <!-- Personal Info Tab -->
                                    <div class="tab-pane fade show active" id="personal" role="tabpanel">
                                        @include('employees.tabs.personal')
                                    </div>

                                    <!-- Address Info Tab -->
                                    <div class="tab-pane fade" id="address" role="tabpanel">
                                        @include('employees.tabs.address')
                                    </div>

                                    <!-- Languages Info Tab -->
                                    <div class="tab-pane fade" id="languages" role="tabpanel">
                                        @include('employees.tabs.languages')
                                    </div>

                                    <!-- Family Members Tab -->
                                    <div class="tab-pane fade" id="family" role="tabpanel">
                                        @include('employees.tabs.family')
                                    </div>

                                    <!-- Experiences Info Tab -->
                                    <div class="tab-pane fade" id="experiences" role="tabpanel">
                                        @include('employees.tabs.experiences')
                                    </div>

                                    <!-- Official Details Tab -->
                                    <div class="tab-pane fade" id="official" role="tabpanel">
                                        @include('employees.tabs.official')
                                    </div>

                                    <!-- Payroll Info Tab -->
                                    <div class="tab-pane fade" id="payroll" role="tabpanel">
                                        @include('employees.tabs.payroll')
                                    </div>

                                    <!-- Bank Details Tab -->
                                    <div class="tab-pane fade" id="bank" role="tabpanel">
                                        @include('employees.tabs.bank')
                                    </div>

                                    <!-- Enclosures Tab -->
                                    <div class="tab-pane fade" id="enclosures" role="tabpanel">
                                        @include('employees.tabs.enclosures')
                                    </div>
                                </div>

                                <div class="form-group mt-3">
                                    <button type="submit" class="btn btn-primary">Save Employee</button>
                                    <button type="reset" class="btn btn-secondary">Reset</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Handle form submission with AJAX
    $('#employeeForm').on('submit', function(e) {
        e.preventDefault();

        var formData = new FormData(this);

        $.ajax({
            url: "{{ route('employees.store') }}",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    alert('Employee created successfully!');
                    window.location.href = "{{ route('employees.index') }}";
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function(xhr) {
                var errors = xhr.responseJSON.errors;
                var errorMsg = '';

                $.each(errors, function(key, value) {
                    errorMsg += value + '\n';
                });

                alert('Validation errors:\n' + errorMsg);
            }
        });
    });

    // Copy permanent address to present address
    $('#sameAsPermanent').change(function() {
        if ($(this).is(':checked')) {
            $('#present_address_line1').val($('#permanent_address_line1').val());
            $('#present_address_line2').val($('#permanent_address_line2').val());
            $('#present_city').val($('#permanent_city').val());
            $('#present_state').val($('#permanent_state').val());
            $('#present_pincode').val($('#permanent_pincode').val());
        } else {
            $('#present_address_line1').val('');
            $('#present_address_line2').val('');
            $('#present_city').val('');
            $('#present_state').val('');
            $('#present_pincode').val('');
        }
    });
});
</script>
@endpush
