<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StockOrder;
use App\Models\Supplier;
use Carbon\Carbon;

class StockOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure suppliers exist
        $suppliers = Supplier::all();

        if ($suppliers->isEmpty()) {
            $this->command->warn('No suppliers found. Please seed the suppliers table first.');
            return;
        }

        foreach ($suppliers as $supplier) {
            StockOrder::create([
                'supplier_id' => $supplier->id,
                'total' => rand(100000, 1000000), // Example total in UGX
                'date' => Carbon::now()->subDays(rand(1, 30)), // Random date in last month
            ]);
        }
    }
}
