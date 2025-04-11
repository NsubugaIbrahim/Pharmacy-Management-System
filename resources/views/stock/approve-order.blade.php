@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Approve / Decline Stock Orders'])
    <div class="container-fluid py-4">
        <div class="row">
          <div class="col-12 mx-auto">
            <div class="card mb-4">
              <div class="card-header pb-0">
                  <div class="d-flex align-items-center">
                  <h6>Pending Stock Orders</h6>
                  </div>
              </div>
              <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                  <table class="table align-items-center mb-0">
                    <thead>
                      <tr>
                        <th class="text-uppercase text-secondary text-xs text-center font-weight-bolder opacity-7">Id</th>
                        <th class="text-uppercase text-secondary text-xs text-center font-weight-bolder opacity-7">Date</th>
                        <th class="text-uppercase text-secondary text-xs text-center font-weight-bolder opacity-7">Total</th>
                        <th class="text-uppercase text-secondary text-xs text-center font-weight-bolder opacity-7">Supplier</th>
                        <th class="text-uppercase text-secondary text-xs text-center font-weight-bolder opacity-7">Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($stockOrders as $order)
                      <tr>
                        <td class="text-center">
                          <p class="text-xs font-weight-bold mb-0">{{ $order->id }}</p>
                        </td>
                        <td class="text-center">
                          <p class="text-xs font-weight-bold mb-0">{{ $order->date }}</p>
                        </td>
                        <td class="text-center">
                          <p class="text-xs font-weight-bold mb-0">${{ number_format($order->total, 2) }}</p>
                        </td>
                        <td class="text-center">
                          <p class="text-xs font-weight-bold mb-0">{{ $order->supplier->name }}</p>
                        </td>
                        <td class="text-center">
                          <span class="badge badge-sm bg-gradient-success">View Order Details</span>
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
  </div>
@endsection
