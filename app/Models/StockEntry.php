<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockEntry extends Model
{
    use HasFactory;

    protected $table = 'stock__entries';

    protected $fillable = [
        'restock_id',
        'drug_id',
        'quantity',
        'price',
        'cost'
    ];

    public function drug() {
        return $this->belongsTo(Drug::class);
    }
    
    public function stockOrder() {
        return $this->belongsTo(Stock_Order::class, 'restock_id');
    }
}
