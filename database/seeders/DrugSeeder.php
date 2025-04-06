<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DrugSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $drugs = [
            ['name' => 'Paracetamol', 'supply_price' => 1.50, 'selling_price' => 2.00, 'quantity' => 100, 'supplier_id' => 1],
            ['name' => 'Ibuprofen', 'supply_price' => 2.00, 'selling_price' => 2.50, 'quantity' => 150, 'supplier_id' => 2],
            ['name' => 'Amoxicillin', 'supply_price' => 3.00, 'selling_price' => 4.00, 'quantity' => 200, 'supplier_id' => 3],
            ['name' => 'Cough Syrup', 'supply_price' => 2.50, 'selling_price' => 3.20, 'quantity' => 80, 'supplier_id' => 1],
        ];

        foreach ($drugs as $drug) {
            DB::table('drugs')->insert(array_merge($drug, ['created_at' => now(), 'updated_at' => now()]));
        }
    }
}
