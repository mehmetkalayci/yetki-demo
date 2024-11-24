<?php

namespace App\Traits;

use App\Models\ModelPermission;

trait HasModelPermissions
{
    public function modelPermissions()
    {
        return $this->morphMany(ModelPermission::class, 'model');
    }

    public function hasUserPermission($user, $permission)
    {
        return $this->modelPermissions()
            ->where('user_id', $user->id)
            ->whereHas('permission', function ($query) use ($permission) {
                $query->where('name', $permission);
            })
            ->exists();
    }
}
