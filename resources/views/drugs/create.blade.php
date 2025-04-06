@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => ''])
    <div class="container">
        <h2>Stock In Drug</h2>
        <form method="POST" action="{{ route('drugs.store') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Drug Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>
    
            <div class="mb-3">
                <label class="form-label">Supplier</label>
                <select name="supplier_id" class="form-control" required>
                    @foreach($suppliers as $supplier)
                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                    @endforeach
                </select>
            </div>
    
            <div class="mb-3">
                <label class="form-label">Supply Price</label>
                <input type="number" name="supply_price" step="0.01" class="form-control" required>
            </div>
    
            <div class="mb-3">
                <label class="form-label">Quantity</label>
                <input type="number" name="quantity" class="form-control" required>
            </div>
    
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

@endsection