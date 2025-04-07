<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockEntry extends Model
{
    use HasFactory;
    protected $fillable = [
        'drug_id',
        'supplier_id',
        'quantity',
        'supply_price',
    ];

    public function drug() {
        return $this->belongsTo(Drug::class);
    }
    
    public function supplier() {
        return $this->belongsTo(Supplier::class);
    }
    
}
