<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $table = 'Leads';
    protected $primaryKey = 'idLead';
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
        'Source',
        'Status',
        'Notes',
        'CreatedAt',
        'UpdatedAt',
        'AssignedToID',
        'idEmpresa'
    ];

    /**
     * Obtiene el tipo de cliente asociado.
     */
    public function clientType()
    {
        return $this->belongsTo(ClientType::class, 'ClientTypeID', 'idClientType');
    }

    /**
     * Obtiene el usuario asignado.
     */
    public function assignedTo()
    {
        return $this->belongsTo(UserAdministration::class, 'AssignedToID', 'idEmpresa');
    }

    /**
     * Obtiene la empresa asociada.
     */
    public function empresa()
    {
        return $this->belongsTo(UserAdministration::class, 'idEmpresa', 'idEmpresa');
    }
} 