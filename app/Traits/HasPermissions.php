<?php

namespace App\Traits;

use Illuminate\Support\Carbon;

trait HasPermissions
{
    /**
     * Kullanıcının bir role sahip olup olmadığını kontrol eder.
     */
    public function hasRole($roleName): bool
    {
        return $this->roles()->where('name', $roleName)->exists();
    }

    /**
     * Kullanıcının bir izne sahip olup olmadığını kontrol eder.
     * Roller, kullanıcı özel izinleri ve model bazlı izinler sırasıyla kontrol edilir.
     */
    public function hasPermission($permissionName, $model = null): bool
    {
        // 1. Kullanıcının rollerindeki izinler
        $rolePermissions = $this->roles->flatMap->permissions->pluck('name')->toArray();

        // 2. Kullanıcının özel izinleri (aktif olanlar)
        $userPermissions = $this->permissions()
            ->wherePivot('is_restricted', false)
            ->where(function ($query) {
                $today = Carbon::today();
                $query->whereNull('start_date')
                      ->orWhere('start_date', '<=', $today)
                      ->whereNull('end_date')
                      ->orWhere('end_date', '>=', $today);
            })
            ->pluck('name')
            ->toArray();

        // 3. Kullanıcının kısıtlı izinleri (öncelik sırasına göre)
        $restrictedPermissions = $this->permissions()
            ->wherePivot('is_restricted', true)
            ->pluck('name')
            ->toArray();

        // 4. Model bazlı izinler
        $modelPermissions = [];
        if ($model) {
            $modelPermissions = $this->modelPermissions()
                ->where('model_type', get_class($model))
                ->where('model_id', $model->id)
                ->whereHas('permission', function ($query) use ($permissionName) {
                    $query->where('name', $permissionName);
                })
                ->exists();
        }

        // 5. İzin kontrol sıralaması
        if (in_array($permissionName, $restrictedPermissions)) {
            return false; // Kısıtlanmışsa izin verilmez
        }

        if ($model && $modelPermissions) {
            return true; // Model bazlı izni varsa geçerli
        }

        return in_array($permissionName, array_merge($rolePermissions, $userPermissions));
    }
}
