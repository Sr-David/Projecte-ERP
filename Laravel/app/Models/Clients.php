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
    
    /**
     * Obtiene el tipo de cliente asociado.
     */
    public function clientType()
    {
        return $this->belongsTo(ClientType::class, 'ClientType_ID');
    }
}
