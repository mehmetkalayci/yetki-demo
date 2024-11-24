<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\PermissionGroup;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class PermissionController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return ['permission:izin-yönet'];
    }

    public function index(): View
    {
        $permissions = Permission::with('group')->get();
        return view('permissions.index', compact('permissions'));
    }

    public function create(): View
    {
        $groups = PermissionGroup::all();
        return view('permissions.create', compact('groups'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|unique:permissions,name|max:50|regex:/^[a-z0-9-]+$/',
            'display_name' => 'required|max:255',
            'permission_group_id' => 'required|exists:permission_groups,id'
        ]);

        Permission::create($validated);

        return redirect()->route('permissions.index')
            ->with('success', 'İzin başarıyla oluşturuldu.');
    }

    public function edit(Permission $permission): View
    {
        $groups = PermissionGroup::all();
        return view('permissions.edit', compact('permission', 'groups'));
    }

    public function update(Request $request, Permission $permission): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|unique:permissions,name,' . $permission->id . '|max:50|regex:/^[a-z0-9-]+$/',
            'display_name' => 'required|max:255',
            'permission_group_id' => 'required|exists:permission_groups,id'
        ]);

        $permission->update($validated);

        return redirect()->route('permissions.index')
            ->with('success', 'İzin başarıyla güncellendi.');
    }

    public function destroy(Permission $permission): RedirectResponse
    {
        if (in_array($permission->name, ['rol-yönet', 'izin-yönet'])) {
            return redirect()->route('permissions.index')
                ->with('error', 'Temel izinler silinemez.');
        }

        $permission->delete();
        return redirect()->route('permissions.index')
            ->with('success', 'İzin başarıyla silindi.');
    }
}
