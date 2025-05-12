<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientType extends Model
{
    //
    protected $table = 'ClientType';
    protected $fillable = [
        'ClientType',
        'Description'
    ];
}
