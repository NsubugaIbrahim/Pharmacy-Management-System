@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])
@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Stock Inventory'])
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12 mx-auto">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Stock Inventory</h6>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        
                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Fill in details only for the drugs you want to restock. Empty rows will be ignored.
                        </div>

                        <div class="d-flex align-items-center gap-2 mb-3">
                            <form method="POST" action="{{ route('stock_orders.store') }}" id="restock-form">
                                @csrf
                                <div class="mb-3">
                                    <label for="supplier" class="form-label">Select Supplier</label>
                                    <select name="supplier_id" id="supplier" class="form-select" style="width: 100%;" required>
                                        <option value="">-- Select Supplier --</option>
                                        @foreach($suppliers as $supplier)
                                            <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="date" class="form-label">Restock Date</label>
                                    <input type="date" id="date" name="date" class="form-control" required>
                                </div>
                                
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Drug</th>
                                                <th>Quantity</th>
                                                <th>Price</th>
                                                <th>Expiry Date</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($drugs as $index => $drug)
                                            <tr class="drug-row">
                                                <td>
                                                    <strong>{{ $drug->name }}</strong>
                                                    <input type="hidden" name="entries[{{ $index }}][drug_id]" value="{{ $drug->id }}" class="drug-id">
                                                </td>
                                                <td>
                                                    <input type="number" name="entries[{{ $index }}][quantity]" class="form-control quantity-field" min="1">
                                                </td>
                                                <td>
                                                    <input type="number" name="entries[{{ $index }}][price]" step="0.01" min="0.01" class="form-control price-field">
                                                </td>
                                                <td>
                                                    <input type="date" name="entries[{{ $index }}][expiry_date]" class="form-control expiry-field">
                                                </td>
                                                <td class="row-status">
                                                    <span class="badge bg-secondary">Not selected</span>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                
                                <div class="mt-3">
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-save me-2"></i> Submit Restock
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- JavaScript to handle form submission --}}
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const form = document.getElementById('restock-form');
                const rows = document.querySelectorAll('.drug-row');
                
                // Update row status when any field changes
                rows.forEach(row => {
                    const quantityField = row.querySelector('.quantity-field');
                    const priceField = row.querySelector('.price-field');
                    const expiryField = row.querySelector('.expiry-field');
                    const statusBadge = row.querySelector('.row-status .badge');
                    
                    const updateRowStatus = () => {
                        const quantity = quantityField.value.trim();
                        const price = priceField.value.trim();
                        const expiry = expiryField.value.trim();
                        
                        if (quantity && price && expiry) {
                            statusBadge.className = 'badge bg-success';
                            statusBadge.textContent = 'Will be restocked';
                            row.classList.add('table-success');
                        } else if (quantity || price || expiry) {
                            statusBadge.className = 'badge bg-warning';
                            statusBadge.textContent = 'Incomplete';
                            row.classList.add('table-warning');
                            row.classList.remove('table-success');
                        } else {
                            statusBadge.className = 'badge bg-secondary';
                            statusBadge.textContent = 'Not selected';
                            row.classList.remove('table-success', 'table-warning');
                        }
                    };
                    
                    // Add event listeners to update status
                    quantityField.addEventListener('input', updateRowStatus);
                    priceField.addEventListener('input', updateRowStatus);
                    expiryField.addEventListener('input', updateRowStatus);
                });
                
                // Form submission handler
                form.addEventListener('submit', function(e) {
                    e.preventDefault(); // Temporarily prevent submission
                    
                    // Disable empty rows before submitting
                    let hasFilledRow = false;
                    
                    rows.forEach(row => {
                        const quantityField = row.querySelector('.quantity-field');
                        const priceField = row.querySelector('.price-field');
                        const expiryField = row.querySelector('.expiry-field');
                        
                        const quantity = quantityField.value.trim();
                        const price = priceField.value.trim();
                        const expiry = expiryField.value.trim();
                        
                        // If any field is filled but not all, show warning
                        if ((quantity || price || expiry) && !(quantity && price && expiry)) {
                            e.preventDefault();
                            alert('Please complete all fields for the drugs you want to restock.');
                            return;
                        }
                        
                        // If all fields are filled, count as valid row
                        if (quantity && price && expiry) {
                            hasFilledRow = true;
                        } else {
                            // Disable empty rows so they don't get submitted
                            row.querySelectorAll('input').forEach(input => {
                                input.disabled = true;
                            });
                        }
                    });
                    
                    if (!hasFilledRow) {
                        alert('Please fill in details for at least one drug to restock.');
                        return;
                    }
                    
                    // Submit the form if validation passes
                    this.submit();
                });
            });
        </script>
                
        @include('layouts.footers.auth.footer')
    </div>
@endsection
