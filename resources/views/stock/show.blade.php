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
                        <th class="text-uppercase text-secondary text-xs text-center font-weight-bolder opacity-7">Quantity</th>
                        <th class="text-uppercase text-secondary text-xs text-center font-weight-bolder opacity-7">Unit Price</th>
                        <th class="text-uppercase text-secondary text-xs text-center font-weight-bolder opacity-7">Closest Expiry Date</th>
                        <th class="text-uppercase text-secondary text-xs text-center font-weight-bolder opacity-7">Actions</th>
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
                          <td class="text-center">
                              <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editPriceModal{{ $item->id }}">
                                  <i class="fas fa-edit"></i> Set Price
                              </button>
                              
                              <!-- Edit Price Modal -->
                              <div class="modal fade" id="editPriceModal{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="editPriceModalLabel{{ $item->id }}" aria-hidden="true">
                                  <div class="modal-dialog modal-dialog-centered" role="document">
                                      <div class="modal-content">
                                          <div class="modal-header">
                                              <h5 class="modal-title" id="editPriceModalLabel{{ $item->id }}">Update Price for {{ $item->name }}</h5>
                                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                          </div>
                                          <form action="{{ route('inventory.update-price', $item->id) }}" method="POST">
                                              @csrf
                                              @method('PUT')
                                              <div class="modal-body">
                                                  <div class="form-group">
                                                      <label for="selling_price">Selling Price</label>
                                                      <input type="number" class="form-control" id="selling_price" name="selling_price" value="{{ $item->selling_price }}" required>
                                                  </div>
                                              </div>
                                              <div class="modal-footer">
                                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                  <button type="submit" class="btn btn-primary">Update Price</button>
                                              </div>
                                          </form>
                                      </div>
                                  </div>
                              </div>
                          </td>
                      </tr>
                      @empty
                      <tr>
                          <td colspan="5" class="text-center">
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