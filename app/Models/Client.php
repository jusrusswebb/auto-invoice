<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'name', 'email', 'payroll_fee', 'book_rate', 'is_book_flat_rate',
    ];

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}