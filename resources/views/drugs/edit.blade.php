@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Edit Drug'])

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12 mx-auto">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="card">
                    <div class="card-header pb-0">
                        <h6>Edit Drug</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('drugs.update', $drug->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="name" class="form-label">Drug Name</label>
                                <input type="text" class="form-control" name="name" id="name" value="{{ $drug->name }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="quantity" class="form-label">Quantity</label>
                                <input type="number" class="form-control" name="quantity" id="quantity" min="1" value="{{ $drug->quantity }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="supply_price" class="form-label">Supply Price (UGX)</label>
                                <input type="number" class="form-control" name="supply_price" id="supply_price" step="0.01" min="0" value="{{ $drug->supply_price }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="supplier_id" class="form-label">Supplier</label>
                                <select name="supplier_id" id="supplier_id" class="form-select" required>
                                    <option value="" disabled>Select Supplier</option>
                                    @foreach ($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}" {{ $supplier->id == $drug->supplier_id ? 'selected' : '' }}>
                                            {{ $supplier->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="d-flex justify-content-end">
                                <a href="{{ route('drugs.index') }}" class="btn btn-secondary me-2">Cancel</a>
                                <button type="submit" class="btn btn-primary">Update Drug</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
