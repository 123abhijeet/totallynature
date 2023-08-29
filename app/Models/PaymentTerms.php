<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentTerms extends Model
{
    use HasFactory;
    protected $fillable = [
        'payment_term_id',
        'payment_term',
        'created_by',
        'company_id'
    ];

}
