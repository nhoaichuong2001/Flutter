<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportedInvoice extends Model
{
    use HasFactory;
    protected $fillable = [
        'employeeID',
        'providerID',
        'postedDate',
        'total',
        'created_at',
        'updated_at',
    ];
}
