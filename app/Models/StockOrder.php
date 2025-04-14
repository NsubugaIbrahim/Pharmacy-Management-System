<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockOrder extends Model
{
    use HasFactory;

<<<<<<< HEAD
    protected $table = 'stock__orders';
    
    protected $fillable = [
        'supplier_id',
        'date'
=======
    protected $table = 'stock_orders';
    
    protected $fillable = [
        'supplier_id',
        'date',
<<<<<<< HEAD:app/Models/Stock_Order.php
        'total'
>>>>>>> 61d6a0f69527de383b732ff2a1fa5ce215775bfa
=======
        'total',
        'status',
>>>>>>> f529531b49f77a88d4b7776fac92a08ed8ba4b90:app/Models/StockOrder.php
    ];
    
    public function stockEntries()
    {
        return $this->hasMany(StockEntry::class, 'restock_id');
    }
    
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}