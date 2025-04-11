<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'drug_id',
        'quantity',
        'selling_price',
        'sold_at',
        'customer_name',
    ];

    public function drug()
    {
        return $this->belongsTo(Drug::class);
    }
}
