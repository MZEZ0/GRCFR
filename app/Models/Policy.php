<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Policy extends Model
{
    use HasFactory;

    protected $fillable = [
        'framework_id',
        'code',
        'title',
        'short_description',
    ];

    public function framework()
    {
        return $this->belongsTo(Framework::class);
    }

    public function assessments()
    {
        return $this->hasMany(Assessment::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}
