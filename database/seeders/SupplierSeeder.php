<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('suppliers')->insert([
            ['name' => 'Medix Corp', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'PharmaLife Ltd', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Global Meds Inc', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
