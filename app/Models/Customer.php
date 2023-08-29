<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_type',
        'customer_image',
        'customer_unique_id',
        'customer_name',
        'contact_number',
        'whatsapp_no',
        'email_id',
        'postal_code',
        'address',
        'unit_number',
        'region',
        'payment_terms',
        'payment_type',
        'credit_limit',
        'company_name',
        'office_no',
        'contact_person',
        'contact_person_no',
        'website',
        'price_structure',
        'company_id',
        'created_by'
    ];
}
