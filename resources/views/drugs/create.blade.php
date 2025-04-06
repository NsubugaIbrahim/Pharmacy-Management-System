@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Drugs'])
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <h6>Add Drug</h6>
                        <a href="{{ route('drugs.index') }}" class="btn btn-primary">View Drugs</a>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-4">
                            <form action="{{ route('drugs.store') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="name" class="form-label">Drug Name</label>
                                    <input type="text" name="name" class="form-control" id="name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea name="description" class="form-control" id="description" rows="3"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="quantity" class="form-label">Quantity</label>
                                    <input type="number" name="quantity" class="form-control" id="quantity" required>
                                </div>
                                <div class="mb-3">
                                    <label for="unit" class="form-label">Unit</label>
                                    <input type="text" name="unit" class="form-control" id="unit" required>
                                </div>
                                <div class="mb-3">
                                    <label for="cost_price" class="form-label">Cost Price</label>
                                    <input type="number" name="cost_price" class="form-control" id="cost_price" step="0.01" required>
                                </div>
                                <div class="mb-3">
                                    <label for="selling_price" class="form-label">Selling Price</label>
                                    <input type="number" name="selling_price" class="form-control" id="selling_price" step="0.01" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>  
@endsection
