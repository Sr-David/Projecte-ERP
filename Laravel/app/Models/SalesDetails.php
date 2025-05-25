<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesDetails extends Model
{
    //
    protected $table = 'SalesDetails';
    protected $primaryKey = 'idSaleDetail'; // <--- Añade esto
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;
    
    protected $fillable = [
        'ProposalID',
        'ProductServiceID',
        'QuantitySold',
        'UnitPrice',
        'idEmpresa',
        'CreatedAt'
    ];

    /**
     * Obtiene la propuesta de venta asociada.
     */
    public function salesProposal()
    {
        return $this->belongsTo(SalesProposals::class, 'ProposalID', 'idSalesProposals');
    }

    /**
     * Obtiene el producto o servicio asociado.
     */
public function productService()
{
    return $this->belongsTo(\App\Models\ProductsServices::class, 'ProductServiceID', 'idProductService');
}

    /**
     * Obtiene la empresa asociada.
     */
    public function empresa()
    {
        return $this->belongsTo(UserAdministration::class, 'idEmpresa', 'idEmpresa');
    }

    public function client()
    {
        return $this->belongsTo(\App\Models\Clients::class, 'ClientID');
    }
}
