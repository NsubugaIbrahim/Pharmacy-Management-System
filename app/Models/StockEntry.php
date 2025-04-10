<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockEntry extends Model
{
    use HasFactory;

<<<<<<< HEAD
    protected $table = 'stock__entries';
=======
    protected $table = 'stock_entries';
>>>>>>> 61d6a0f69527de383b732ff2a1fa5ce215775bfa

    protected $fillable = [
        'restock_id',
        'drug_id',
        'quantity',
        'price',
<<<<<<< HEAD
        'expiry_date'
=======
        'cost'
>>>>>>> 61d6a0f69527de383b732ff2a1fa5ce215775bfa
    ];

    public function drug() {
        return $this->belongsTo(Drug::class);
    }
    
    public function stockOrder() {
        return $this->belongsTo(Stock_Order::class, 'restock_id');
    }
}
