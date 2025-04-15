<?php

namespace App\Http\Controllers;

use App\Models\StockEntry;
use Illuminate\Http\Request;
use App\Models\Inventory;

use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
{
    public function updatePrice(Request $request, $drugId)
    {
        // Validate the request
        $request->validate([
            'selling_price' => 'required|numeric|min:0',
        ]);

        // Update the selling price for all inventory items of this drug
        DB::table('inventories')
            ->where('drug_id', $drugId)
            ->update(['selling_price' => $request->selling_price]);

        return redirect()->route('stock.show')
            ->with('success', 'Drug price updated successfully');
    }

    public function getSellingPrice($drugId)
    {
        // Get the most recent inventory record (can customize based on logic)
        $inventory = \App\Models\Inventory::where('drug_id', $drugId)
            ->where('quantity', '>', 0)
            ->orderBy('expiry_date') // Optional: choose closest expiry
            ->first();

        if ($inventory) {
            return response()->json(['selling_price' => $inventory->selling_price]);
        }

        return response()->json(['selling_price' => 0], 404);
    }

    public function nearExpiry(){
        $oneMonthLater = now()->addMonth();
        
        $expiringDrugs = StockEntry::with('drug')
            ->where('expiry_date', '<=', $oneMonthLater)
            ->where('quantity', '>', 0)
            ->orderBy('expiry_date', 'asc')
            ->get();
        
        return view('expiry.expiry-alert', compact('expiringDrugs'));
    }

    public function expiredDrugs()
    {
        $today = now();
        
        $expiredDrugs = Inventory::with('drug')
            ->where('expiry_date', '<', $today)
            ->where('quantity', '>', 0)
            ->orderBy('expiry_date', 'asc')
            ->get();
        
        return view('expiry.expired-drugs', compact('expiredDrugs'));
    }
    
    public function disposeDrug($id)
    {
        $inventory = \App\Models\Inventory::findOrFail($id);
        
        // Create a record in disposed_drugs table
        \App\Models\DisposedDrugs::create([
            'restock_id' => $inventory->restock_id,
            'drug_id' => $inventory->drug_id,
            'quantity' => $inventory->quantity,
            'expiry_date' => $inventory->expiry_date
        ]);
        
        // Update inventory to zero quantity
        $inventory->quantity = 0;
        $inventory->save();
        
        return redirect()->route('expired.drugs')
            ->with('success', 'Drug has been disposed successfully');
    }
    
    public function disposedDrugs(){
        return view('expiry.disposed-drugs');
    }
}

