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
     * @var array<int, string>
     */
    protected $fillable = [
        'Title',
        'Content',
        'RelatedTo',
        'RelatedID',
        'CreatedBy',
        'idEmpresa'
    ];

    /**
     * Get the user who created the note.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'CreatedBy', 'idUser');
    }

    /**
     * Get the related model based on the RelatedTo field.
     */
    public function related()
    {
        switch ($this->RelatedTo) {
            case 'client':
                return $this->belongsTo(Clients::class, 'RelatedID', 'idClient');
            case 'lead':
                return $this->belongsTo(Lead::class, 'RelatedID', 'idLead');
            case 'project':
                return $this->belongsTo(Project::class, 'RelatedID', 'idProject');
            case 'sale':
                return $this->belongsTo(SalesProposal::class, 'RelatedID', 'idSalesProposals');
            default:
                return null;
        }
    }

    /**
     * Get the company that the note belongs to.
     */
    public function company()
    {
        return $this->belongsTo(UserAdministration::class, 'idEmpresa', 'idEmpresa');
    }
} 