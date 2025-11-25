<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Controls extends Model
{
    public function risk()
    {
        return $this->belongsTo(Risk::class);
    }
}
