<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesProposals extends Model
{
    //
    protected $table = 'SalesProposals';
    protected $fillable = [
        'ClientID',
        'CreatedAt',
        'State',
        'Details'
    ];
}
