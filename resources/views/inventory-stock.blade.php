@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])
@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Stock Inventory'])
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12 mx-auto">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Stock Inventory</h6>
                        <a href="{{ route('stock.create') }}" class="btn btn-primary">Add Stock</a>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <table class="table table-flush" id="datatable-basic" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>Drug Name</th>
                                    <th>Supplier</th>
                                    <th>Quantity</th>
                                    <th>Purchase Price (UGX)</th>
                                    <th>Total Value (UGX)</th>
                                    <th>Expiry date</th>
                                    <th>Type</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($drugs as $drug)
                                    <tr>
                                        <td>{{ $drug->name }}</td>
                                        <td>
                                            <select class="form-select form-select-sm supplier-select" data-drug-id="{{ $drug->id }}">
                                                <option value="">Select Supplier</option>
                                                @foreach($suppliers as $supplier)
                                                    <option value="{{ $supplier->id }}" {{ (isset($drug->supplier_id) && $drug->supplier_id == $supplier->id) ? 'selected' : '' }}>
                                                        {{ $supplier->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" placeholder="0" size="5">
                                        </td>
                                        <td>
                                            <input type="text" placeholder="0" size="5">
                                        </td>
                                        <td>{{ number_format(($drug->purchase_price ?? 0) * ($drug->quantity ?? 0)) }}</td>
                                        <td><input type = "date" ></td>
                                        <td>{{ $drug->type ?? 'N/A' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            
                        </table>

                    </div>

                </div>
    @include('layouts.footers.auth.footer')
@endsection