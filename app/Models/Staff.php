<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $fillable = ['name', 'email', 'phone', 'hospital_id'];

    public function hospital()
    {
        return $this->belongsTo(Hospital::class);
    }
}
