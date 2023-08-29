<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductInventory extends Model
{
    use HasFactory;


    protected $fillable = [
        'vendor_id',
        'price',
        'avg_price',
        'product_id'
    ];
}
