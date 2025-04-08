<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('suppliers5', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('supplier5_id');
            $table->unsignedBigInteger('supplier5_name');
            $table->Integer('contact');
            $table->unsignedBigInteger('Address');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers5');
    }
};
