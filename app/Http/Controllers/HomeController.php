<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Drug;
use App\Models\Inventory;


class HomeController extends Controller
{
        /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
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

    return view('pages.dashboard', compact('todayRevenue', 'labels', 'totals', 'weeklyPatients', 'monthlyExpiredDrugs','monthlySales'));
}

}
