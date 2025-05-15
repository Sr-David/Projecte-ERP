<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clients extends Model
{
    protected $table = 'clients';
    protected $primaryKey = 'idClient';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false; // <--- Añade esta línea

    protected $fillable = [
        'Name',
        'LastName',
        'Email',
        'Phone',
        'Address',
        'ClientTypeID'
    ];
    
    /**
     * Obtiene el tipo de cliente asociado.
     */
    public function clientType()
    {
        return $this->belongsTo(ClientType::class, 'ClientTypeID', 'idClientType');
    }
}
