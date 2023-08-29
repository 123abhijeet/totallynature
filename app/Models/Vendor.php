<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_type',
        'vendor_image',
        'vendor_unique_id',
        'vendor_name',
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
        'bank_name',
        'bank_account_no',
        'company_id',
        'created_by'
    ];
}
