<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Clients extends Model
{
    protected $table = 'Clients';
    protected $primaryKey = 'idClient';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'Name',
        'LastName',
        'Email',
        'Phone',
        'Address',
        'ClientTypeID',
        'idEmpresa',
        'CreatedAt',
        'UpdatedAt'
    ];
    
    /**
     * Sobreescribimos el método save para actualizar automáticamente UpdatedAt
     */
    public function save(array $options = []) 
    {
        if (!$this->exists && !$this->CreatedAt) {
            $this->CreatedAt = now();
        }
        
        // Siempre actualizamos UpdatedAt al guardar
        $this->UpdatedAt = now();
        
        return parent::save($options);
    }
    
    /**
     * Obtiene el tipo de cliente asociado.
     */
    public function clientType()
    {
        return $this->belongsTo(ClientType::class, 'ClientTypeID', 'idClientType');
    }

    /**
     * Obtiene la empresa asociada.
     */
    public function empresa()
    {
        return $this->belongsTo(UserAdministration::class, 'idEmpresa', 'idEmpresa');
    }
}
