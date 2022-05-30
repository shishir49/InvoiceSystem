<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'phone', 'email', 'address'];

    public function invoices() {
        return $this->hasMany('App\Models\Invoice','customer_id', 'id');
    }
}
