<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class EvidenceFile extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'assessment_id',
        'file_path',
        'original_name',
        'uploaded_at',
    ];

    protected $casts = [
        'uploaded_at' => 'datetime',
    ];

    public function assessment()
    {
        return $this->belongsTo(Assessment::class);
    }

    public function url(): string
    {
        return Storage::url($this->file_path);
    }
}
