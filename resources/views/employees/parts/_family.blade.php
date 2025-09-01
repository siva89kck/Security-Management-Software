<div class="family-form-repeater mt-3" id="familyRepeater">

    @php
        $familyMembers = old('family_members');

        if (empty($familyMembers) && isset($employee) && $employee->familyMembers->count() > 0) {
            $familyMembers = $employee->familyMembers->map(function($m) {
                return [
                    'name' => $m->name,
                    'dob'  => $m->dob ? \Carbon\Carbon::parse($m->dob)->format('Y-m-d') : '',
                    'relationship' => $m->relationship,
                    'marital_status'=> $m->marital_status,
                    'mobile_number' => $m->mobile_number ?? '',
                ];
            })->toArray();
        }

        // ✅ Always ensure at least one empty row
        if (empty($familyMembers)) {
            $familyMembers = [['name'=>'','dob'=>'','relationship'=>'','marital_status'=>'','mobile_number'=>'']];
        }
    @endphp

    @foreach ($familyMembers as $i => $member)
        <div class="row g-3 align-items-end repeater-item">
            <div class="col-md-6">
                <label class="form-label">Name</label>
                <input type="text" name="family_members[{{ $i }}][name]" value="{{ $member['name'] ?? '' }}" class="form-control" >
            </div>

            <div class="col-md-6">
                <label class="form-label">DOB</label>
                <input type="date" name="family_members[{{ $i }}][dob]" value="{{ $member['dob'] ?? '' }}" class="form-control" >
            </div>

            <div class="col-md-6">
                <label class="form-label">Relationship</label>
                <input type="text" name="family_members[{{ $i }}][relationship]" value="{{ $member['relationship'] ?? '' }}" class="form-control" >
            </div>

            <div class="col-md-6">
                <label class="form-label">Marital Status</label>
                <select name="family_members[{{ $i }}][marital_status]" class="form-select" >
                    <option value="">--Select--</option>
                    <option value="Single" {{ ($member['marital_status'] ?? '') == 'Single' ? 'selected' : '' }}>Single</option>
                    <option value="Married" {{ ($member['marital_status'] ?? '') == 'Married' ? 'selected' : '' }}>Married</option>
                    <option value="Widow" {{ ($member['marital_status'] ?? '') == 'Widow' ? 'selected' : '' }}>Widow</option>
                    <option value="Divorce" {{ ($member['marital_status'] ?? '') == 'Divorce' ? 'selected' : '' }}>Divorce</option>
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Mobile Number</label>
                <input type="text" name="family_members[{{ $i }}][mobile_number]" value="{{ $member['mobile_number'] ?? '' }}" class="form-control" >
            </div>

            <div class="col-12 d-flex justify-content-end">
                @if ($i == 0)
                    <button type="button" class="btn btn-outline-primary btn-sm add-family-row" data-target="#familyRepeater">
                        <i class="bi bi-plus-lg me-1"></i> Add Family Member
                    </button>
                @else
                    <button type="button" class="btn btn-outline-danger btn-sm family-remove-row">
                        <i class="bi bi-trash me-1"></i> Remove
                    </button>
                @endif
            </div>
        </div>
    @endforeach
</div>

<template id="familyTemplate">
    <div class="row g-3 align-items-end repeater-item">
        <div class="col-md-6">
            <label class="form-label">Name</label>
            <input type="text" name="family_members[__INDEX__][name]" class="form-control" >
        </div>
        <div class="col-md-6">
            <label class="form-label">DOB</label>
            <input type="date" name="family_members[__INDEX__][dob]" class="form-control" >
        </div>
        <div class="col-md-6">
            <label class="form-label">Relationship</label>
            <input type="text" name="family_members[__INDEX__][relationship]" class="form-control" >
        </div>
        <div class="col-md-6">
            <label class="form-label">Marital Status</label>
            <select name="family_members[__INDEX__][marital_status]" class="form-select" >
                <option value="">--Select--</option>
                <option value="Single">Single</option>
                <option value="Married">Married</option>
                <option value="Widow">Widow</option>
                <option value="Divorce">Divorce</option>
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label">Mobile Number</label>
            <input type="text" name="family_members[__INDEX__][mobile_number]" class="form-control" >
        </div>
        <div class="col-12 d-flex justify-content-end">
            <button type="button" class="btn btn-outline-danger btn-sm family-remove-row">
                <i class="bi bi-trash me-1"></i> Remove
            </button>
        </div>
    </div>
</template>


<style>
.family-form-repeater .repeater-item {
    background: #f9fafd;
    padding: 15px;
    border-radius: 10px;
    margin-bottom: 12px;
    box-shadow: 0 1px 4px rgba(0,0,0,0.08);
    transition: all 0.2s;
}

.family-form-repeater .repeater-item:hover {
    box-shadow: 0 4px 10px rgba(0,0,0,0.12);
}

.family-form-repeater .form-control,
.family-form-repeater .form-select {
    border-radius: 8px;
    transition: border-color 0.2s, box-shadow 0.2s;
}

.family-form-repeater .form-control:focus,
.family-form-repeater .form-select:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.2rem rgba(13,110,253,.25);
}

.family-form-repeater .btn {
    border-radius: 50px;
    padding: 4px 12px;
    min-width: 120px;
}

.family-form-repeater .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 2px 8px rgba(0,0,0,0.15);
}
</style>

<script>
document.addEventListener('click', function(e) {
  // Add new family member row
  if (e.target.classList.contains('add-family-row')) {
    const repeater = document.querySelector(e.target.dataset.target);
    const template = document.querySelector('#familyTemplate').innerHTML;
    const index = repeater.querySelectorAll('.repeater-item').length;
    const newRow = template.replace(/__INDEX__/g, index);
    repeater.insertAdjacentHTML('beforeend', newRow);
    return;
  }

  // Remove row handler
  if (e.target.classList.contains('family-remove-row')) {
    const item = e.target.closest('.repeater-item');
    if (item) item.remove();
    return;
  }
});
</script>
