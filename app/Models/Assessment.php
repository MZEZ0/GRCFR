<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    use HasFactory;

    public const STATUSES = [
        'compliant',
        'partial',
        'non_compliant',
        'not_applicable',
    ];

    public const STATUS_LABELS = [
        'compliant' => 'Compliant',
        'partial' => 'Partially compliant',
        'non_compliant' => 'Non-compliant',
        'not_applicable' => 'Not applicable',
    ];

    protected $fillable = [
        'company_id',
        'user_id',
        'policy_id',
        'status',
        'notes',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function policy()
    {
        return $this->belongsTo(Policy::class);
    }

    public function evidenceFiles()
    {
        return $this->hasMany(EvidenceFile::class);
    }
}
