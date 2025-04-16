<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\StockEntry;
use App\Models\DisposedDrugs;

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
        $costData[] = $costAmount;
        
        // Calculate monthly profit
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
