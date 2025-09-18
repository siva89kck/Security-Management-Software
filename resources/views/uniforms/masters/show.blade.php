@extends('layouts.master')

@section('content')
<style>
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
    .detail-card .label {
        font-size: 0.8rem;
        color: #6c757d;
        margin-bottom: 0.25rem;
    }
    .detail-card .value {
        font-weight: 500;
        color: #2c3e50;
        margin-bottom: 0;
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

<!-- Breadcrumb -->
<div class="row m-1">
  <div class="col-12 d-flex justify-content-between align-items-center">
    <div>
      <h4 class="main-title">Uniform Master Details</h4>
      <ul class="app-line-breadcrumbs mb-3">
        <li>
          <a href="{{ route('dashboard') }}" class="f-s-14 f-w-500">
            <span>
              <i class="ph-duotone ph-newspaper f-s-16"></i> Dashboard
            </span>
          </a>
        </li>
        <li>
          <a href="{{ route('masters.index') }}" class="f-s-14 f-w-500">Uniform Masters</a>
        </li>
        <li class="active">
          <a href="#" class="f-s-14 f-w-500">{{ $master->name }}</a>
        </li>
      </ul>
    </div>
    <div>
      <a href="{{ route('masters.edit', $master->id) }}" class="btn btn-success">
        <i class="ti ti-edit"></i> Edit Uniform
      </a>
    </div>
  </div>
</div>
<!-- Breadcrumb end -->

<div class="row">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="section-title">Uniform Master Info</h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="detail-card">
                            <div class="label">Name</div>
                            <div class="value">{{ $master->name ?? '-' }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="detail-card">
                            <div class="label">Size</div>
                            <div class="value">{{ $master->size ?? '-' }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="detail-card">
                            <div class="label">Price</div>
                            <div class="value">{{ $master->price ? number_format($master->price,2) : '-' }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="detail-card">
                            <div class="label">Remaining</div>
                            <div class="value">{{ $master->stock->remaining_stock ?? '0' }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="detail-card">
                            <div class="label">Description</div>
                            <div class="value">{{ $master->description ?? '-' }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="detail-card">
                            <div class="label">Status</div>
                            <div class="value">
                                @if($master->status === 'active')
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div><!-- row -->
            </div>
        </div>
    </div>
</div>
@endsection
