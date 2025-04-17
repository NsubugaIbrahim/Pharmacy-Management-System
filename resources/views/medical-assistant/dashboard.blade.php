@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Medical Assistant Dashboard'])
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-header pb-0">
                    <h6>Welcome to the Medical Assistant Dashboard</h6>
                </div>
                <div class="card-body">
                    <p class="text-sm">Here you can manage patient records, assist with medical procedures, and ensure smooth operations in the clinic.</p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
