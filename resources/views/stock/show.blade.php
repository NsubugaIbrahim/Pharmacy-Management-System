@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Stock'])
    <div class="container-fluid py-4">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header pb-0">
                  <div class="d-flex align-items-center">
                  <h6>Inventory</h6>
                  </div>
              </div>
              <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                  <table class="table align-items-center mb-0">
                    <thead>
                      <tr>
                        <th class="text-uppercase text-secondary text-xs text-center font-weight-bolder opacity-7">Drug Name</th>
                        <th class="text-uppercase text-secondary text-xs text-center font-weight-bolder opacity-7">Available Quantity</th>
                        <th class="text-uppercase text-secondary text-xs text-center font-weight-bolder opacity-7">Unit Price</th>
                        <th class="text-uppercase text-secondary text-xs text-center font-weight-bolder opacity-7">Closest Expiry Date</th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse($inventory as $item)
                      <tr>
                          <td class="text-center">
                              <p class="text-xs font-weight-bold mb-0">{{ $item->name }}</p>
                          </td>
                          <td class="text-center">
                              <p class="text-xs font-weight-bold mb-0">{{ $item->total_quantity }}</p>
                          </td>
                          <td class="text-center">
                              <p class="text-xs font-weight-bold mb-0">{{ number_format($item->selling_price) }}</p>
                          </td>
                          <td class="text-center">
                              <p class="text-xs font-weight-bold mb-0">{{ $item->closest_expiry_date }}</p>
                          </td>
                      </tr>
                      @empty
                      <tr>
                          <td colspan="4" class="text-center">
                              <p class="text-xs font-weight-bold mb-0">No inventory data available</p>
                          </td>
                      </tr>
                      @endforelse
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