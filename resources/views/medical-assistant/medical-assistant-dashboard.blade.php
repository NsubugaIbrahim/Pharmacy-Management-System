 @extends('layouts.app', ['class' =>
'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Medical Assistant'])
    <div class ="container-fluid py-4">
    <div class="row">
            <div class="col-12 mx-auto">
            <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Customer Order</h6>
                    </div>
    <div class="container mt-4">
    <button class="btn btn-create-order">
        ➕ Create New Order
    </button>
</div>
</div>
</div>
</div>
</div>



@endsection
@push('styles')
<style>
    .btn-create-order {
        background-color: #007bff; /* Blue */
        color: white;
        border: none;
        padding: 10px 20px;
        font-size: 16px;
        border-radius: 8px;
        transition: background-color 0.3s ease;
    }

    .btn-create-order:hover {
        background-color:rgb(85, 230, 49); /* green */
        cursor: pointer;
    }

    /* Optional: align center or add spacing */
    .container {
        max-width: 800px;
    }
</style>
@endpush 