<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SalesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sales = [
            ['drug_id' => 1, 'quantity' => 5, 'total_price' => 10.00,'created_at' => now(), 'updated_at' => now()],
            ['drug_id' => 2, 'quantity' => 3, 'total_price' => 7.50,'created_at' => now(), 'updated_at' => now()],
            ['drug_id' => 3, 'quantity' => 2, 'total_price' => 8.00,'created_at' => now(), 'updated_at' => now()],
            ['drug_id' => 1, 'quantity' => 10, 'total_price' => 20.00,'created_at' => now(), 'updated_at' => now()],
        ];

        foreach ($sales as $sale) {
            DB::table('sales')->insert(array_merge($sale, ['created_at' => now(), 'updated_at' => now()]));
        }
    }
}
