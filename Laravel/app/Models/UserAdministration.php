<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAdministration extends Model
{
    //
    protected $table = 'UserAdministration';
    protected $fillable = [
        'Username',
        'Password',
        'Permissions'
    ];
}
