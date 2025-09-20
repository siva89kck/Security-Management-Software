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

    /* Default hide print header */
    .print-header {
        display: none;
    }

    /* print style */
    @media print {
        body * {
            visibility: hidden;
        }
        #printArea, #printArea * {
            visibility: visible;
        }
        #printArea {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }
        .no-print {
            display: none !important;
        }

        /* only show logo & header when printing */
        .print-header {
            display: block !important;
            text-align: center;
            margin-bottom: 20px;
        }
        .print-header img {
            max-height: 60px;
            margin-bottom: 10px;
        }
        .print-header h2 {
            margin: 0;
            font-size: 20px;
        }
        .print-header p {
            margin: 0;
            font-size: 14px;
            color: #555;
        }
    }
</style>

<!-- Screen Breadcrumb & Buttons -->
<div class="row m-1 no-print">
  <div class="col-12 d-flex justify-content-between align-items-center">
    <div>
      <h4 class="main-title">Stock Details</h4>
      <ul class="app-line-breadcrumbs mb-3">
        <li>
          <a href="{{ route('dashboard') }}" class="f-s-14 f-w-500">
            <span><i class="ph-duotone ph-newspaper f-s-16"></i> Dashboard</span>
          </a>
        </li>
        <li>
          <a href="{{ route('purchases.index') }}" class="f-s-14 f-w-500">Stock</a>
        </li>
        <li class="active">
          <a href="#" class="f-s-14 f-w-500">Purchase #{{ $purchase->purchase_number }}</a>
        </li>
      </ul>
    </div>
    <div>
      <a href="{{ route('purchases.index') }}" class="btn btn-secondary">
        <i class="ti ti-arrow-left"></i> Back to List
      </a>
      <button onclick="printReport()" class="btn btn-primary">
        <i class="ti ti-printer"></i> Print Uniform Stock
      </button>
    </div>
  </div>
</div>
<!-- Breadcrumb end -->

<div id="printArea">

    <!-- Print Header (logo + company name) -->
    <div class="print-header">
        <img src="{{ asset('assets/images/logo/RSS_Security_Logo.png') }}" alt="RSS_Security_Logo">
        {{-- <h2>My Company Name</h2>
        <p>123 Street Name, City, State - ZIP</p>
        <p>Phone: +91 98765 43210 | Email: info@company.com</p> --}}
        <hr>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="section-title">Uniform Stock</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="detail-card">
                                <div class="label">Purchase Number</div>
                                <div class="value">{{ $purchase->purchase_number ?? '-' }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-card">
                                <div class="label">Purchase Date</div>
                                <div class="value">{{ \Carbon\Carbon::parse($purchase->purchase_date)->format('d-m-Y') }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-card">
                                <div class="label">Supplier</div>
                                <div class="value">{{ $purchase->supplier_name ?? '-' }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-card">
                                <div class="label">Remarks</div>
                                <div class="value">{{ $purchase->remarks ?? '-' }}</div>
                            </div>
                        </div>
                    </div><!-- row -->

                    <h5 class="section-title mt-4">Purchased Items</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Item</th>
                                    <th class="text-end">Qty</th>
                                    <th class="text-end">Price</th>
                                    <th class="text-end">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($purchase->items as $index=>$it)
                                    <tr>
                                        <td>{{ $index+1 }}</td>
                                        <td>{{ $it->master->name ?? 'N/A' }}</td>
                                        <td class="text-end">{{ $it->quantity }}</td>
                                        <td class="text-end">{{ number_format($it->price,2) }}</td>
                                        <td class="text-end">{{ number_format($it->total,2) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">No items found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            @if($purchase->items->count() > 0)
                            <tfoot>
                                <tr>
                                    <th colspan="4" class="text-end">Grand Total</th>
                                    <th class="text-end">{{ number_format($purchase->items->sum('total'),2) }}</th>
                                </tr>
                            </tfoot>
                            @endif
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div> <!-- printArea end -->

<script>
function printReport(){
    window.print();
}
</script>

@endsection
