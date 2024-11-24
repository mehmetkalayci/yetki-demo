<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Hospital extends Model
{
    protected $fillable = [
        'name',
        'address',
        'phone',
        'email'
    ];

    public function devices()
    {
        return $this->hasMany(Device::class);
    }

    public function staff()
    {
        return $this->hasMany(Staff::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function modelPermissions(): MorphMany
    {
        return $this->morphMany(ModelPermission::class, 'model');
    }
}
