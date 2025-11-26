<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'sector',
        'size',
        'country',
        'contact_person',
        'contact_email',
    ];

    public function assessments()
    {
        return $this->hasMany(Assessment::class);
    }
}
