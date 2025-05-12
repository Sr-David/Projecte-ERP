<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clients extends Model
{
    protected $table = 'clients';
    protected $fillable = [
        'Name',
        'LastName',
        'Email',
        'Phone',
        'Address',
        'ClientType_ID'
    ];
}
