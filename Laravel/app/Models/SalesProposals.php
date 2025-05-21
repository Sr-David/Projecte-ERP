<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesProposals extends Model
{
    //
    protected $table = 'SalesProposals';
    protected $primaryKey = 'idSalesProposals'; // <--- Añade esto

    protected $fillable = [
        'ClientID',
        'CreatedAt',
        'State',
        'Details'
    ];

    public function client()
    {
        return $this->belongsTo(\App\Models\Clients::class, 'ClientID');
    }

}
