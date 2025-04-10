<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock_Order extends Model
{
    use HasFactory;

    protected $table = 'stock__orders';
    
    protected $fillable = [
        'supplier_id',
        'date',
        'total'
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
