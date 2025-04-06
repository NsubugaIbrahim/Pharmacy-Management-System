@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => ''])
    <div class="container">
        <h2>Set Selling Price</h2>
        <form method="POST" action="{{ route('drugs.update', $drug->id) }}">
            @csrf
            @method('PUT')
    
            <div class="mb-3">
                <label class="form-label">Drug Name</label>
                <input type="text" value="{{ $drug->name }}" class="form-control" readonly>
            </div>
    
            <div class="mb-3">
                <label class="form-label">Selling Price</label>
                <input type="number" name="selling_price" step="0.01" class="form-control" required>
            </div>
    
            <button type="submit" class="btn btn-success">Update</button>
        </form>
    </div>

@endsection