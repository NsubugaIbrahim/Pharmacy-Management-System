<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::insert([
            ['name' => 'admin', 'description' => 'Administrator'],
            ['name' => 'pharmacist', 'description' => 'Manager'],
            ['name' => 'medical-assistant', 'description' => 'Medical Assistant'],
            ['name' => 'cashier', 'description' => 'Cashier'],
            ['name' => 'accountant', 'description' => 'Accountant'],
        ]);
    }
}
