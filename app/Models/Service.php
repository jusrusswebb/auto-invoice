<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{

    protected $fillable = [
        'invoice_id',
        'description',
        'hours_worked',
        'service_amount'
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}