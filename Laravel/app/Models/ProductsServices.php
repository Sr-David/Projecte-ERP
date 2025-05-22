<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductsServices extends Model
{
    //
    protected $table = 'ProductsServices';
    protected $primaryKey = 'idProductService';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;
    
    protected $fillable = [
        'Name',
        'Description',
        'Price',
        'Stock',
        'EntryDate',
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
     * Obtiene todos los detalles de ventas relacionados con este producto/servicio.
     */
    public function salesDetails()
    {
        return $this->hasMany(SalesDetails::class, 'ProductServiceID', 'idProductService');
    }
}
