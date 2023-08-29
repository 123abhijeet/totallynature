<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    use HasFactory;
    protected $fillable = [
        'customer_id',
        'quotation_number',
        'invoice_address',
        'delivery_address',
        'order_date',
        'due_date',
        'tax',
        'tax_inclusive',
        'payment_type',
        'payment_terms',
        'sales_person',
        'remark',
        'untaxted_amount',
        'price_structure',
        'taxes',
        'net_total',
        'status',
        'tandc',
        'convert_so',
        'edit_status',
        'created_by',
        'company_id'
    ];

    protected $primaryKey  = 'quotation_id';
}
