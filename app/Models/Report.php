<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
        'title', 'content', 'patient_id', 'radiologist_id'
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function radiologist()
    {
        return $this->belongsTo(User::class, 'radiologist_id');
    }
}

