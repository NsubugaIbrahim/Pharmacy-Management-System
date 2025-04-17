<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Drug;

class MedicalAssistantController extends Controller
{
    public function index()
    {
        return view('medical-assistant.dashboard');
    }
    public function dashboard()
{
    return view('medical-assistant.dashboard'); // or whatever view you want to return
}

public function searchDrugs(Request $request)
{
    $query = $request->get('term');

    $drugs = Drug::where('name', 'LIKE', '%' . $query . '%')
                ->orderBy('name')
                ->limit(10)
                ->get();

    $results = [];

    foreach ($drugs as $drug) {
        $results[] = ['id' => $drug->id, 'value' => $drug->name];
    }

    return response()->json($results);
}
public function getDrugPrice(Request $request)
{
    $drugName = $request->get('name');

    $drug = Drug::where('name', $drugName)->first();

    if ($drug && $drug->inventory) {
        return response()->json([
            'price' => $drug->inventory->selling_price
        ]);
    } else {
        return response()->json(['price' => null]);
    }
}
}
