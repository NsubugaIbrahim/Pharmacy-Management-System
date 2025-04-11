<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StockEntry;
use App\Models\Drug;
use App\Models\StockOrder;

class StockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Assuming you have at least one drug and stock_order in DB
        $drugs = Drug::all();
        $stockOrders = StockOrder::all();

        if ($drugs->isEmpty() || $stockOrders->isEmpty()) {
            $this->command->warn('No drugs or stock orders found. Please seed those tables first.');
            return;
        }

        foreach ($drugs as $drug) {
            foreach ($stockOrders->random(2) as $order) {
                StockEntry::create([
                    'restock_id' => $order->id,
                    'drug_id' => $drug->id,
                    'quantity' => rand(50, 200),
                    'price' => rand(1000, 5000), // Selling price
                    'cost' => rand(500, 4000),   // Cost price
                ]);
            }
        }
    }
}
