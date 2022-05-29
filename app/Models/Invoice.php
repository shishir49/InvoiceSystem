<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'company_name', 'company_address', 'compay_phone', 'customer_name', 'customer_phone', 'customer_address', 'gross_total', 'vat', 'tax', 'status'];
}
