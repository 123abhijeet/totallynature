<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotationproduct extends Model
{
    use HasFactory;
    protected $fillable = [
        'quotation_id',
        'product_id',
        'product_unique_id',
        'quotation_number',
        'batch_code',
        'description',
        'uom',
        'quantity',
        'variant',
        'category',
        'unit_price',
        'amount',
        'convert_so',
        'created_by',
        'company_id'
    ];
}
