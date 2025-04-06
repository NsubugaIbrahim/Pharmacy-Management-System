<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Drug;
use App\Models\Supplier;
use App\Models\Sale;

class DrugController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('role:admin,pharmacist');
    // }

    public function index()
    {
        $drugs = Drug::all();
        return view('drugs.index', compact('drugs'));
    }
    public function stockForm()
    {
        $suppliers = Supplier::all();
        return view('drugs.stock', compact('suppliers'));
    }

    public function storeStock(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'quantity' => 'required|integer|min:1',
            'supply_price' => 'required|numeric|min:0',
            'supplier_id' => 'required|exists:suppliers,id'
        ]);

        Drug::create($request->all());

        return redirect()->route('drugs.stock')->with('success', 'Drug stocked successfully.');
    }

    public function setSellingPriceForm()
    {
        $drugs = Drug::whereNull('selling_price')->get();
        return view('drugs.set_price', compact('drugs'));
    }

    public function updateSellingPrice(Request $request, Drug $drug)
    {
        $request->validate([
            'selling_price' => 'required|numeric|min:0'
        ]);

        $drug->selling_price = $request->selling_price;
        $drug->save();

        return back()->with('success', 'Selling price updated.');
    }
}
