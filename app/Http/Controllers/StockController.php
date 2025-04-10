<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StockEntry;
use App\Models\Drug;
use App\Models\Supplier;
use App\Models\Stock_Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StockController extends Controller
{
    public function index()
    {
        // Fetch all stock entries with their associated drugs and suppliers
        $drugs = Drug::all();
        $suppliers = Supplier::all();

        // Return the view with the stock entries
        return view('stock.index', compact('drugs', 'suppliers'));
    }

<<<<<<< HEAD
    //View Inventory Stock page
    public function inventory(){
        $drugs = Drug::all();
        $suppliers = Supplier::all();
        return view('inventory-stock', compact('drugs', 'suppliers'));
    }
=======
    public function displayStocks(){
        return view('stocks');
    }

    //View Inventory Stock page
    // public function inventory(){
    //     $drugs = Drug::all();
    //     $suppliers = Supplier::all();
    //     return view('inventory-stock', compact('drugs', 'suppliers'));
    // }
>>>>>>> 61d6a0f69527de383b732ff2a1fa5ce215775bfa

    //Stock inventory test
    public function store_order(Request $request)
{
    // Validate the basic fields
    $request->validate([
        'supplier_id' => 'required|exists:suppliers,id',
        'date' => 'required|date',
        'entries' => 'required|array|min:1',
<<<<<<< HEAD
=======
        'total' => 'required|numeric',
>>>>>>> 61d6a0f69527de383b732ff2a1fa5ce215775bfa
    ]);
    
    // Filter out empty entries
    $validEntries = [];
    foreach ($request->entries as $entry) {
<<<<<<< HEAD
        if (!empty($entry['quantity']) && !empty($entry['price']) && !empty($entry['expiry_date'])) {
=======
        if (!empty($entry['quantity']) && !empty($entry['price'])) {
>>>>>>> 61d6a0f69527de383b732ff2a1fa5ce215775bfa
            $validEntries[] = $entry;
        }
    }
    
    // Check if we have any valid entries
    if (empty($validEntries)) {
        return redirect()->back()->with('error', 'Please fill at least one restock item.');
    }
    
    // Validate each entry
    foreach ($validEntries as $entry) {
        if (!isset($entry['drug_id']) || !isset($entry['quantity']) || 
<<<<<<< HEAD
            !isset($entry['price']) || !isset($entry['expiry_date'])) {
=======
            !isset($entry['price']) || !isset($entry['cost'])) {
>>>>>>> 61d6a0f69527de383b732ff2a1fa5ce215775bfa
            return redirect()->back()->with('error', 'Invalid entry data');
        }
    }

    try {
        DB::transaction(function () use ($request, $validEntries) {
            // Create the stock order
            $order = Stock_Order::create([
                'supplier_id' => $request->supplier_id,
                'date' => $request->date,
<<<<<<< HEAD
=======
                'total' => $request->total, // Save the total amount
>>>>>>> 61d6a0f69527de383b732ff2a1fa5ce215775bfa
            ]);

            // Create each stock entry
            foreach ($validEntries as $entry) {
                StockEntry::create([
                    'restock_id' => $order->id,
                    'drug_id' => $entry['drug_id'],
                    'quantity' => $entry['quantity'],
                    'price' => $entry['price'],
<<<<<<< HEAD
                    'expiry_date' => $entry['expiry_date'],
=======
                    'cost' => $entry['cost'],
>>>>>>> 61d6a0f69527de383b732ff2a1fa5ce215775bfa
                ]);
            }
        });
        
        return redirect()->back()->with('success', 'Stock restocked successfully!');
    } catch (\Exception $e) {
        Log::error('Stock order creation failed: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Failed to create stock order: ' . $e->getMessage());
    }
}

<<<<<<< HEAD
    
    

=======
>>>>>>> 61d6a0f69527de383b732ff2a1fa5ce215775bfa

    // Form to stock a drug
    public function create()
    {
        $drugs = Drug::all();
        $suppliers = Supplier::all();
        return view('stock.create', compact('drugs', 'suppliers'));
    }
    // Store a new stock entry
    public function store(Request $request)
    {
        $request->validate([
            'drug_id' => 'required|exists:drugs,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'quantity' => 'required|integer|min:1',
            'supply_price' => 'required|numeric|min:0',
        ]);

        StockEntry::create([
            'drug_id' => $request->drug_id,  // This refers to the drug's ID
            'supplier_id' => $request->supplier_id,
            'quantity' => $request->quantity,
            'supply_price' => $request->supply_price,
        ]);

        return redirect()->route('stock.index')->with('success', 'Stock entry created successfully.');
    }
    // Show the form for editing a stock entry
    public function edit(StockEntry $stockEntry)
    {
        $drugs = Drug::all();
        $suppliers = Supplier::all();
        return view('stock.edit', compact('stockEntry', 'drugs', 'suppliers'));
    }
    // Update a stock entry
    public function update(Request $request, StockEntry $stockEntry)
    {
        $request->validate([
            'drug_id' => 'required|exists:drugs,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'quantity' => 'required|integer|min:1',
            'supply_price' => 'required|numeric|min:0',
            
        ]);

        StockEntry::update([
            'drug_id' => $request->name,  // This refers to the drug's ID
            'supplier_id' => $request->supplier_id,
            'quantity' => $request->quantity,
            'supply_price' => $request->supply_price,
        ]);;

        return redirect()->route('stock.index')->with('success', 'Stock entry updated successfully.');
    }
    // Delete a stock entry
    public function destroy(StockEntry $stockEntry)
    {
        $stockEntry->delete();

        return redirect()->route('stock.index')->with('success', 'Stock entry deleted successfully.');
    }
}
