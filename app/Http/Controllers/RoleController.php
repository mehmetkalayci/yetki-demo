<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controllers\HasMiddleware;

class RoleController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return ['permission:rol-yönet'];
    }

    public function index(): View
    {
        $roles = Role::with(['permissions', 'users'])->get();
        return view('roles.index', compact('roles'));
    }

    public function create(): View
    {
        $permissions = Permission::with('group')->get();
        return view('roles.create', compact('permissions'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|unique:roles,name|max:50|regex:/^[a-z0-9-]+$/',
            'permissions' => 'array|exists:permissions,id'
        ]);

        $role = Role::create(['name' => $validated['name']]);
        
        if($request->has('permissions')) {
            $role->permissions()->sync($request->permissions);
        }

        return redirect()->route('roles.index')
            ->with('success', 'Rol başarıyla oluşturuldu.');
    }

    public function edit(Role $role): View
    {
        $permissions = Permission::with('group')->get();
        $rolePermissions = $role->permissions->pluck('id')->toArray();
        return view('roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    public function update(Request $request, Role $role): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id . '|max:50|regex:/^[a-z0-9-]+$/',
            'permissions' => 'array|exists:permissions,id'
        ]);

        $role->update(['name' => $validated['name']]);
        $role->permissions()->sync($request->permissions ?? []);

        return redirect()->route('roles.index')
            ->with('success', 'Rol başarıyla güncellendi.');
    }

    public function destroy(Role $role): RedirectResponse
    {
        if ($role->name === 'süper-admin') {
            return redirect()->route('roles.index')
                ->with('error', 'Süper Admin rolü silinemez.');
        }

        $role->delete();
        return redirect()->route('roles.index')
            ->with('success', 'Rol başarıyla silindi.');
    }
}
