<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'Notes';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idNote';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'Title',
        'Content',
        'RelatedTo',
        'RelatedID',
        'CreatedBy',
        'idEmpresa',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the related client.
     */
    public function client()
    {
        return $this->belongsTo(Client::class, 'RelatedID', 'idClient')
            ->when($this->RelatedTo === 'client');
    }

    /**
     * Get the related lead.
     */
    public function lead()
    {
        return $this->belongsTo(Lead::class, 'RelatedID', 'idLead')
            ->when($this->RelatedTo === 'lead');
    }

    /**
     * Get the related project.
     */
    public function project()
    {
        return $this->belongsTo(Project::class, 'RelatedID', 'idProject')
            ->when($this->RelatedTo === 'project');
    }

    /**
     * Get the user who created the note.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'CreatedBy', 'idUser');
    }

    /**
     * Get the company that the note belongs to.
     */
    public function company()
    {
        return $this->belongsTo(UserAdministration::class, 'idEmpresa', 'idEmpresa');
    }
} 