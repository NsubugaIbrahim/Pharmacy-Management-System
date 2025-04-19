<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Drug;
use App\Models\Sale;
use App\Models\Inventory;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{

    public function show()
    {
        $sales = Sale::with('drug')->latest()->get();
        return view('sales.show', compact('sales'));
    }
    public function index()
    {
        $drugs = Drug::all();
        return view('sales.index', ['drugs' => $drugs]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'drug_id' => 'required|exists:drugs,id',
            'quantity' => 'required|integer|min:1',
            'selling_price' => 'required|numeric|min:0',
        ]);

        $drug = \App\Models\Drug::findOrFail($request->drug_id);

        // Check available stock
        $available = \App\Models\Inventory::where('drug_id', $drug->id)->sum('quantity');
        $sold = \App\Models\Sale::where('drug_id', $drug->id)->sum('quantity');
        $remaining = $available - $sold;

        if ($remaining < $request->quantity) {
            return back()->with('error', 'Not enough stock for ' . $drug->name);
        }

        // Add to session cart
        $cart = session()->get('cart', []);
        $cart[] = [
            'drug_id' => $drug->id,
            'drug_name' => $drug->name,
            'quantity' => $request->quantity,
            'selling_price' => $request->selling_price,
        ];
        session()->put('cart', $cart);

        return back()->with('success', $drug->name . ' added to cart!');
    }

    public function removeFromCart($index)
    {
        $cart = session()->get('cart', []);
        unset($cart[$index]);
        session(['cart' => array_values($cart)]); // reindex

        return redirect()->back()->with('success', 'Item removed from cart');
    }

    public function finalizeSale(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255'
        ]);

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return back()->with('error', 'Cart is empty!');
        }

        $receipt_number = 'RCPT-' . strtoupper(uniqid());

        DB::beginTransaction();

        try {
            foreach ($cart as $item) {
                $drugId = $item['drug_id'];
                $neededQty = $item['quantity'];

                // Get stock entries for this drug, FIFO style (oldest first)
                $entries = Inventory::where('drug_id', $drugId)
                ->where('quantity', '>', 0)
                ->orderBy('expiry_date') // or created_at if preferred
                ->get();


                foreach ($entries as $entry) {
                    if ($neededQty <= 0) break;

                    $availableQty = $entry->quantity;

                    if ($availableQty >= $neededQty) {
                        $entry->quantity -= $neededQty;
                        $entry->save();
                        $neededQty = 0;
                    } else {
                        $neededQty -= $availableQty;
                        $entry->quantity = 0;
                        $entry->save();
                    }
                }

                if ($neededQty > 0) {
                    DB::rollBack();
                    return back()->with('error', 'Not enough stock for ' . $item['drug_name']);
                }

                // Save the sale
                Sale::create([
                    'drug_id' => $drugId,
                    'quantity' => $item['quantity'],
                    'selling_price' => $item['selling_price'],
                    'customer_name' => $request->customer_name,
                    'receipt_number' => $receipt_number,
                    'total_price' => $item['selling_price'] * $item['quantity'], // ✅ Add this
                ]);

                
            }

            // Save receipt data
            session(['receipt_data' => [
                'customer_name' => $request->customer_name,
                'receipt_number' => $receipt_number,
                'items' => $cart,
                'total' => array_sum(array_map(fn($i) => $i['selling_price'] * $i['quantity'], $cart))
            ]]);

            session()->forget('cart');
            DB::commit();

            return view('sales.receipt', ['receiptData' => session('receipt_data')]);
            

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Sale failed: ' . $e->getMessage());
        }
    }

    public function receipt()
    {
        $receiptData = session('receipt_data');
        if (!$receiptData) {
            return redirect()->route('sales.index')->with('error', 'No receipt to show.');
        }

        return view('sales.receipt', ['data' => $receiptData]);
    }

    public function getSellingPrice($drugId)
    {
        $inventory = \App\Models\Inventory::where('drug_id', $drugId)
            ->orderBy('expiry_date', 'asc')
            ->first();

        return response()->json([
            'selling_price' => $inventory ? $inventory->selling_price : null,
        ]);
    }

    public function salesHistory()
    {
        $sales = Sale::orderBy('created_at', 'desc')->paginate(10);
        return view('sales.history', compact('sales'));
    }
    
    public function viewReceiptByNumber($receipt_number)
    {
        $sales = Sale::where('receipt_number', $receipt_number)->with('drug')->get();

        if ($sales->isEmpty()) {
            return redirect()->route('sales.history')->with('error', 'Receipt not found.');
        }

        $customer_name = $sales->first()->customer_name;
        $total = $sales->sum('total_price');

        return view('sales.review', compact('receipt_number', 'customer_name', 'sales', 'total'));
    }


}