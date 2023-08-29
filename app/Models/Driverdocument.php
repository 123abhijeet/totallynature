<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driverdocument extends Model
{
    use HasFactory;
    protected $fillable = [
        'driver_id',
        'document_title',
        'document_issue_date',
        'document_expiry_date',
        'document_file',
        'created_by',
        'company_id'
    ];
}
