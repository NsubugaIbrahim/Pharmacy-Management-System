<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock_Order extends Model
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
        'total'
>>>>>>> 61d6a0f69527de383b732ff2a1fa5ce215775bfa
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
