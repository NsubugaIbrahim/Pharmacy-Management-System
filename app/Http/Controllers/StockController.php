<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StockEntry;
use App\Models\Drug;
use App\Models\Supplier;

class StockController extends Controller
{
    public function index()
    {
        // Fetch all stock entries with their associated drugs and suppliers
        $stockEntries = StockEntry::with(['drug', 'supplier'])->get();

        // Return the view with the stock entries
        return view('stock.index', compact('stockEntries'));
    }

    //View Inventory Stock page
    public function inventory(){
        $drugs = Drug::all();
        $suppliers = Supplier::all();
        return view('inventory-stock', compact('drugs', 'suppliers'));
    }

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
