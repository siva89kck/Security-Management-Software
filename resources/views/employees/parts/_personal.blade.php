<style>
.personal-card {
    background: #f9fafd;
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 20px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
}
.personal-card:hover {
    box-shadow: 0 4px 12px rgba(0,0,0,0.12);
}
.personal-card .form-control,
.personal-card .form-select {
    border-radius: 8px;
    transition: border-color 0.3s, box-shadow 0.3s;
}
.personal-card .form-control:focus,
.personal-card .form-select:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.25rem rgba(13,110,253,.25);
}
.personal-card h6 {
    margin-bottom: 15px;
}
.img-thumbnail {
    max-height: 80px;
}
</style>

<div class="personal-card">
    <h6>Personal Details</h6>
    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label">First Name <span class="text-danger">*</span></label>
            <input type="text" name="first_name" class="form-control"
                   value="{{ old('first_name', $employee->first_name ?? '') }}" required>
            <div class="invalid-feedback">Please enter first name.</div>
        </div>
        <div class="col-md-6">
            <label class="form-label">Last Name <span class="text-danger">*</span></label>
            <input type="text" name="last_name" class="form-control"
                   value="{{ old('last_name', $employee->last_name ?? '') }}" required>
            <div class="invalid-feedback">Please enter last name.</div>
        </div>
        <div class="col-md-6">
            <label class="form-label">Father Name <span class="text-danger">*</span></label>
            <input type="text" name="father_name" class="form-control"
                   value="{{ old('father_name', $employee->father_name ?? '') }}" required>
                   <div class="invalid-feedback">Please enter father name.</div>
        </div>
        <div class="col-md-3">
            <label class="form-label">DOB <span class="text-danger">*</span></label>
            <input type="date" name="dob" id="dob" class="form-control"
                   value="{{ old('dob', isset($employee->dob) ? $employee->dob->format('Y-m-d') : '') }}" required>
                   <div class="invalid-feedback">Please enter date of birth.</div>
        </div>
        <div class="col-md-3">
            <label class="form-label">Age <span class="text-danger">*</span></label>
            <input type="number" name="age" id="age" class="form-control" min="0" max="120"
                   value="{{ old('age', $employee->age ?? '') }}" readonly>
                   <div class="invalid-feedback">Please enter date of birth.</div>
        </div>
        <div class="col-md-6">
            <label class="form-label">Gender <span class="text-danger">*</span></label>
            <select name="gender" class="form-select" required>
                <option value="">Choose...</option>
                <option value="male" {{ old('gender', $employee->gender ?? '')=='male' ? 'selected' : '' }}>Male</option>
                <option value="female" {{ old('gender', $employee->gender ?? '')=='female' ? 'selected' : '' }}>Female</option>
                <option value="other" {{ old('gender', $employee->gender ?? '')=='other' ? 'selected' : '' }}>Other</option>
            </select>
            <div class="invalid-feedback">Please enter gender.</div>
        </div>
        <div class="col-md-6">
            <label class="form-label">Marital Status <span class="text-danger">*</span></label>
            <select name="marital_status" class="form-select" required>
                <option value="">Select...</option>
                <option value="Single" {{ old('marital_status', $employee->marital_status ?? '')=='Single' ? 'selected' : '' }}>Single</option>
                <option value="Married" {{ old('marital_status', $employee->marital_status ?? '')=='Married' ? 'selected' : '' }}>Married</option>
                <option value="Widow" {{ old('marital_status', $employee->marital_status ?? '')=='Widow' ? 'selected' : '' }}>Widow</option>
                <option value="Divorce" {{ old('marital_status', $employee->marital_status ?? '')=='Divorce' ? 'selected' : '' }}>Divorce</option>
            </select>
            <div class="invalid-feedback">Please select marital status.</div>
        </div>
        <div class="col-md-6">
            <label class="form-label">Mobile <span class="text-danger">*</span></label>
            <input type="text" name="mobile" class="form-control"
                   value="{{ old('mobile', $employee->mobile ?? '') }}" required>
                   <div class="invalid-feedback">Please enter mobile number.</div>
        </div>
        <div class="col-md-6">
            <label class="form-label">Alt Mobile</label>
            <input type="text" name="alt_mobile" class="form-control"
                   value="{{ old('alt_mobile', $employee->alt_mobile ?? '') }}">
        </div>
        <div class="col-md-6">
            <label class="form-label">Phone</label>
            <input type="text" name="phone" class="form-control"
                   value="{{ old('phone', $employee->phone ?? '') }}">
        </div>
        <div class="col-md-6">
            <label class="form-label">Nationality</label>
            <input type="text" name="nationality" class="form-control"
                   value="{{ old('nationality', $employee->nationality ?? 'Indian') }}">
        </div>
        <div class="col-md-6">
            <label class="form-label">Religion</label>
            <input type="text" name="religion" class="form-control"
                   value="{{ old('religion', $employee->religion ?? '') }}">
        </div>
        <div class="col-md-6">
            <label class="form-label">Caste</label>
            <input type="text" name="caste" class="form-control"
                   value="{{ old('caste', $employee->caste ?? '') }}">
        </div>
        <div class="col-md-6">
            <label class="form-label">Sub Caste</label>
            <input type="text" name="sub_caste" class="form-control"
                   value="{{ old('sub_caste', $employee->sub_caste ?? '') }}">
        </div>
        <div class="col-md-6">
            <label class="form-label">Identification Marks</label>
            <input type="text" name="identification_marks" class="form-control"
                   value="{{ old('identification_marks', $employee->identification_marks ?? '') }}">
        </div>
        <div class="col-md-6">
            <label class="form-label">Remarks</label>
            <input type="text" name="remarks" class="form-control"
                   value="{{ old('remarks', $employee->remarks ?? '') }}">
        </div>
        <div class="col-md-6">
            <label class="form-label">Recommended By</label>
            <input type="text" name="recommended_by" class="form-control"
                   value="{{ old('recommended_by', $employee->recommended_by ?? '') }}">
        </div>
        <div class="col-md-6">
            <label class="form-label">Recommended Address</label>
            <input type="text" name="recommended_address" class="form-control"
                   value="{{ old('recommended_address', $employee->recommended_address ?? '') }}">
        </div>
        <div class="col-md-6">
            <label class="form-label">Education</label>
            <input type="text" name="education_qualification" class="form-control"
                   value="{{ old('education_qualification', $employee->education_qualification ?? '') }}">
        </div>
        <div class="col-md-6">
            <label class="form-label">Blood Group</label>
            <input type="text" name="blood_group" class="form-control"
                   value="{{ old('blood_group', $employee->blood_group ?? '') }}">
        </div>
        <div class="col-md-6">
            <label class="form-label">Photo</label>
            <input type="file" name="photo" class="form-control">
            @if(!empty($employee->photo))
                <img src="{{ asset('storage/'.$employee->photo) }}" class="img-thumbnail mt-1">
            @endif
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Age calculation from DOB
    const dobInput = document.getElementById('dob');
    const ageInput = document.getElementById('age');

    dobInput?.addEventListener('change', function() {
        const dob = new Date(this.value);
        if (!isNaN(dob)) {
            const diff = new Date(Date.now() - dob.getTime());
            const age = Math.abs(diff.getUTCFullYear() - 1970);
            ageInput.value = age;
        } else {
            ageInput.value = '';
        }
    });

    // // Bootstrap validation
    const forms = document.querySelectorAll('.app-form');
    Array.from(forms).forEach(function(form) {
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });
});
</script>
