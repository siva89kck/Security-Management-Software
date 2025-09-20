@extends('layouts.master')

@section('content')
    <!-- Breadcrumb start -->
    <div class="row m-1">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div>
                <h4 class="main-title">Uniforms List</h4>
                <ul class="app-line-breadcrumbs mb-3">
                    <li>
                        <a href="{{ route('dashboard') }}" class="f-s-14 f-w-500">
                            <span>
                                <i class="ph-duotone ph-newspaper f-s-16"></i> Dashboard
                            </span>
                        </a>
                    </li>
                    <li class="active">
                        <a href="#" class="f-s-14 f-w-500">Uniforms List</a>
                    </li>
                </ul>
            </div>

            <!-- Add Uniform Button -->
            <div>
                <a href="{{ route('masters.create') }}" class="btn btn-primary">
                    <i class="ti ti-plus"></i> Add Uniform
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
                        <table id="uniforms-table" class="display app-data-table default-data-table table-sm align-middle">
                            <thead>
                                <tr>
                                    {{-- <th>#</th> --}}
                                    <th>Uniform Name</th>
                                    <th>Size</th>
                                    <th>Price</th>
                                    <th>Remaining</th>
                                    {{-- <th>Status</th> --}}
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($masters as $m)
                                    <tr>
                                        {{-- <td>{{ $m->id }}</td> --}}
                                        <td>
                                            <a href="{{ route('masters.show', $m) }}"
                                                class="text-primary text-decoration-underline" title="View">
                                                {{ $m->name }}</a>
                                        </td>
                                        <td>{{ $m->size }}</td>
                                        <td>{{ $m->price }}</td>
                                        <td>{{ optional($m->stock)->remaining_stock ?? 0 }}</td>
                                        {{-- <td>
                                            <button
                                                class="btn btn-sm status-btn w-100 {{ $m->status == 'active' ? 'btn-success' : 'btn-danger' }}"
                                                data-id="{{ $m->id }}">
                                                {{ ucfirst($m->status) }}
                                            </button>
                                        </td> --}}
                                        <td class="text-center">
                                            <a href="{{ route('masters.show', $m) }}"
                                                class="btn btn-light-info icon-btn b-r-4" title="View">
                                                <i class="ti ti-eye text-info"></i>
                                            </a>
                                            <a href="{{ route('masters.edit', $m) }}"
                                                class="btn btn-light-success icon-btn b-r-4" title="Edit">
                                                <i class="ti ti-edit text-success"></i>
                                            </a>
                                            <form action="{{ route('masters.destroy', $m) }}" method="POST"
                                                class="d-inline delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-light-danger icon-btn b-r-4"
                                                    title="Delete">
                                                    <i class="ti ti-trash"></i>
                                                </button>
                                            </form>
                                            {{-- <form action="{{ route('masters.destroy', $m) }}" method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('Are you sure you want to delete this uniform?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-light-danger icon-btn b-r-4"
                                                    title="Delete">
                                                    <i class="ti ti-trash"></i>
                                                </button>
                                            </form> --}}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="p-2">
                        {{ $masters->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Initialize DataTable -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            new DataTable('#uniforms-table');
        });
    </script>
@endsection

<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll(".status-btn").forEach(button => {
            button.addEventListener("click", function() {
                let id = this.dataset.id;
                let btn = this;

                fetch(`/uniforms/${id}/toggle-status`, {
                        method: "PATCH",
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                            "Content-Type": "application/json"
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            if (data.status === "active") {
                                btn.classList.remove("btn-danger");
                                btn.classList.add("btn-success");
                                btn.textContent = "Active";

                                Swal.fire({
                                    toast: true,
                                    position: 'top-end',
                                    icon: 'success',
                                    title: 'Uniform Activated',
                                    showConfirmButton: false,
                                    timer: 2000
                                });
                            } else {
                                btn.classList.remove("btn-success");
                                btn.classList.add("btn-danger");
                                btn.textContent = "Inactive";

                                Swal.fire({
                                    toast: true,
                                    position: 'top-end',
                                    icon: 'warning',
                                    title: 'Uniform Deactivated',
                                    showConfirmButton: false,
                                    timer: 2000
                                });
                            }
                        }
                    });
            });
        });
    });
</script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    // DELETE CONFIRMATION ALERT
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault(); // prevent normal submit
            let formRef = this;

            Swal.fire({
                title: 'Are you sure?',
                text: "This will permanently delete the employee record!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // actually submit the form
                    formRef.submit();
                }
            });
        });
    });
});
</script>
