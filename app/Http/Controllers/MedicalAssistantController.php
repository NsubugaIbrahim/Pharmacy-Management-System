<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
    $search = $request->input('term');

    // Querying the 'drugs' table to get matching names
    $drugs = DB::connection('pharmacy-1')
        ->table('drugs')
        ->where('name', 'LIKE', '%' . $search . '%')
        ->limit(10)  // Limit the number of results to show
        ->get();

    // Return the matching drug names as an HTML list
    $output = '';
    foreach ($drugs as $drug) {
        $output .= '<div class="autocomplete-suggestion" data-drug-name="' . $drug->name . '">' . $drug->name . '</div>';
    }

    return response()->html($output);
}
}
