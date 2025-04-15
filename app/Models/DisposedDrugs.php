<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DisposedDrugs extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'restock_id',
        'drug_id',
        'quantity',
        'expiry_date'
    ];
    
    public function drug()
    {
        return $this->belongsTo(Drug::class);
    }
    
    public function stockOrder()
    {
        return $this->belongsTo(StockOrder::class, 'restock_id');
    }
}
