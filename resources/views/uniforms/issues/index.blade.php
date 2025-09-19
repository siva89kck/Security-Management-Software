@extends('layouts.master') {{-- master layout match with your purchase page --}}

@section('content')
    <!-- Breadcrumb start -->
    <div class="row m-1">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div>
                <h4 class="main-title">Uniform Issues List</h4>
                <ul class="app-line-breadcrumbs mb-3">
                    <li>
                        <a href="{{ route('dashboard') }}" class="f-s-14 f-w-500">
                            <span>
                                <i class="ph-duotone ph-newspaper f-s-16"></i> Dashboard
                            </span>
                        </a>
                    </li>
                    <li class="active">
                        <a href="#" class="f-s-14 f-w-500">Uniform Issues List</a>
                    </li>
                </ul>
            </div>

            <!-- Add Issue Button -->
            <div>
                <a href="{{ route('issues.create') }}" class="btn btn-primary">
                    <i class="ti ti-plus"></i> Add Issues
                </a>
            </div>
        </div>
    </div>
    <!-- Breadcrumb end -->

    <!-- Success Flash Message -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="ti ti-circle-check pe-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body p-0">
                    <div class="app-datatable-default overflow-auto">
                        <table id="issue-table"
                            class="display app-data-table default-data-table table-sm align-middle">
                            <thead>
                                <tr>
                                    {{-- <th>#</th> --}}
                                    <th>Issue Number</th>
                                    <th>Issue Date</th>
                                    <th>Employee</th>
                                    <th>Issued By</th>
                                    <th>Total Items</th>
                                    <th>Grand Total</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($issues as $p)
                                    <tr>
                                        {{-- <td>{{ $loop->iteration + ($issues->currentPage()-1)*$issues->perPage() }}</td> --}}
                                        <td><a href="{{ route('issues.show',$p) }}"
                                                class="text-primary text-decoration-underline" title="View">{{ $p->issue_number }}</a></td>
                                        <td>{{ $p->issue_date }}</td>
                                        <td>
                                            {{ optional($p->employee)->first_name ? $p->employee->first_name . ' ' . $p->employee->last_name : '-' }}
                                        </td>
                                        <td>
                                        @if(optional($p->issuedBy)->first_name)
                                            {{ $p->issuedBy->first_name }} {{ $p->issuedBy->last_name }}
                                            @if(optional($p->issuedBy->officialDetail)->role)
                                                - {{ $p->issuedBy->officialDetail->role }}
                                            @endif
                                        @else
                                            -
                                        @endif
                                        </td>
                                        <td>{{ $p->items->count() }}</td>
                                        <td>{{ $p->items->sum(('total'),2) }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('issues.show',$p) }}"
                                                class="btn btn-light-info icon-btn b-r-4" title="View">
                                                <i class="ti ti-eye text-info"></i>
                                            </a>
                                            <a href="{{ route('issues.edit',$p) }}"
                                                class="btn btn-light-success icon-btn b-r-4" title="Edit">
                                                <i class="ti ti-edit text-success"></i>
                                            </a>
                                            <form action="{{ route('issues.destroy',$p) }}" method="POST" class="d-inline"
                                                onsubmit="return confirm('Are you sure to delete this issue?');">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-light-danger icon-btn b-r-4" title="Delete">
                                                    <i class="ti ti-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="p-2">
                        {{ $issues->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Initialize DataTable -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            new DataTable('#issue-table');
        });
    </script>
@endsection
