<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductsServices extends Model
{
    use HasFactory;

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

    // Cast price to decimal
    protected $casts = [
        'Price' => 'decimal:2',
        'EntryDate' => 'datetime',
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
