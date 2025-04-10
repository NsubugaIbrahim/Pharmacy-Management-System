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
<<<<<<< HEAD
        Schema::create('stock__orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('supplier_id');
=======
        Schema::create('stock_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('supplier_id');
            $table->integer('total');
>>>>>>> 61d6a0f69527de383b732ff2a1fa5ce215775bfa
            $table->date('date');
            $table->timestamps();
            
            // Foreign key constraint
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
<<<<<<< HEAD
        Schema::dropIfExists('stock__orders');
=======
        Schema::dropIfExists('stock_orders');
>>>>>>> 61d6a0f69527de383b732ff2a1fa5ce215775bfa
    }
};
