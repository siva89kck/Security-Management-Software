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
        <h4 class="main-title">Uniform Details</h4>
        <ul class="app-line-breadcrumbs mb-3">
            <li>
                <a href="{{ route('dashboard') }}" class="f-s-14 f-w-500">
                    <span>
                        <i class="ph-duotone ph-newspaper f-s-16"></i> Dashboard
                    </span>
                </a>
            </li>
            <li class="active">
                <a href="#" class="f-s-14 f-w-500">Uniform Details</a>
            </li>
        </ul>
    </div>
</div>

<!-- Create Form -->
<form action="{{ route('masters.store') }}" method="POST" class="app-form needs-validation" novalidate>
    @csrf
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="section-title">Add New Uniform Details</h5>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="detail-card">
                                <label class="label">Uniform Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                                <div class="invalid-feedback">Please enter uniform name.</div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="detail-card">
                                <label class="label">Size</label>
                                <input type="text" name="size" class="form-control" value="{{ old('size') }}">
                                <div class="invalid-feedback">Please enter size.</div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="detail-card">
                                <label class="label">Price</label>
                                <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price') }}">
                                <div class="invalid-feedback">Please enter price.</div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="detail-card">
                                <label class="label">Description</label>
                                <input type="text" name="description" class="form-control" value="{{ old('description') }}">
                            </div>
                        </div>
                    </div>

                    <div class="text-end mt-3">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="ti ti-device-floppy pe-1"></i> Save Uniform
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
                event.preventDefault(); // stop submit
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });
});
</script>
@endsection
