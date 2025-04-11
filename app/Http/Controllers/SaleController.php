<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Drug;
use App\Models\Sale;
use App\Models\User;

class SaleController extends Controller
{
    public function index() {
        $drugs = Drug::all();
        return view('sales.index', compact('drugs'));
    }
    
    public function store(Request $request) {
        $request->validate([
            'drug_id' => 'required|exists:drugs,id',
            'quantity' => 'required|integer|min:1',
            'customer_name' => 'string|max:255',
            'selling_price' => 'required|numeric|min:0'
        ]);
    
        // Check stock availability
        $available = \App\Models\StockEntry::where('drug_id', $request->drug_id)->sum('quantity');
        $sold = \App\Models\Sale::where('drug_id', $request->drug_id)->sum('quantity');
    
        if (($available - $sold) < $request->quantity_sold) {
            return back()->with('error', 'Not enough stock to complete sale.');
        }
    
        \App\Models\Sale::create([
            'drug_id' => $request->drug_id,
            'quantity' => $request->quantity,
            'customer_name' => $request->customer_name,
            'selling_price' => $request->selling_price,
        ]);
    
        return redirect()->route('sales.index')->with('success', 'Drug sold successfully!');
    }
    
}
