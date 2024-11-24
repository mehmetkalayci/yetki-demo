<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Device extends Model
{
    protected $fillable = [
        'hospital_id',
        'name',
        'serial_number',
        'model',
        'brand',
        'purchase_date',
        'warranty_end',
        'notes'
    ];

    protected $casts = [
        'purchase_date' => 'date',
        'warranty_end' => 'date'
    ];

    public function hospital(): BelongsTo
    {
        return $this->belongsTo(Hospital::class);
    }

    public function modelPermissions(): MorphMany
    {
        return $this->morphMany(ModelPermission::class, 'model');
    }
}
