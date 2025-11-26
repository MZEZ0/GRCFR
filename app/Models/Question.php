<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'policy_id',
        'text',
    ];

    public function policy()
    {
        return $this->belongsTo(Policy::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}
