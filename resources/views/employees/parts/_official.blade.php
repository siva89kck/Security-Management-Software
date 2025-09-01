<h6 class="mt-3 mb-2">Official Details</h6>

<div class="official-form mt-3">
    <div class="row g-3">

        <div class="col-md-6">
            <label class="form-label">Role </label>
            <select name="official[role]" class="form-select" >
                <option value="">--</option>
                <option value="Security Guard" {{ old('official.role', $employeeOfficial->role ?? '') == 'Security Guard' ? 'selected' : '' }}>Security Guard</option>
                <option value="Admin" {{ old('official.role', $employeeOfficial->role ?? '') == 'Admin' ? 'selected' : '' }}>Admin</option>
                <option value="Supervisor" {{ old('official.role', $employeeOfficial->role ?? '') == 'Supervisor' ? 'selected' : '' }}>Supervisor</option>
                <option value="Field Officer" {{ old('official.role', $employeeOfficial->role ?? '') == 'Field Officer' ? 'selected' : '' }}>Field Officer</option>
            </select>
            <div class="invalid-feedback">Please select a role.</div>
        </div>

        <div class="col-md-6">
            <label class="form-label">Date of Join </label>
            <input type="date" name="official[date_of_join]" class="form-control"
                value="{{ old('official.date_of_join', isset($employeeOfficial->date_of_join) ? $employeeOfficial->date_of_join->format('Y-m-d') : '') }}">
            <div class="invalid-feedback">Please select date of join.</div>
        </div>

        <div class="col-md-6">
            <label class="form-label">Employee Type </label>
            <select name="official[employee_type]" class="form-select" >
                <option value="">--</option>
                <option value="Permanent" {{ old('official.employee_type', $employeeOfficial->employee_type ?? '') == 'Permanent' ? 'selected' : '' }}>Permanent</option>
                <option value="Temporary" {{ old('official.employee_type', $employeeOfficial->employee_type ?? '') == 'Temporary' ? 'selected' : '' }}>Temporary</option>
            </select>
            <div class="invalid-feedback">Please select employee type.</div>
        </div>

        <div class="col-md-6">
            <label class="form-label">Salary</label>
            <input type="number" name="official[salary]" class="form-control" step="0.01" min="0"
                value="{{ old('official.salary', $employeeOfficial->salary ?? '') }}">
        </div>

        <div class="col-md-6">
            <label class="form-label">PF Number</label>
            <input type="text" name="official[pf_number]" class="form-control"
                value="{{ old('official.pf_number', $employeeOfficial->pf_number ?? '') }}">
        </div>

        <div class="col-md-6">
            <label class="form-label">ESI Number</label>
            <input type="text" name="official[esi_number]" class="form-control"
                value="{{ old('official.esi_number', $employeeOfficial->esi_number ?? '') }}">
        </div>

        <div class="col-md-6">
            <label class="form-label d-block">PF Calculation</label>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="official[pf_calculation]" id="pf_yes" value="1"
                    {{ old('official.pf_calculation', $employeeOfficial->pf_calculation ?? 0) == 1 ? 'checked' : '' }}>
                <label class="form-check-label" for="pf_yes">Yes</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="official[pf_calculation]" id="pf_no" value="0"
                    {{ old('official.pf_calculation', $employeeOfficial->pf_calculation ?? 0) == 0 ? 'checked' : '' }}>
                <label class="form-check-label" for="pf_no">No</label>
            </div>
        </div>

        <div class="col-md-6">
            <label class="form-label d-block">ESI Calculation</label>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="official[esi_calculation]" id="esi_yes" value="1"
                    {{ old('official.esi_calculation', $employeeOfficial->esi_calculation ?? 0) == 1 ? 'checked' : '' }}>
                <label class="form-check-label" for="esi_yes">Yes</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="official[esi_calculation]" id="esi_no" value="0"
                    {{ old('official.esi_calculation', $employeeOfficial->esi_calculation ?? 0) == 0 ? 'checked' : '' }}>
                <label class="form-check-label" for="esi_no">No</label>
            </div>
        </div>

    </div>
</div>

<style>
/* Two-column card style like family file */
.official-form {
    background: #f9fafd;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    margin-top: 15px;
}

.official-form:hover {
    box-shadow: 0 4px 15px rgba(0,0,0,0.12);
}

.official-form .form-control,
.official-form .form-select {
    border-radius: 10px;
    transition: border-color 0.3s, box-shadow 0.3s;
}

.official-form .form-control:focus,
.official-form .form-select:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.25rem rgba(13,110,253,.25);
}

.official-form .form-check-input {
    cursor: pointer;
}

.official-form .form-check-label {
    cursor: pointer;
}
</style>

<script>
// Bootstrap validation
// document.addEventListener("DOMContentLoaded", function () {
//     const form = document.querySelector("#employeeForm");
//     if(form){
//         form.addEventListener('submit', function(event){
//             if (!form.checkValidity()) {
//                 event.preventDefault();
//                 event.stopPropagation();
//             }
//             form.classList.add('was-validated');
//         }, false);
//     }
// });
</script>
