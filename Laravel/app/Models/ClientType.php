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
    public $timestamps = false;
    
    protected $fillable = [
        'ClientType',
        'Description',
        'idEmpresa'
    ];

    /**
     * Obtiene la empresa asociada.
     */
    public function empresa()
    {
        return $this->belongsTo(UserAdministration::class, 'idEmpresa', 'idEmpresa');
    }

    /**
     * Obtiene todos los clientes de este tipo.
     */
    public function clients()
    {
        return $this->hasMany(Clients::class, 'ClientTypeID', 'idClientType');
    }
}
