@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => ''])
    <div class ="container-fluid py-4">
    <div class="row">
            <div class="col-12 mx-auto">
            <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Customer Order</h6>
                    </div>
    <div class="container mt-4">
    <button
    onclick="document.getElementById('order-form').style.display='block'"
        style="
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 8px;
            transition: background-color 0.3s ease;
        "
        onmouseover="this.style.backgroundColor='#808000'"
        onmouseout="this.style.backgroundColor='#007bff'"
    >
        ➕ Create New Order
    </button>
</div>
</div>
</div>
</div>
</div>

    <!-- Order Form Fragment -->
    <div id="order-form" style="display: none;">
        <table boarder="1" cellpadding="10" cellspacing="0" style="width: 100%; margin-bottom: 20px;">
        <thead style="background-color: rgb(230, 235, 240); color: black; font-weight: bold;">
        <tr>
            <th style="padding: 12px; border: 1px solid #ccc; font-weight: bold;">Drug Name</th>
            <th style="padding: 12px; border: 1px solid #ccc; font-weight: bold;">Unit Price (Ugx)</th>
            <th style="padding: 12px; border: 1px solid #ccc; font-weight: bold;">Quantity</th>
            <th style="padding: 12px; border: 1px solid #ccc; font-weight: bold;">Amount (Ugx)</th>
            <th style="padding: 12px; border: 1px solid #ccc; font-weight: bold;">Action</th>
        </tr>
    </thead>
            <tbody id="order-items">
                <tr>
                <td>
    <input type="text" name="drug_name[]" id="drug-name" oninput="fetchDrugSuggestions(this)" required autocomplete="off">
    <ul id="suggestions-list" style="list-style-type: none; padding: 0; margin: 0; border: 1px solid #ccc; background-color: white;"></ul>
</td>
                    <td><input type="number" name="unit_price[]" step="0.01" oninput="calculateAmount(this)" required></td>
                    <td><input type="number" name="quantity[]" oninput="calculateAmount(this)" required min="0" step="1"></td>
                    <td><input type="text" name="amount[]" readonly></td>
                    <td><button type="button" onclick="removeRow(this)">🗑️</button></td>
                </tr>
            </tbody>
        </table>

        <button type="button" onclick="addRow()">➕ Add Drug</button>

        <h4 style="margin-top: 20px;">Total Amount: <span id="total-amount">0.00</span></h4>
    </div>
</div>

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Inline Scripts -->
<script>
    function calculateAmount(elem) {
        const row = elem.parentElement.parentElement;
        const unitPrice = parseFloat(row.querySelector('input[name="unit_price[]"]').value) || 0;
        const quantity = parseInt(row.querySelector('input[name="quantity[]"]').value) || 0;
        const amount = unitPrice * quantity;
        row.querySelector('input[name="amount[]"]').value = amount.toFixed(2);
        updateTotal();
    }

    function updateTotal() {
        let total = 0;
        document.querySelectorAll('input[name="amount[]"]').forEach(input => {
            total += parseFloat(input.value) || 0;
        });
        document.getElementById('total-amount').innerText = total.toFixed(2);
    }

    function addRow() {
        const tbody = document.getElementById('order-items');
        const newRow = tbody.rows[0].cloneNode(true);
        newRow.querySelectorAll('input').forEach(input => input.value = '');
        tbody.appendChild(newRow);
    }

    function removeRow(button) {
        const row = button.parentElement.parentElement;
        const tbody = document.getElementById('order-items');
        if (tbody.rows.length > 1) {
            row.remove();
            updateTotal();
        }else {
            // If it's the last row, redirect to the dashboard
            window.location.href = "{{ route('medical-assistant.dashboard') }}";
        }
    }

    function fetchDrugSuggestions(inputElement) {
        let query = inputElement.value;

        if (query.length > 2) { // Only start searching if input has more than 2 characters
            fetch(`/fetch-drugs?query=${query}`)
                .then(response => response.json())
                .then(data => {
                    let suggestionsList = document.getElementById('suggestions-list');
                    suggestionsList.innerHTML = ''; // Clear previous suggestions

                    if (data.length > 0) {
                        data.forEach(drug => {
                            let li = document.createElement('li');
                            li.textContent = drug.name; // Assuming the drug name is in 'name'
                            li.style.cursor = 'pointer';
                            li.onclick = function() {
                                inputElement.value = drug.name; // Set the input field value to selected drug
                                suggestionsList.innerHTML = ''; // Clear suggestions
                            };
                            suggestionsList.appendChild(li);
                        });
                    } else {
                        let li = document.createElement('li');
                        li.textContent = 'No matches found';
                        suggestionsList.appendChild(li);
                    }
                });
        } else {
            document.getElementById('suggestions-list').innerHTML = ''; // Clear suggestions if less than 3 characters
        }
    }


</script>
@endsection


@endsection

