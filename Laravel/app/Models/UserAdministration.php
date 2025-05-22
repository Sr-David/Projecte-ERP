<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAdministration extends Model
{
    //
    protected $table = 'UserAdministration';
    protected $primaryKey = 'idEmpresa';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;
    
    protected $fillable = [
        'Name',
        'CompanyInfo',
        'CreatedAt',
        'UpdatedAt'
    ];

    /**
     * Obtiene todos los usuarios asociados a esta empresa.
     */
    public function users()
    {
        return $this->hasMany(User::class, 'idEmpresa', 'idEmpresa');
    }

    /**
     * Obtiene todos los clientes asociados a esta empresa.
     */
    public function clients()
    {
        return $this->hasMany(Clients::class, 'idEmpresa', 'idEmpresa');
    }

    /**
     * Obtiene todos los tipos de cliente asociados a esta empresa.
     */
    public function clientTypes()
    {
        return $this->hasMany(ClientType::class, 'idEmpresa', 'idEmpresa');
    }

    /**
     * Obtiene todos los productos y servicios asociados a esta empresa.
     */
    public function productsServices()
    {
        return $this->hasMany(ProductsServices::class, 'idEmpresa', 'idEmpresa');
    }
}
