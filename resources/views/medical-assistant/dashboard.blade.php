@extends('layouts.app')

@section('title', 'Medical Assistant Dashboard')

@section('content')
<div style="margin-top: 120px;">
<div class ="container-fluid py-4">
    <div class="row">
            <div class="col-12 mx-auto">
            <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Customer Order</h6>
                    </div>
<div class="container mt-4">

    <!-- Create Order Button -->
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
            margin-bottom: 20px;
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
                    <td><input type="text" name="drug_name[]"  required></td>
                    <td><input type="number" name="unit_price[]" step="0.01" oninput="calculateAmount(this)" required></td>
                    <td><input type="number" name="quantity[]" oninput="calculateAmount(this)" required min="0" step="1"></td>
                    <td><input type="text" name="amount[]" readonly></td>
                    <td><button type="button" onclick="removeRow(this)">🗑️</button></td>
                </tr>
            </tbody>
        </table>

        <button type="button" onclick="addRow()">➕ Add Drug</button>

        <h4 style="margin-top: 20px;">Total Amount: <span id="total-amount">0.00</span></h4>
        <button 
    type="submit" 
    style="
        background-color: lightgreen; 
        color: white; 
        padding: 10px 20px; 
        font-size: 16px; 
        border: none; 
        border-radius: 5px; 
        transition: background-color 0.3s ease;
    "
    onmouseover="this.style.backgroundColor='green';"
    onmouseout="this.style.backgroundColor='lightgreen';"
>
    💾 Save Order
</button>
    </div>
</div>

<!-- Inline Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

    //db query

    $(document).ready(function() {
    // When typing in the Drug Name field
    $('input[name="drug_name[]"]').on('keyup', function() {
        let input = $(this);
        let query = input.val();  // Get current input value

        if (query.length > 1) {
            $.ajax({
                url: "{{ route('search.drugs') }}",  // Send the request to the controller method
                type: "GET",
                data: { term: query },
                success: function(response) {
                    // Display the suggestions
                    let suggestionBox = input.next('.autocomplete-list');
                    if (suggestionBox.length === 0) {
                        suggestionBox = $('<div class="autocomplete-list"></div>').insertAfter(input);
                    }
                    suggestionBox.html(response);  // Inject the returned HTML (drug names)

                    // Handle selecting a suggestion
                    $('.autocomplete-suggestion').on('click', function() {
                        let selectedDrug = $(this).data('drug-name');
                        input.val(selectedDrug);  // Set the input value to the selected drug
                        suggestionBox.empty();  // Clear the suggestions
                    });
                }
            });
        } else {
            // Clear suggestions if input is too short
            $(this).next('.autocomplete-list').empty();
        }
    });

    // Hide the suggestions when clicking elsewhere
    $(document).click(function(e) {
        if (!$(e.target).hasClass('autocomplete-suggestion') && !$(e.target).hasClass('form-control')) {
            $('.autocomplete-list').empty();
        }
    });
});
</script>
@endsection
