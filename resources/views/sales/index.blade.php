@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])
@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Sales'])
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-header pb-0">
                    <h6>Sales</h6>
                </div>
                <div class="card-body">
                    @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        
                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <form method="POST" action="{{ route('sales.store') }}" id="restock-form">
                                @csrf
                                <label for="drug_id" class="form-label">Select Drug:</label>
                                <select name="drug_id" required>
                                    @foreach($drugs as $drug)
                                        <option value="{{ $drug->id }}">{{ $drug->name }}</option>
                                    @endforeach
                                </select>

                                <label for="quantity_sold" class="form-label" >Quantity:</label>
                                <input type="number" name="quantity" class="form-control" min="1" required >

                                <label for="customer_name" class="form-label" >Customer Name:</label>
                                <input type="text" name="customer_name" class="form-control" required>

                                <label for="selling_price" class="form-label">Selling Price:</label>
                                <input type="number" step="0.01" name="selling_price" class="form-control" required>

                                <button type="submit">Sell</button>                              
                            </form>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
    @include('layouts.footers.auth.footer')
@endsection