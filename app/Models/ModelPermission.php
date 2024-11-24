<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelPermission extends Model
{
    protected $fillable = [
        'user_id',
        'model_type',
        'model_id',
        'permission_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function permission()
    {
        return $this->belongsTo(Permission::class);
    }

    public function model()
    {
        return $this->morphTo();
    }
}
