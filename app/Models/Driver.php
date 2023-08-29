<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;
    protected $fillable = [
        'username',
        'driver_name',
        'region',
        'postal_code',
        'address',
        'unit_code',
        'driver_file',
        'dob',
        'password',
        'mobile_number',
        'phone_number',
        'fax',
        'email',
        'vehicle_id',
        'license_plate',
        'email',
        'created_by',
        'company_id'
    ];

    protected $primaryKey  = 'driver_id';
}
