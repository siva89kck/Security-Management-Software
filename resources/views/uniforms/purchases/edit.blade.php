@extends('layouts.master')

@section('content')
<style>
.detail-card { background: #f9fafd; border-radius: 12px; padding: 20px; margin-bottom: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); transition: all 0.3s ease; }
.detail-card:hover { box-shadow: 0 4px 12px rgba(0,0,0,0.12); }
.detail-card .form-control, .detail-card .form-select { border-radius: 8px; transition: 0.3s; }
.detail-card .form-control:focus, .detail-card .form-select:focus { border-color: #0d6efd; box-shadow: 0 0 0 0.25rem rgba(13,110,253,.25); }
.label { font-size:0.85rem; color:#6c757d; margin-bottom:0.25rem; display:block; }
.section-title { font-size:1.1rem; font-weight:600; color:#2c3e50; margin-bottom:1rem; padding-bottom:0.5rem; border-bottom:1px solid #e9ecef; }
.items-table th, .items-table td { vertical-align: middle; }
</style>

<div class="row m-1">
    <div class="col-12">
        <h4 class="main-title">Edit Stock Entry - {{ $purchase->purchase_number }}</h4>
        <ul class="app-line-breadcrumbs mb-3">
            <li><a href="{{ route('dashboard') }}"><i class="ph-duotone ph-newspaper f-s-16"></i> Dashboard</a></li>
            <li><a href="{{ route('purchases.index') }}">Purchases</a></li>
            <li class="active"><a href="#">Edit Stock Entry</a></li>
        </ul>
    </div>
</div>

@if($errors->any())
<div class="alert alert-danger alert-dismissible fade show">
    <ul class="mb-0">@foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach</ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<form action="{{ route('purchases.update', $purchase->id) }}" method="POST" class="app-form needs-validation" novalidate>
@csrf
@method('PUT')

<div class="row">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="section-title">Stock Information</h5>
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="detail-card">
                            <label class="label">Purchase Date <span class="text-danger">*</span></label>
                            <input type="date" name="purchase_date" value="{{ old('purchase_date', $purchase->purchase_date) }}" class="form-control" required>
                            <div class="invalid-feedback">Please enter date</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="detail-card">
                            <label class="label">Supplier Name <span class="text-danger">*</span></label>
                            <input type="text" name="supplier_name" value="{{ old('supplier_name', $purchase->supplier_name) }}" class="form-control" required>
                            <div class="invalid-feedback">Please enter supplier name</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="detail-card">
                            <label class="label">Remarks</label>
                            <input type="text" name="remarks" value="{{ old('remarks', $purchase->remarks) }}" class="form-control">
                        </div>
                    </div>
                </div>

                <h5 class="section-title mt-4">Items</h5>
                <div class="table-responsive">
                    <table class="table items-table align-middle" id="items-table">
                        <thead class="table-light">
                            <tr><th>Item</th><th>Size</th><th>Qty</th><th>Price</th><th>Total</th><th></th></tr>
                        </thead>
                        <tbody>
                            @foreach($purchase->items as $index => $item)
                            <tr>
                                <td>
                                    <select name="items[{{ $index }}][uniform_master_id]" class="form-control item-select" required>
                                        <option value="">--select--</option>
                                        @foreach($masters as $master)
                                            <option value="{{ $master->id }}"
                                                data-price="{{ $master->price }}"
                                                data-sizes='@json(explode(",",$master->size))'
                                                {{ $item->uniform_master_id == $master->id ? 'selected' : '' }}>
                                                {{ $master->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                <select name="items[{{ $index }}][size]" class="form-control size-select" required>
                                    <option value="">--select--</option>
                                    @php
                                        $selectedMaster = $masters->firstWhere('id', $item->uniform_master_id);
                                        $sizes = $selectedMaster && $selectedMaster->size ? explode(',', $selectedMaster->size) : [];
                                    @endphp
                                    @foreach($sizes as $sz)
                                        <option value="{{ $sz }}" {{ $item->size == $sz ? 'selected' : '' }}>{{ $sz }}</option>
                                    @endforeach
                                </select>
                            </td>

                                <td><input type="number" name="items[{{ $index }}][quantity]" class="form-control qty" value="{{ $item->quantity }}" min="1"></td>
                                <td><input type="number" step="0.01" name="items[{{ $index }}][price]" class="form-control price" value="{{ $item->price }}"></td>
                                <td class="total-cell">{{ number_format($item->total, 2) }}</td>
                                <td><button type="button" class="btn btn-sm btn-danger remove">x</button></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <button type="button" id="add-row" class="btn btn-sm btn-secondary mt-2">+ Add Item</button>
                @error('items')<div class="text-danger mt-2">{{ $message }}</div>@enderror

                <div class="text-end mt-4">
                    <button class="btn btn-primary px-4" type="submit"><i class="ti ti-device-floppy pe-1"></i> Update Purchase</button>
                    <a href="{{ route('purchases.index') }}" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </div>
        </div>
    </div>
</div>
</form>

@php
    // Create a safe PHP array for JS to avoid inline arrow functions inside @json
    $mastersForJs = collect($masters)->map(function($m){
        return [
            'id' => $m->id,
            'name' => $m->name,
            'price' => $m->price,
            'sizes' => !empty($m->size) ? explode(',', $m->size) : []
        ];
    })->values()->toArray();
@endphp

<script>
(function(){
    // Use the prepared PHP array
    const masters = @json($mastersForJs);
    let rowIndex = {{ $purchase->items->count() }};

    function newRow(idx){
        const tr = document.createElement('tr');
        const firstId = masters.length > 0 ? masters[0].id : '';
        const firstPrice = masters.length > 0 ? masters[0].price : '';
        const firstSizes = masters.length > 0 ? masters[0].sizes : [];

        tr.innerHTML = `
            <td>
                <select name="items[${idx}][uniform_master_id]" class="form-control item-select" required>
                    <option value="">--select--</option>
                    ${masters.map(m=>`<option value="${m.id}" data-price="${m.price}" data-sizes='${JSON.stringify(m.sizes)}'>${m.name}</option>`).join('')}
                </select>
            </td>
            <td>
                <select name="items[${idx}][size]" class="form-control size-select" required>
                    <option value="">--select--</option>
                </select>
            </td>
            <td><input type="number" name="items[${idx}][quantity]" class="form-control qty" value="1" min="1"></td>
            <td><input type="number" step="0.01" name="items[${idx}][price]" class="form-control price" value="${firstPrice}"></td>
            <td class="total-cell">${firstPrice}</td>
            <td><button type="button" class="btn btn-sm btn-danger remove">x</button></td>
        `;

        setTimeout(()=>{
            const sel = tr.querySelector('.item-select');
            const sizeSel = tr.querySelector('.size-select');
            sel.value = firstId;

            // Populate size dropdown
            const sizes = JSON.parse(sel.selectedOptions[0].dataset.sizes || '[]');
            sizeSel.innerHTML = '<option value="">--select--</option>';
            sizes.forEach(sz=>{
                const opt = document.createElement('option');
                opt.value = sz; opt.textContent = sz;
                sizeSel.appendChild(opt);
            });
            if(sizes.length) sizeSel.value = sizes[0];
        },0);

        return tr;
    }

    // Add row
    document.getElementById('add-row').addEventListener('click', ()=>{
        document.querySelector('#items-table tbody').appendChild(newRow(rowIndex));
        rowIndex++;
    });

    // Remove row
    document.addEventListener('click', function(e){
        if(e.target.classList.contains('remove')) e.target.closest('tr').remove();
    });

    // qty or price change → total update
    document.addEventListener('input', function(e){
        if(e.target.classList.contains('qty') || e.target.classList.contains('price')){
            const tr = e.target.closest('tr');
            const qty = parseFloat(tr.querySelector('.qty').value) || 0;
            const price = parseFloat(tr.querySelector('.price').value) || 0;
            tr.querySelector('.total-cell').textContent = (qty*price).toFixed(2);
        }
    });

    // item dropdown change → auto price & size update (preserve existing selection if possible)
    document.addEventListener('change', function(e){
        if(e.target.classList.contains('item-select')){
            const tr = e.target.closest('tr');
            const opt = e.target.selectedOptions[0];
            const price = parseFloat(opt.dataset.price) || 0;
            tr.querySelector('.price').value = price;

            // populate size but preserve selected if possible
            const sizeSel = tr.querySelector('.size-select');
            const currentSelected = sizeSel.value;
            const sizes = JSON.parse(opt.dataset.sizes || '[]');
            sizeSel.innerHTML = '<option value="">--select--</option>';
            sizes.forEach(sz=>{
                const so = document.createElement('option');
                so.value = sz; so.textContent = sz;
                sizeSel.appendChild(so);
            });
            if (sizes.includes(currentSelected)) {
                sizeSel.value = currentSelected;
            } else if (sizes.length) {
                sizeSel.value = sizes[0];
            }

            const qty = parseFloat(tr.querySelector('.qty').value) || 0;
            tr.querySelector('.total-cell').textContent = (qty*price).toFixed(2);
        }
    });
})();
</script>
@endsection
