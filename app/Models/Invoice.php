<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use App\Models\Service; 

class Invoice extends Model
{

    protected $fillable = [
        'client_id',
        'invoice_number',
        'invoice_date',
        'billing_address',
        'total_amount',
    ];

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    public function client()
{
    return $this->belongsTo(Client::class, 'client_id');
}
}