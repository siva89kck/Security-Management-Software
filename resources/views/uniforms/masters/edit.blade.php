@extends('layouts.master')

@section('content')
<style>
    /* Card Design */
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
    .detail-card .form-control,
    .detail-card .form-select {
        border-radius: 8px;
        transition: border-color 0.3s, box-shadow 0.3s;
    }
    .detail-card .form-control:focus,
    .detail-card .form-select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.25rem rgba(13,110,253,.25);
    }
    .label {
        font-size: 0.85rem;
        color: #6c757d;
        margin-bottom: 0.25rem;
        display:block;
    }
    .section-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid #e9ecef;
    }
</style>

<!-- Page Title & Breadcrumb -->
<div class="row m-1">
    <div class="col-12">
        <h4 class="main-title">Edit Uniform Details</h4>
        <ul class="app-line-breadcrumbs mb-3">
            <li>
                <a href="{{ route('dashboard') }}" class="f-s-14 f-w-500">
                    <span>
                        <i class="ph-duotone ph-newspaper f-s-16"></i> Dashboard
                    </span>
                </a>
            </li>
            <li>
                <a href="{{ route('masters.index') }}" class="f-s-14 f-w-500">Uniform Details</a>
            </li>
            <li class="active">
                <a href="#" class="f-s-14 f-w-500">Edit Uniform Details</a>
            </li>
        </ul>
    </div>
</div>

<!-- Edit Form -->
<form action="{{ route('masters.update', $master->id) }}" method="POST" class="app-form needs-validation" novalidate>
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="section-title">Edit Uniform Details</h5>

                    <div class="row g-3">
                        <!-- Uniform Name -->
                        <div class="col-md-6">
                            <div class="detail-card">
                                <label class="label">Uniform Name <span class="text-danger">*</span></label>
                                <select name="name" id="uniformType" class="form-select" required>
                                    <option value="">Select Type</option>
                                    <option value="Shirt" {{ old('name', $master->name) == 'Shirt' ? 'selected' : '' }}>Shirt</option>
                                    <option value="Shirt Full" {{ old('name', $master->name) == 'Shirt Full' ? 'selected' : '' }}>Shirt Full</option>
                                    <option value="Shirt Half" {{ old('name', $master->name) == 'Shirt Half' ? 'selected' : '' }}>Shirt Half</option>
                                    <option value="Short" {{ old('name', $master->name) == 'Short' ? 'selected' : '' }}>Short</option>
                                    <option value="Pant" {{ old('name', $master->name) == 'Pant' ? 'selected' : '' }}>Pant</option>
                                    <option value="Cap" {{ old('name', $master->name) == 'Cap' ? 'selected' : '' }}>Cap</option>
                                    <option value="Shoes" {{ old('name', $master->name) == 'Shoes' ? 'selected' : '' }}>Shoes</option>
                                    <option value="Shoes Black" {{ old('name', $master->name) == 'Shoes Black' ? 'selected' : '' }}>Shoes Black</option>
                                    <option value="Shoes White" {{ old('name', $master->name) == 'Shoes White' ? 'selected' : '' }}>Shoes White</option>
                                </select>
                                <div class="invalid-feedback">Please select uniform name.</div>
                            </div>
                        </div>

                        <!-- Size Dropdown -->
                        <div class="col-md-6">
                            <div class="detail-card">
                                <label class="label">Size <span class="text-danger">*</span></label>
                                <select name="size" id="sizeDropdown" class="form-select" required>
                                    <option value="">Select Size</option>
                                    {{-- JS will populate --}}
                                </select>
                                <div class="invalid-feedback">Please select size.</div>
                            </div>
                        </div>

                        <!-- Price -->
                        <div class="col-md-6">
                            <div class="detail-card">
                                <label class="label">Price</label>
                                <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price', $master->price) }}">
                                <div class="invalid-feedback">Please enter price.</div>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="col-md-6">
                            <div class="detail-card">
                                <label class="label">Description</label>
                                <input type="text" name="description" class="form-control" value="{{ old('description', $master->description) }}">
                            </div>
                        </div>
                    </div>

                    <div class="text-end mt-3">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="ti ti-device-floppy pe-1"></i> Update Uniform
                        </button>
                        <a href="{{ route('masters.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Bootstrap validation
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

    // 🔹 Master Size Groups
    const sizeGroups = {
        'shirt': ['28','30','32','34','36','38','40','42','44','46','48','50'],
        'pant': ['28','30','32','34','36','38','40','42','44','46','48','50'],
        'cap': ['Small','Medium','Large'],
        'shoes': ['5','6','7','8','9','10','11']
    };

    // Function that maps which type to which group
    function getSizeArray(type){
        const lower = type.toLowerCase();

        if(lower.startsWith('shirt')) return sizeGroups['shirt'];   // Shirt, Shirt Full, Shirt Half
        if(lower.startsWith('pant')) return sizeGroups['pant'];     // Pant variations
        if(lower.startsWith('cap')) return sizeGroups['cap'];       // Cap variations
        if(lower.startsWith('shoe')) return sizeGroups['shoes'];    // Shoes Black, Shoes White etc.

        return []; // fallback
    }

    const uniformType = document.getElementById('uniformType');
    const sizeDropdown = document.getElementById('sizeDropdown');

    function populateSizes(type, selectedSize = null){
        sizeDropdown.innerHTML = '<option value="">Select Size</option>';
        const arr = getSizeArray(type);
        arr.forEach(function(size){
            const opt = document.createElement('option');
            opt.value = size;
            opt.textContent = size;
            // selected logic (edit page)
            if(selectedSize && selectedSize == size) opt.selected = true;
            sizeDropdown.appendChild(opt);
        });
    }

    // on load, populate size for existing value
    const oldSize = "{{ old('size', $master->size) }}";
    if(uniformType.value){
        populateSizes(uniformType.value, oldSize);
    }

    // on change
    uniformType.addEventListener('change', function(){
        populateSizes(this.value);
    });
});
</script>

@endsection
