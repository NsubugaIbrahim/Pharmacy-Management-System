<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stocks = [
            ['drug_id' => 1, 'supplier_id' => 1, 'quantity' => 78, 'supply_price' => 1.50, 'selling_price' => 2.00,'created_at' => now(), 'updated_at' => now()],
            ['drug_id' => 2, 'supplier_id' => 2, 'quantity' => 66, 'supply_price' => 2.00, 'selling_price' => 2.50,'created_at' => now(), 'updated_at' => now()],
            ['drug_id' => 3, 'supplier_id' => 3, 'quantity' => 45, 'supply_price' => 3.00, 'selling_price' => 4.00,'created_at' => now(), 'updated_at' => now()],
            ['drug_id' => 4, 'supplier_id' => 1, 'quantity' => 45, 'supply_price' => 2.50, 'selling_price' => 3.20,'created_at' => now(), 'updated_at' => now()],
            ['drug_id' => 5, 'supplier_id' => 2, 'quantity' => 34, 'supply_price' => 4.00, 'selling_price' => 5.00,'created_at' => now(), 'updated_at' => now()],
            ['drug_id' => 6, 'supplier_id' => 3, 'quantity' => 46, 'supply_price' => 5.00, 'selling_price' => 6.00,'created_at' => now(), 'updated_at' => now()],
            ['drug_id' => 7, 'supplier_id' => 1, 'quantity' => 32, 'supply_price' => 6.00, 'selling_price' => 7.00,'created_at' => now(), 'updated_at' => now()],
            ['drug_id' => 8, 'supplier_id' => 2, 'quantity' => 281, 'supply_price' => 7.00, 'selling_price' => 8.00,'created_at' => now(), 'updated_at' => now()],
            ['drug_id' => 9, 'supplier_id' => 3, 'quantity' => 89, 'supply_price' => 8.00, 'selling_price' => 9.00,'created_at' => now(), 'updated_at' => now()],
            ['drug_id' => 10, 'supplier_id' => 1, 'quantity' => 64, 'supply_price' => 9.00, 'selling_price' => 10.00,'created_at' => now(), 'updated_at' => now()],
        ];

        foreach ($stocks as $stock) {
            DB::table('stock_entries')->insert(array_merge($stock, ['created_at' => now(), 'updated_at' => now()]));
        }
    }
}
// Compare this snippet from database/seeders/SupplierSeeder.php: