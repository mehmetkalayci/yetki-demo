<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = ['type', 'amount', 'description', 'hospital_id'];

    public function hospital()
    {
        return $this->belongsTo(Hospital::class);
    }
}
