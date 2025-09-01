<h6 class="mt-3 mb-2">Experiences</h6>

<div class="experience-form-repeater mt-3" id="expRepeater">

    @php
        $experiences = old('experiences');

        if (empty($experiences) && isset($employee) && $employee->experiences->count() > 0) {
            $experiences = $employee->experiences->map(function($exp) {
                return [
                    'company_name' => $exp->company_name,
                    'designation'  => $exp->designation,
                    'experience'   => $exp->experience,
                ];
            })->toArray();
        }

        // ✅ Always ensure at least one empty row
        if (empty($experiences)) {
            $experiences = [['company_name'=>'','designation'=>'','experience'=>'']];
        }
    @endphp

    @foreach($experiences as $i => $exp)
    <div class="row g-3 align-items-end repeater-item">
        <div class="col-md-6">
            <label class="form-label">Company</label>
            <input type="text" name="experiences[{{ $i }}][company_name]" value="{{ $exp['company_name'] ?? '' }}" class="form-control" >
            <div class="invalid-feedback">Please enter company name.</div>
        </div>
        <div class="col-md-6">
            <label class="form-label">Designation</label>
            <input type="text" name="experiences[{{ $i }}][designation]" value="{{ $exp['designation'] ?? '' }}" class="form-control" >
            <div class="invalid-feedback">Please enter designation.</div>
        </div>
        <div class="col-md-6">
            <label class="form-label">Experience (Years)</label>
            <select name="experiences[{{ $i }}][experience]" class="form-select" >
                <option value="">Select Years</option>
                @for($y = 0; $y <= 10; $y++)
                    <option value="{{ $y }}" {{ ($exp['experience'] ?? '') == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endfor
            </select>
            <div class="invalid-feedback">Please select experience.</div>
        </div>
        <div class="col-12 d-flex justify-content-end">
            @if($i == 0)
                <button type="button" class="btn btn-outline-primary btn-sm experience-add-row" data-target="#expRepeater">
                    <i class="bi bi-plus-lg me-1"></i> Add Experience
                </button>
            @else
                <button type="button" class="btn btn-outline-danger btn-sm experience-remove-row">
                    <i class="bi bi-trash me-1"></i> Remove
                </button>
            @endif
        </div>
    </div>
    @endforeach
</div>


<template id="expTemplate">
    <div class="row g-3 align-items-end repeater-item">
        <div class="col-md-6">
            <label class="form-label">Company</label>
            <input type="text" name="experiences[__INDEX__][company_name]" class="form-control" >
        </div>
        <div class="col-md-6">
            <label class="form-label">Designation</label>
            <input type="text" name="experiences[__INDEX__][designation]" class="form-control" >
        </div>
        <div class="col-md-6">
            <label class="form-label">Experience (Years) </label>
            <select name="experiences[__INDEX__][experience]" class="form-select" >
                <option value="">Select Years</option>
                @for($y = 1; $y <= 10; $y++)
                    <option value="{{ $y }}">{{ $y }}</option>
                @endfor
            </select>
        </div>
        <div class="col-12 d-flex justify-content-end">
            <button type="button" class="btn btn-outline-danger btn-sm experience-remove-row">
                <i class="bi bi-trash me-1"></i> Remove
            </button>
        </div>
    </div>
</template>

<style>
.experience-form-repeater .repeater-item {
    background: #f9fafd;
    padding: 15px;
    border-radius: 10px;
    margin-bottom: 12px;
    box-shadow: 0 1px 4px rgba(0,0,0,0.08);
    transition: all 0.2s;
}

.experience-form-repeater .repeater-item:hover {
    box-shadow: 0 4px 10px rgba(0,0,0,0.12);
}

.experience-form-repeater .form-control,
.experience-form-repeater .form-select {
    border-radius: 8px;
    transition: border-color 0.2s, box-shadow 0.2s;
}

.experience-form-repeater .form-control:focus,
.experience-form-repeater .form-select:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.2rem rgba(13,110,253,.25);
}

.experience-form-repeater .btn {
    border-radius: 50px;
    padding: 4px 12px;
    min-width: 140px;
}

.experience-form-repeater .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 2px 8px rgba(0,0,0,0.15);
}
</style>

<script>
document.addEventListener('click', function(e) {
    const addBtn = e.target.closest('.experience-add-row');
    const removeBtn = e.target.closest('.experience-remove-row');

    if(addBtn){
        const repeater = document.querySelector(addBtn.dataset.target);
        const template = document.querySelector('#expTemplate').innerHTML;
        const index = repeater.querySelectorAll('.repeater-item').length;
        const newRow = template.replace(/__INDEX__/g, index);
        repeater.insertAdjacentHTML('beforeend', newRow);
        return;
    }

    if(removeBtn){
        const item = removeBtn.closest('.repeater-item');
        if(item) item.remove();
        return;
    }
});

</script>
