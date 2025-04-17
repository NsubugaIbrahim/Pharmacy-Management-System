<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Sale;
use App\Models\StockEntry;
use App\Models\DisposedDrugs;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index()
    {
        
            return view('admin.dashboard');
    }

    public function finances()
{
    // Get total revenue from sales
    $totalRevenue = Sale::sum('total_price');
    
    // Get cost of goods sold from stock entries
    $costOfGoods = StockEntry::sum('cost');

    // Get disposed drugs losses 
    $disposedDrugsLosses = DisposedDrugs::calculateTotalLosses();
    
    // Calculate profit 
    $profit = $totalRevenue - $costOfGoods - $disposedDrugsLosses;
    
    // Get monthly data for charts
    $monthlyData = Sale::selectRaw('MONTH(created_at) as month, YEAR(created_at) as year, SUM(total_price) as revenue')
        ->groupBy('year', 'month')
        ->orderBy('year')
        ->orderBy('month')
        ->get();
        
    $monthlyCosts = StockEntry::selectRaw('MONTH(created_at) as month, YEAR(created_at) as year, SUM(cost) as costs')
        ->groupBy('year', 'month')
        ->orderBy('year')
        ->orderBy('month')
        ->get();
    
    // Format data for charts
    $labels = [];
    $revenueData = [];
    $costData = [];
    $profitData = [];
    
    foreach ($monthlyData as $data) {
        $monthName = date('M Y', mktime(0, 0, 0, $data->month, 1, $data->year));
        $labels[] = $monthName;
        $revenueData[] = $data->revenue;
        
        // Find matching cost data
        $cost = $monthlyCosts->where('month', $data->month)
                            ->where('year', $data->year)
                            ->first();
        $costAmount = $cost ? $cost->costs : 0;
        
        // Find matching disposed drugs losses for this month using a modified version of calculateTotalLosses
        $disposedLosses = DB::table('disposed_drugs')
            ->leftJoin(DB::raw('(SELECT drug_id, MAX(selling_price) as max_price FROM inventories GROUP BY drug_id) as inv'), 
                  'disposed_drugs.drug_id', '=', 'inv.drug_id')
            ->whereRaw('MONTH(disposed_drugs.created_at) = ? AND YEAR(disposed_drugs.created_at) = ?', [$data->month, $data->year])
            ->selectRaw('SUM(disposed_drugs.quantity * COALESCE(inv.max_price, 0)) as total_losses')
            ->value('total_losses') ?? 0;
        
        // Add disposed drugs losses to the cost amount
        $costAmount += $disposedLosses;
        $costData[] = $costAmount;
        
        // Calculate monthly profit (now including disposed drugs losses)
        $profitData[] = $data->revenue - $costAmount;
    }


    
    return view('admin.finances', compact(
        'totalRevenue', 
        'costOfGoods', 
        'profit',
        'labels',
        'revenueData',
        'costData',
        'profitData',
        'disposedDrugsLosses'
    ));
}

}
