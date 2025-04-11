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
                        <th class="text-uppercase text-secondary text-xs text-center font-weight-bolder opacity-7">Date Issued</th>
                        <th class="text-uppercase text-secondary text-xs text-center font-weight-bolder opacity-7">Total Cost (UGX)</th>
                        <th class="text-uppercase text-secondary text-xs text-center font-weight-bolder opacity-7">Supplier</th>
                        <th class="text-uppercase text-secondary text-xs text-center font-weight-bolder opacity-7">Details</th>
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
                          <p class="text-xs font-weight-bold mb-0">{{ number_format($order->total) }}</p>
                        </td>
                        <td class="text-center">
                          <p class="text-xs font-weight-bold mb-0">{{ $order->supplier->name }}</p>
                        </td>
                        <td class="text-center">
                            <span class="badge badge-sm bg-gradient-success" data-bs-toggle="modal" data-bs-target="#orderDetailsModal{{ $order->id }}" style="cursor: pointer;">View Order Details</span>
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                  <!-- Order Details Modal -->
                    <div class="modal fade" id="orderDetailsModal{{ $order->id }}" tabindex="-1" role="dialog" aria-labelledby="orderDetailsModalLabel{{ $order->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title text-success" id="orderDetailsModalLabel{{ $order->id }}">Restock Order #{{ $order->id }}</h5> <hr>
                            <h5 class="modal-title text-danger" style="margin-left: 10px;">{{ $order->date}}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                            <div class="table-responsive">
                                <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Drug</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Quantity</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Unit Price</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Total Cost</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->stockEntries as $entry)
                                    <tr>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $entry->drug->name ?? 'N/A' }}</h6>
                                            </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $entry->quantity }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ number_format($entry->price) }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ number_format($entry->cost) }}</p>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                </table>
                            </div>
                            </div>
                            <div class="modal-footer">
                                <div class="ms-3 fw-bold" style = "margin-right:30px">
                                    Total Amount: UGX  <span class="text-primary">{{ number_format($order->total) }}</span>
                                </div>
                            <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    @include('layouts.footers.auth.footer')
  </div>
@endsection
