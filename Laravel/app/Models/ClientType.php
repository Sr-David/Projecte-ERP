<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientType extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ClientType';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idClientType';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ClientType',
        'Description',
        'idEmpresa',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the clients for this client type.
     */
    public function clients()
    {
        return $this->hasMany(Client::class, 'ClientTypeID', 'idClientType');
    }

    /**
     * Obtiene la empresa asociada.
     */
    public function empresa()
    {
        return $this->belongsTo(UserAdministration::class, 'idEmpresa', 'idEmpresa');
}
}
