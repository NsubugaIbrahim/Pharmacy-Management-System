<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Sale;
use App\Models\StockEntry;
use App\Models\DisposedDrugs;
use App\Models\Inventory;
use Illuminate\Support\Carbon;

class AdminController extends Controller
{
    public function index()
{
    $todayRevenue = Sale::whereDate('created_at', Carbon::today())
                        ->sum('total_price');

    $startOfMonth = Carbon::now()->startOfMonth();
    $endOfMonth = Carbon::now()->endOfMonth();

    $dailySales = Sale::select(
                        DB::raw('DATE(created_at) as date'),
                        DB::raw('SUM(total_price) as total')
                    )
                    ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                    ->groupBy('date')
                    ->orderBy('date')
                    ->get();

    // Prepare chart data
    $daysInMonth = $startOfMonth->daysInMonth;
    $labels = [];
    $totals = [];

    for ($i = 1; $i <= $daysInMonth; $i++) {
        $date = Carbon::createFromDate(null, null, $i)->format('Y-m-d');
        $labels[] = Carbon::createFromDate(null, null, $i)->format('d M');
        $daySale = $dailySales->firstWhere('date', $date);
        $totals[] = $daySale ? $daySale->total : 0;
    }

    $weeklyPatients = Sale::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                        ->distinct('customer_name')
                        ->count('customer_name');

    $monthlyExpiredDrugs = Inventory::where('expiry_date', '<', Carbon::now())
                        ->count('drug_id');

    $monthlySales = Sale::where('created_at', '>=', Carbon::now()->startOfMonth())
                    ->sum('total_price');

    // Get top 4 selling drugs by quantity
    $topSellingDrugs = Sale::select('drug_id')
    ->selectRaw('SUM(quantity) as total_quantity')
    ->selectRaw('SUM(total_price) as total_revenue')
    ->selectRaw('MAX(created_at) as latest_sale')
    ->with('drug') // Eager load the drug relationship
    ->groupBy('drug_id')
    ->orderByDesc('total_quantity')
    ->limit(4)
    ->get();

    // Format the latest_sale date
    $topSellingDrugs->each(function ($sale) {
        $sale->latest_sale = Carbon::parse($sale->latest_sale);
    });

    $todayRevenue = Sale::whereDate('created_at', Carbon::today())
    ->sum('total_price');

    $monthlyExpiredDrugs = Inventory::where('expiry_date', '<', Carbon::now())
                        ->count('drug_id');
    
    // Add this new query to fetch expired drugs with details
    $expiredDrugs = Inventory::where('expiry_date', '<', Carbon::now())
                    ->with('drug') // Assuming you have a relationship set up
                    ->orderBy('expiry_date')
                    ->limit(5) // Show only 5 expired drugs
                    ->get();

    $soonExpiringDrugs = Inventory::whereBetween('expiry_date', [
                        Carbon::now(), 
                        Carbon::now()->addMonth()
                    ])
                    ->with('drug') // Eager load the drug relationship
                    ->orderBy('expiry_date')
                    ->limit(4) // Show only 5 drugs
                    ->get();
                
                    $lowStockDrugs = DB::table('inventories')
    ->join('drugs', 'inventories.drug_id', '=', 'drugs.id')
    ->select('inventories.drug_id', 'drugs.name as drug_name', DB::raw('SUM(inventories.quantity) as total_quantity'))
    ->groupBy('inventories.drug_id', 'drugs.name')
    ->orderBy('total_quantity', 'asc')
    ->limit(5)
    ->get();

    return view('admin.dashboard', compact('todayRevenue', 'labels', 'totals', 'weeklyPatients', 'monthlyExpiredDrugs','monthlySales', 'topSellingDrugs', 'expiredDrugs', 'soonExpiringDrugs', 'lowStockDrugs'));
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
