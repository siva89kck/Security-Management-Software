@extends('layouts.master')

@section('content')
    <style>
        .detail-card {
            background: #f9fafd;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
        }

        .detail-card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
        }

        .detail-card .form-control,
        .detail-card .form-select {
            border-radius: 8px;
            transition: 0.3s;
        }

        .detail-card .form-control:focus,
        .detail-card .form-select:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, .25);
        }

        .label {
            font-size: 0.85rem;
            color: #6c757d;
            margin-bottom: 0.25rem;
            display: block;
        }

        .section-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid #e9ecef;
        }

        .items-table th,
        .items-table td {
            vertical-align: middle;
        }
    </style>

    <div class="row m-1">
        <div class="col-12">
            <h4 class="main-title">Edit Uniform Issue - {{ $issue->issue_number }}</h4>
            <ul class="app-line-breadcrumbs mb-3">
                <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li><a href="{{ route('issues.index') }}">Uniform Issues</a></li>
                <li class="active">Edit Issue</li>
            </ul>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form action="{{ route('issues.update', $issue->id) }}" method="POST" class="app-form needs-validation" novalidate>
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="section-title">Issue Details</h5>
                        <div class="row g-3">
                            <div class="col-md-3">
                                <div class="detail-card">
                                    <label class="label">Date <span class="text-danger">*</span></label>
                                    <input type="date" name="issue_date"
                                        value="{{ old('issue_date', $issue->issue_date) }}" class="form-control" required>
                                </div>
                            </div>
                            {{-- <div class="col-md-3">
                        <div class="detail-card">
                            <label class="label">Issue No <span class="text-danger">*</span></label>
                            <input type="text" name="issue_number" value="{{ $issue->issue_number }}" class="form-control" readonly>
                        </div>
                    </div> --}}
                            <div class="col-md-3">
                                <div class="detail-card">
                                    <label class="label">Employee <span class="text-danger">*</span></label>
                                    <select name="employee_id" class="form-select" required>
                                        <option value="">-- Select --</option>
                                        @foreach ($employees as $id => $name)
                                            <option value="{{ $id }}" @selected(old('employee_id', $issue->employee_id) == $id)>
                                                {{ $name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="detail-card">
                                    <label class="label">Issued By <span class="text-danger">*</span></label>
                                    <select name="issued_by" class="form-select" required>
                                        <option value="">-- Select --</option>
                                        @foreach ($issuedByEmployees as $id => $displayName)
                                            <option value="{{ $id }}" @selected(old('issued_by', $issue->issued_by ?? '') == $id)>
                                                {{ $displayName }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">Please select who issued</div>
                                </div>
                            </div>


                            <div class="col-md-3">
                                <div class="detail-card">
                                    <label class="label">Remarks</label>
                                    <input type="text" name="remarks" value="{{ old('remarks', $issue->remarks) }}"
                                        class="form-control">
                                </div>
                            </div>
                        </div>

                        <h5 class="section-title mt-4">Items</h5>
                        <div class="table-responsive">
                            <table class="table items-table align-middle" id="items-table">
                                <thead class="table-light">
                                    <tr>
                                        <th>Item</th>
                                        <th width="100">Qty</th>
                                        <th width="120">Price</th>
                                        <th width="100">Total</th>
                                        <th width="50"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($issue->items as $index => $item)
                                        <tr>
                                            <td>
                                                <select name="items[{{ $index }}][uniform_master_id]"
                                                    class="form-select item-select" required>
                                                    <option value="">-- Select --</option>
                                                    @foreach ($masters as $master)
                                                        <option value="{{ $master->id }}"
                                                            data-price="{{ $master->price }}"
                                                            {{ $item->uniform_master_id == $master->id ? 'selected' : '' }}>
                                                            {{ $master->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td><input type="number" name="items[{{ $index }}][quantity]"
                                                    class="form-control qty" value="{{ $item->quantity }}" min="1"
                                                    required></td>
                                            <td><input type="number" step="0.01"
                                                    name="items[{{ $index }}][price]" class="form-control price"
                                                    value="{{ $item->price }}"></td>
                                            <td class="total-cell">{{ number_format($item->total, 2) }}</td>
                                            <td><button type="button" class="btn btn-sm btn-danger remove">x</button></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <button type="button" id="add-row" class="btn btn-sm btn-secondary mt-2">+ Add Row</button>

                        <div class="text-end mt-4">
                            <button class="btn btn-primary px-4" type="submit">Update Issue</button>
                            <a href="{{ route('issues.index') }}" class="btn btn-outline-secondary">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <script>
        (function() {
            const masters = @json($masters);
            let rowIndex = document.querySelectorAll('#items-table tbody tr').length;

            function newRow(idx) {
                const tr = document.createElement('tr');
                const firstId = masters.length > 0 ? masters[0].id : '';
                const firstPrice = masters.length > 0 ? parseFloat(masters[0].price) || 0 : 0;

                tr.innerHTML = `
            <td>
                <select name="items[${idx}][uniform_master_id]" class="form-select item-select" required>
                    <option value="">-- Select --</option>
                    ${masters.map(m=>`<option value="${m.id}" data-price="${m.price}">${m.name}</option>`).join('')}
                </select>
            </td>
            <td><input type="number" name="items[${idx}][quantity]" class="form-control qty" value="1" min="1" required></td>
            <td><input type="number" step="0.01" name="items[${idx}][price]" class="form-control price" value="${firstPrice}"></td>
            <td class="total-cell">${firstPrice.toFixed(2)}</td>
            <td><button type="button" class="btn btn-sm btn-danger remove">x</button></td>
        `;
                tr.querySelector('.item-select').value = firstId;
                return tr;
            }

            document.addEventListener('DOMContentLoaded', function() {
                const tbody = document.querySelector('#items-table tbody');

                // Add new row
                document.getElementById('add-row').addEventListener('click', function() {
                    tbody.appendChild(newRow(rowIndex));
                    rowIndex++;
                });

                // Remove row
                tbody.addEventListener('click', function(e) {
                    if (e.target.classList.contains('remove')) {
                        e.target.closest('tr').remove();
                    }
                });

                // Update total on qty/price change
                tbody.addEventListener('input', function(e) {
                    if (e.target.classList.contains('qty') || e.target.classList.contains('price')) {
                        const tr = e.target.closest('tr');
                        const qty = parseFloat(tr.querySelector('.qty').value) || 0;
                        const price = parseFloat(tr.querySelector('.price').value) || 0;
                        tr.querySelector('.total-cell').textContent = (qty * price).toFixed(2);
                    }
                });

                // Update price on item select change
                tbody.addEventListener('change', function(e) {
                    if (e.target.classList.contains('item-select')) {
                        const opt = e.target.selectedOptions[0];
                        const price = parseFloat(opt.dataset.price) || 0;
                        const tr = e.target.closest('tr');
                        tr.querySelector('.price').value = price;
                        const qty = parseFloat(tr.querySelector('.qty').value) || 0;
                        tr.querySelector('.total-cell').textContent = (qty * price).toFixed(2);
                    }
                });

                // Update total for existing rows on load
                tbody.querySelectorAll('tr').forEach(tr => {
                    const qty = parseFloat(tr.querySelector('.qty').value) || 0;
                    const price = parseFloat(tr.querySelector('.price').value) || 0;
                    tr.querySelector('.total-cell').textContent = (qty * price).toFixed(2);
                });
            });
        })();
    </script>
@endsection
