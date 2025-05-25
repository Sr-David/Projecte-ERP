<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'Clients';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idClient';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'Name',
        'LastName',
        'Email',
        'Phone',
        'Address',
        'ClientTypeID',
        'idEmpresa',
    ];

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'CreatedAt';

    /**
     * The name of the "updated at" column.
     *
     * @var string
     */
    const UPDATED_AT = 'UpdatedAt';

    /**
     * Get the client type that owns the client.
     */
    public function clientType()
    {
        return $this->belongsTo(ClientType::class, 'ClientTypeID', 'idClientType');
    }

    /**
     * Get the projects for the client.
     */
    public function projects()
    {
        return $this->hasMany(Project::class, 'ClientID', 'idClient');
    }

    /**
     * Get the notes for the client.
     */
    public function notes()
    {
        return $this->hasMany(Note::class, 'RelatedID')
            ->where('RelatedTo', 'client');
    }
} 