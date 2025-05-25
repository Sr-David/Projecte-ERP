<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesProposals extends Model
{
    //
    protected $table = 'SalesProposals';
    protected $primaryKey = 'idSalesProposals';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'ClientID',
        'CreatedAt',
        'State',
        'Details',
        'idEmpresa'
    ];

    /**
     * Obtiene el cliente asociado a esta propuesta.
     */
    public function client()
    {
        return $this->belongsTo(Clients::class, 'ClientID', 'idClient');
    }

    /**
     * Obtiene todos los detalles de venta asociados a esta propuesta.
     */
    public function salesDetails()
    {
        return $this->hasMany(SalesDetails::class, 'ProposalID', 'idSalesProposals');
    }

    /**
     * Obtiene la empresa asociada.
     */
    public function empresa()
    {
        return $this->belongsTo(UserAdministration::class, 'idEmpresa', 'idEmpresa');
    }
}
