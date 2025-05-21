<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesDetails extends Model
{
    //
    protected $table = 'SalesDetails';
    protected $primaryKey = 'idSaleDetail'; // <--- Añade esto
    protected $fillable = [
        'ProposalID',
        'ProductServiceID',
        'QuantitySold',
        'UnitPrice'
    ];

    public function client()
    {
        return $this->belongsTo(\App\Models\Clients::class, 'ClientID');
    }
}
