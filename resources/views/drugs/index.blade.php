@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Drugs'])
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <h6>Drugs</h6>
                        <a href="{{ route('drugs.stock') }}" class="btn btn-primary">Add Drug</a>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Name</th>
                                    <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Supplier</th>
                                    <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Supply Price</th>
                                    <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Selling Price</th>
                                    <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Quantity</th>
                                    <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($drugs as $drug)
                                    <tr>
                                        <td>{{ $drug->name }}</td>
                                        <td>{{ $drug->supplier->name }}</td>
                                        <td>{{ $drug->supply_price }}</td>
                                        <td>{{ $drug->selling_price ?? 'Not set' }}</td>
                                        <td>{{ $drug->quantity }}</td>
                                        <td>
                                            <a href="{{ route('drugs.edit', $drug->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                            <a href="{{ route('drugs.sell', $drug->id) }}" class="btn btn-sm btn-success">Sell</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


@endsection