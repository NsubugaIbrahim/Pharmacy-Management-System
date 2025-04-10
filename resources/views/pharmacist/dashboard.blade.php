<<<<<<< HEAD
@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Pharmacist'])

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="d-flex align-items-center">
                            <h6 class="mb-0">Pharmacist Page</h6>
                            <a href="{{ route('pharmacist.add') }}" class="btn btn-primary btn-sm ms-auto">Add Stock</a>
                        </div>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xs text-center font-weight-bolder opacity-7">Name</th>
                                    <th class="text-uppercase text-secondary text-xs text-center font-weight-bolder opacity-7">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($drug as $item)
                                    <tr>
                                        <td class="text-center">{{ $item->name }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('pharmacist.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                            <form action="{{ route('pharmacist.destroy', $item->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @if($drug->isEmpty())
                            <div class="text-center text-muted py-4">No records found.</div>
                        @endif
=======
@extends('layouts.sidenav-pharmacist', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Pharmacist'])
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <h6>Welcome to the Pharmacist Dashboard</h6>
                    </div>
                    <div class="card-body">
                        <p class="text-sm">Here you can manage prescriptions, oversee medication inventory, and access pharmaceutical resources.</p>
>>>>>>> 23d00e52399ea01972b63be751551c9f80aaf8b2
                    </div>
                </div>
            </div>
        </div>
    </div>
<<<<<<< HEAD
@endsection
=======


@endsection
>>>>>>> 23d00e52399ea01972b63be751551c9f80aaf8b2
