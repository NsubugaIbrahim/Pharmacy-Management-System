<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Drug;
use App\Models\Sale;
use App\Models\User;

class SaleController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('role:cashier');
    // }

    public function sellForm()
    {
        $drugs = Drug::whereNotNull('selling_price')->where('quantity', '>', 0)->get();
        return view('sales.sell', compact('drugs'));
    }

    public function processSale(Request $request)
    {
        $request->validate([
            'drug_id' => 'required|exists:drugs,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $drug = Drug::find($request->drug_id);

        if ($drug->quantity < $request->quantity) {
            return back()->withErrors(['quantity' => 'Not enough stock available.']);
        }

        $total = $request->quantity * $drug->selling_price;

        Sale::create([
            'drug_id' => $drug->id,
            'quantity' => $request->quantity,
            'total_price' => $total
        ]);

        $drug->quantity -= $request->quantity;
        $drug->save();

        return back()->with('success', 'Sale processed successfully.');
    }
}
