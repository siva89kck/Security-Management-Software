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
    .items-table th, .items-table td { vertical-align: middle; }
</style>

<div class="row m-1">
    <div class="col-12">
        <h4 class="main-title">{{ isset($purchase) ? 'Edit Stock Details' : 'Add Stock Details' }}</h4>
        <ul class="app-line-breadcrumbs mb-3">
            <li>
                <a href="{{ route('dashboard') }}" class="f-s-14 f-w-500">
                    <span><i class="ph-duotone ph-newspaper f-s-16"></i> Dashboard</span>
                </a>
            </li>
            <li class="active">
                <a href="#" class="f-s-14 f-w-500">{{ isset($purchase) ? 'Edit Stock' : 'Add Stock' }}</a>
            </li>
        </ul>
    </div>
</div>

@if($errors->any())
<div class="alert alert-danger alert-dismissible fade show">
    <ul class="mb-0">
        @foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<form action="{{ isset($purchase) ? route('purchases.update', $purchase->id) : route('purchases.store') }}" method="POST" class="app-form needs-validation" novalidate>
@csrf
@if(isset($purchase)) @method('PUT') @endif

<div class="row">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="section-title">Purchase Info</h5>
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="detail-card">
                            <label class="label">Purchase Date <span class="text-danger">*</span></label>
                            <input type="date" name="purchase_date" value="{{ old('purchase_date', $purchase->purchase_date ?? '') }}" class="form-control" required>
                            <div class="invalid-feedback">Please enter date</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="detail-card">
                            <label class="label">Supplier Name <span class="text-danger">*</span></label>
                            <input type="text" name="supplier_name" value="{{ old('supplier_name', $purchase->supplier_name ?? '') }}" class="form-control" required>
                            <div class="invalid-feedback">Please enter supplier name</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="detail-card">
                            <label class="label">Remarks</label>
                            <input type="text" name="remarks" value="{{ old('remarks', $purchase->remarks ?? '') }}" class="form-control">
                        </div>
                    </div>
                </div>

                <h5 class="section-title mt-4">Items</h5>
                <div class="table-responsive">
                    <table class="table items-table align-middle" id="items-table">
                        <thead class="table-light">
                            <tr>
                                <th>Item</th>
                                <th>Size</th>
                                <th>Qty</th>
                                <th>Price</th>
                                <th>Total</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <button type="button" id="add-row" class="btn btn-sm btn-secondary">+ Add Item</button>
                @error('items')<div class="text-danger mt-2">{{ $message }}</div>@enderror

                <div class="text-end mt-4">
                    <button class="btn btn-primary px-4" type="submit">
                        <i class="ti ti-device-floppy pe-1"></i> {{ isset($purchase) ? 'Update Purchase' : 'Save Purchase' }}
                    </button>
                    <a href="{{ route('purchases.index') }}" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </div>
        </div>
    </div>
</div>
</form>

<script>
(function(){
    const masters = @json($masters);
    let rowIndex = 0;

    function newRow(idx){
    const tr = document.createElement('tr');

    // first record defaults
    const firstId = masters.length > 0 ? masters[0].id : '';
    const firstPrice = masters.length > 0 ? masters[0].price : '';
    const firstSize = masters.length > 0 && masters[0].sizes?.length ? masters[0].sizes[0] : '';

    tr.innerHTML = `
        <td>
            <select name="items[${idx}][uniform_master_id]"
                    class="form-control item-select" required>
                ${masters.map((m,i)=>
                  `<option value="${m.id}"
                    data-price="${m.price}"
                    data-sizes='${JSON.stringify(m.sizes||[])}'
                    ${i===0?'selected':''}>${m.name}</option>`).join('')}
            </select>
        </td>
        <td>
            <input type="text" name="items[${idx}][size]"
                   class="form-control size-input"
                   value="${firstSize}" required>
        </td>
        <td><input type="number" name="items[${idx}][quantity]" class="form-control qty" value="1" min="1"></td>
        <td><input type="number" step="0.01" name="items[${idx}][price]" class="form-control price" value="${firstPrice}"></td>
        <td class="total-cell">${(1*firstPrice).toFixed(2)}</td>
        <td><button type="button" class="btn btn-sm btn-danger remove">x</button></td>
    `;

    return tr;
}


    // Add row
    document.getElementById('add-row').addEventListener('click', ()=>{
        document.querySelector('#items-table tbody').appendChild(newRow(rowIndex));
        rowIndex++;
    });

    // Remove row
    document.addEventListener('click', function(e){
        if(e.target.classList.contains('remove')){
            e.target.closest('tr').remove();
        }
    });

    // Qty or Price change → total
    document.addEventListener('input', function(e){
        if(e.target.classList.contains('qty') || e.target.classList.contains('price')){
            const tr = e.target.closest('tr');
            const qty = parseFloat(tr.querySelector('.qty').value) || 0;
            const price = parseFloat(tr.querySelector('.price').value) || 0;
            tr.querySelector('.total-cell').textContent = (qty * price).toFixed(2);
        }
    });

    // Item change → auto price + size update
    document.addEventListener('change', function(e){
        if(e.target.classList.contains('item-select')){
            const opt = e.target.selectedOptions[0];
            const price = parseFloat(opt.dataset.price) || 0;
            const sizes = JSON.parse(opt.dataset.sizes || '[]');

            const tr = e.target.closest('tr');
            tr.querySelector('.price').value = price;

            // size box auto fill with first size
            if(sizes.length){
                tr.querySelector('.size-input').value = sizes[0];
            } else {
                tr.querySelector('.size-input').value = '';
            }

            const qty = parseFloat(tr.querySelector('.qty').value) || 0;
            tr.querySelector('.total-cell').textContent = (qty * price).toFixed(2);
        }
    });

})();

</script>

@endsection
