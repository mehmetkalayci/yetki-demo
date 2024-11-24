<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = [
        'first_name', 'last_name', 'contact_number', 'email', 'gender', 'dob', 'address',
    ];

    // Hasta ve Rapor ilişkisi (Bir hasta birden fazla rapora sahip olabilir)
    public function reports()
    {
        return $this->hasMany(Report::class);
    }
}
