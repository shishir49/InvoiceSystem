<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = ['customer_id', 'gross_total', 'vat', 'tax', 'status'];

    public function invoiceProducts() {
        return $this->hasMany('App\Models\InvoiceProduct', 'invoice_id');
    }

    public function customers() {
        return $this->belongsTo('App\Models\Customer', 'customer_id');
    }
}
