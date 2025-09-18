@extends('layouts.master')
@section('content')

  <!-- Breadcrumb start -->
  <div class="row m-1">
    <div class="col-12">
      <h4 class="main-title">Dashboard</h4>
      <ul class="app-line-breadcrumbs mb-3">
        <li>
          <a href="{{ route('dashboard') }}" class="f-s-14 f-w-500">
            <span>
              <i class="ph-duotone ph-newspaper f-s-16"></i> Dashboard
            </span>
          </a>
        </li>
        <li class="active">
          <a href="#" class="f-s-14 f-w-500">Over View</a>
        </li>
      </ul>
    </div>
  </div>

  <div class="row">
    {{-- Active Employees --}}
    <div class="col-sm-6 col-lg-3">
      <div class="card eshop-cards">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center">
            <span class="bg-success h-40 w-40 d-flex-center b-r-15 f-s-18">
              <i class="ph-bold ph-users-three"></i>
            </span>
          </div>
          <div class="mt-3">
            <p class="f-s-16 mb-0">Active Guards</p>
            <h5>{{ $activeEmployees }}</h5>
          </div>
        </div>
      </div>
    </div>

    {{-- Inactive Employees --}}
    <div class="col-sm-6 col-lg-3">
      <div class="card eshop-cards">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center">
            <span class="bg-danger h-40 w-40 d-flex-center b-r-15 f-s-18">
              <i class="ph-bold ph-user-minus"></i>
            </span>
          </div>
          <div class="mt-3">
            <p class="f-s-16 mb-0">Inactive Guards</p>
            <h5>{{ $inactiveEmployees }}</h5>
          </div>
        </div>
      </div>
    </div>

    {{-- Total Uniforms --}}
    <div class="col-sm-6 col-lg-3">
      <div class="card eshop-cards">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center">
            <span class="bg-primary h-40 w-40 d-flex-center b-r-15 f-s-18">
              <i class="ph-bold ph-shirt-folded"></i>
            </span>
          </div>
          <div class="mt-3">
            <p class="f-s-16 mb-0">Total Uniforms</p>
            <h5>{{ $uniformCount }}</h5>
          </div>
        </div>
      </div>
    </div>

    {{-- Placeholder for more metrics --}}
    <div class="col-sm-6 col-lg-3">
      <div class="card eshop-cards">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center">
            <span class="bg-warning h-40 w-40 d-flex-center b-r-15 f-s-18">
              <i class="ph-bold ph-trend-up"></i>
            </span>
          </div>
          <div class="mt-3">
            <p class="f-s-16 mb-0">Other Metric</p>
            <h5>--</h5>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- Recently Issued Uniforms --}}
  <div class="row mt-4">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h5 class="mb-0">Recently Issued Uniforms</h5>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-striped mb-0">
              <thead>
                <tr>
                  <th>Issue Date</th>
                  <th>Issue Number</th>
                  <th>Employee</th>
                  <th>Uniform Items</th>
                </tr>
              </thead>
              <tbody>
                @forelse($issuedRecords as $issue)
                  <tr>
                    <td>{{ $issue->issue_date }}</td>
                    <td>{{ $issue->issue_number }}</td>
                    <td>{{ optional($issue->employee)->first_name }} {{ optional($issue->employee)->last_name }}</td>
                    <td>
                      @foreach($issue->items as $item)
                        <div>{{ $item->master->name ?? '' }} (Qty: {{ $item->quantity }})</div>
                      @endforeach
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="4" class="text-center">No records found</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection
