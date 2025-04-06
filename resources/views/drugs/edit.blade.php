@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Drugs'])
    <form action="{{ route('drugs.update', $drug->id) }}" method="POST">
        @csrf
        @method('PUT')  
        
        <div class="mb-3">
            <label for="name" class="form-label">Drug Name</label>
            <input type="text" name="name" class="form-control" id="name" value="{{ old('name', $drug->name) }}" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" class="form-control" id="description" rows="3">{{ old('description', $drug->description) }}</textarea>
        </div>
        <div class="mb-3">
            <label for="quantity" class="form-label">Quantity</label>
            <input type="number" name="quantity" class="form-control" id="quantity" value="{{ old('quantity', $drug->quantity) }}" required>
        </div>
        <div class="mb-3">
            <label for="unit" class="form-label">Unit</label>
            <input type="text" name="unit" class="form-control" id="unit" value="{{ old('unit', $drug->unit) }}" required>
        </div>
        <div class="mb-3">
            <label for="cost_price" class="form-label">Cost Price</label>
            <input type="number" name="cost_price" class="form-control" id="cost_price" value="{{ old('cost_price', $drug->cost_price) }}" step="0.01" required>
        </div>
        <div class="mb-3">
            <label for="selling_price" class="form-label">Selling Price</label>
            <input type="number" name="selling_price" class="form-control" id="selling_price" value="{{ old('selling_price', $drug->selling_price) }}" step="0.01">
        </div>
        <button type="submit" class="btn btn-primary">Update Drug</button>
    </form>
    
@endsection