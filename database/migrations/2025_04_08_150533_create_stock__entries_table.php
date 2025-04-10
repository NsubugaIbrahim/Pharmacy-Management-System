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
        Schema::create('stock__entries', function (Blueprint $table) {
=======
        Schema::create('stock_entries', function (Blueprint $table) {
>>>>>>> 61d6a0f69527de383b732ff2a1fa5ce215775bfa
            $table->id();
            $table->unsignedBigInteger('restock_id');
            $table->unsignedBigInteger('drug_id');
            $table->integer('quantity');
<<<<<<< HEAD
            $table->decimal('price', 10, 2);
            $table->date('expiry_date');
            $table->timestamps();
            
            // Foreign key constraints
            $table->foreign('restock_id')->references('id')->on('stock__orders')->onDelete('cascade');
=======
            $table->integer('price');
            $table->integer('cost');
            $table->timestamps();
            
            // Foreign key constraints
            $table->foreign('restock_id')->references('id')->on('stock_orders')->onDelete('cascade');
>>>>>>> 61d6a0f69527de383b732ff2a1fa5ce215775bfa
            $table->foreign('drug_id')->references('id')->on('drugs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_entries');
    }
};


