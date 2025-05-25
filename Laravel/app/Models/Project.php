<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'Projects';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idProject';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'Name',
        'Description',
        'ClientID',
        'StartDate',
        'EndDate',
        'Status',
        'Budget',
        'BillingType',
        'Notes',
        'idEmpresa',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'StartDate' => 'date',
        'EndDate' => 'date',
        'Budget' => 'decimal:2',
        'CreatedAt' => 'datetime',
        'UpdatedAt' => 'datetime',
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'Status' => 'Pending',
        'BillingType' => 'Fixed',
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
     * Get the client that owns the project.
     */
    public function client()
    {
        return $this->belongsTo(Client::class, 'ClientID', 'idClient');
    }

    /**
     * Get the notes for the project.
     */
    public function notes()
    {
        return $this->hasMany(Note::class, 'RelatedID')
            ->where('RelatedTo', 'project');
    }
} 