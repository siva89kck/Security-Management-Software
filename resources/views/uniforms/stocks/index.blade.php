@extends('layouts.app')
@section('content')
<div class="container">
    <h3>Stocks</h3>
    <table class="table table-bordered">
        <thead><tr><th>#</th><th>Item</th><th>Total Purchased</th><th>Total Issued</th><th>Remaining</th></tr></thead>
        <tbody>
        @foreach($stocks as $s)
            <tr>
                <td>{{ $s->id }}</td>
                <td>{{ $s->master->name ?? 'N/A' }}</td>
                <td>{{ $s->total_purchased }}</td>
                <td>{{ $s->total_issued }}</td>
                <td>{{ $s->remaining_stock }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $stocks->links() }}
</div>
@endsection
