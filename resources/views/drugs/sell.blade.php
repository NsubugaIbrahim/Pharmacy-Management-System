@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Drugs 4'])
    <div class="container">
        <h2>Sell Drug</h2>
        <form method="POST" action="{{ route('drugs.processSale', $drug->id) }}">
            @csrf
    
            <div class="mb-3">
                <label class="form-label">Drug Name</label>
                <input type="text" value="{{ $drug->name }}" class="form-control" readonly>
            </div>
    
            <div class="mb-3">
                <label class="form-label">Available Quantity</label>
                <input type="number" value="{{ $drug->quantity }}" class="form-control" readonly>
            </div>
    
            <div class="mb-3">
                <label class="form-label">Selling Price</label>
                <input type="number" value="{{ $drug->selling_price }}" class="form-control" readonly>
            </div>
    
            <div class="mb-3">
                <label class="form-label">Quantity to Sell</label>
                <input type="number" name="quantity" class="form-control" required>
            </div>
    
            <button type="submit" class="btn btn-primary">Sell</button>
        </form>
    </div>

@endsection