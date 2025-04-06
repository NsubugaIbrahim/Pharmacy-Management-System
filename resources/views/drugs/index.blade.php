@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Drugs'])
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="d-flex align-items-center">
                            <h6 class="mb-0">Drugs</h6>
                            <a href="{{ route('drugs.stock') }}" class="btn btn-primary btn-sm ms-auto">Add Drug</a>
                        </div>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xs text-center font-weight-bolder opacity-7">Name</th>
                                    <th class="text-uppercase text-secondary text-xs text-center font-weight-bolder opacity-7">Supplier</th>
                                    <th class="text-uppercase text-secondary text-xs text-center font-weight-bolder opacity-7">Supply Price</th>
                                    <th class="text-uppercase text-secondary text-xs text-center font-weight-bolder opacity-7">Selling Price</th>
                                    <th class="text-uppercase text-secondary text-xs text-center font-weight-bolder opacity-7">Quantity</th>
                                    <th class="text-uppercase text-secondary text-xs text-center font-weight-bolder opacity-7">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($drugs as $drug)
                                    <tr>
                                        <td class="align-middle text-sm ps-4 text-center">{{ $drug->name }}</td>
                                        <td class="align-middle text-sm ps-4 text-center">{{ $drug->supplier->name }}</td>
                                        <td class="align-middle text-sm ps-4 text-center">{{ $drug->supply_price }}</td>
                                        <td class="align-middle text-sm ps-4 text-center">{{ $drug->selling_price ?? 'Not set' }}</td>
                                        <td class="align-middle text-sm ps-4 text-center">{{ $drug->quantity }}</td>
                                        <td class="align-middle text-sm ps-4 text-center">
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