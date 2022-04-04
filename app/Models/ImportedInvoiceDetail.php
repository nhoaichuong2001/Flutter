<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportedInvoiceDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'productID',
        'userID',
        'postedDate',
        'total',
        'created_at',
        'updated_at',
    ];
}
