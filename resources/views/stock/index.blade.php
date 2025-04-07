@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Stock'])
 <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header pb-0">
                <div class="d-flex align-items-center">
                <h6>Stock</h6>
                <a href="{{ route('stock.create') }}" class="btn btn-primary btn-sm ms-auto">Add Stock</a>
                </div>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Drug Name</th>
                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Supplier</th>
                      <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Quantity</th>
                      <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($stockEntries as $stockEntry)
                      <tr>
                        <td class="align-middle text-sm ps-4">{{ $stockEntry->drug->name  }}</td>
                        <td class="align-middle text-sm ps-4">{{ $stockEntry->supplier->name }}</td>
                        <td class="align-middle text-sm ps-4">{{ $stockEntry->quantity }}</td>
                        <td class="align-middle text-sm ps-4">
                          <a href="{{ route('stock.edit', $stockEntry->id) }}" class="btn btn-warning btn-sm">Edit</a>
                          <form action="{{ route('stock.destroy', $stockEntry->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                          </form>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    @include('layouts.footers.auth.footer')
@endsection