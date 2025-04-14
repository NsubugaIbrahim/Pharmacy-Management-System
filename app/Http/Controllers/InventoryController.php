<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

}
