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
        return view('drugs.create', compact('suppliers'));
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

    public function edit($id)
    {
        // Fetch the drug from the database by its ID
        $drug = Drug::findOrFail($id);
        
        // Return the edit view with the drug data
        return view('drugs.edit', compact('drug'));
    }

    public function sell($id)
    {
        // Fetch the drug from the database by its ID
        $drug = Drug::findOrFail($id);
        
        // Logic to handle selling the drug, such as updating the stock or marking the sale
        // This is a placeholder, you should add your actual logic here
        
        return redirect()->route('drugs.index')->with('success', 'Drug sold successfully!');
    }

    public function update(Request $request, $id)
{
    // Validate the incoming request data
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'quantity' => 'required|integer|min:0',
        'unit' => 'required|string|max:100',
        'cost_price' => 'required|numeric|min:0',
        'selling_price' => 'nullable|numeric|min:0',
    ]);

    // Find the drug by its ID
    $drug = Drug::findOrFail($id);

    // Update the drug's details
    $drug->name = $validated['name'];
    $drug->description = $validated['description'];
    $drug->quantity = $validated['quantity'];
    $drug->unit = $validated['unit'];
    $drug->cost_price = $validated['cost_price'];
    $drug->selling_price = $validated['selling_price'];
    
    // Save the updated drug to the database
    $drug->save();

    // Redirect back to the drugs list with a success message
    return redirect()->route('drugs.index')->with('success', 'Drug updated successfully!');
}
}
