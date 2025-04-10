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
                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Quantity</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach($drugsWithQuantities as $drug)
                        <tr>
                            <td>{{ $drug->name }}</td>
                            <td>{{ $drug->total_quantity }}</td>
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