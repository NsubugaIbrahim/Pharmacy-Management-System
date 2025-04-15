<?php

namespace App\Http\Controllers;

use App\Models\StockEntry;
use Illuminate\Http\Request;
use App\Models\StockOrder;

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

    public function nearExpiry(){
        $oneMonthLater = now()->addMonth();
        
        $expiringDrugs = StockEntry::with('drug')
            ->where('expiry_date', '<=', $oneMonthLater)
            ->where('quantity', '>', 0)
            ->orderBy('expiry_date', 'asc')
            ->get();
        
        return view('expiry.expiry-alert', compact('expiringDrugs'));
    }


}

