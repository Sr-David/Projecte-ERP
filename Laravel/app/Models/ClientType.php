<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientType extends Model
{
    //
    protected $table = 'ClientType';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $primaryKey = 'idClientType';
    protected $fillable = [
        'ClientType',
        'Description'
    ];
}
