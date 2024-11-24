<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with(['roles', 'permissions'])->get();
        return view('users.index', compact('users'));
    }

    public function roles(User $user)
    {
        $roles = Role::all();
        $userRoles = $user->roles->pluck('id')->toArray();
        
        return view('users.roles', compact('user', 'roles', 'userRoles'));
    }

    public function assignRoles(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'roles' => 'array|exists:roles,id'
        ]);

        if ($user->hasRole('süper-admin') && 
            (!isset($request->roles) || !in_array(1, $request->roles))) {
            return redirect()->back()
                ->with('error', 'Süper Admin rolü kullanıcıdan kaldırılamaz.');
        }

        $user->roles()->sync($request->roles ?? []);

        return redirect()->back()
            ->with('success', 'Kullanıcı rolleri başarıyla güncellendi.');
    }

    public function assignPermission(Request $request, User $user)
    {
        $validated = $request->validate([
            'permission_id' => 'required|exists:permissions,id',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after:start_date',
            'is_restricted' => 'boolean'
        ]);

        $user->permissions()->attach($validated['permission_id'], [
            'is_restricted' => $validated['is_restricted'] ?? false,
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date']
        ]);

        return redirect()->back()->with('success', 'Kullanıcıya izin atandı.');
    }

    public function revokePermission(Request $request, User $user)
    {
        $validated = $request->validate([
            'permission_id' => 'required|exists:permissions,id'
        ]);

        $user->permissions()->detach($validated['permission_id']);

        return redirect()->back()->with('success', 'Kullanıcı izni kaldırıldı.');
    }

    public function permissions(User $user)
    {
        $permissions = Permission::with('group')->get();
        $userPermissions = $user->permissions()
            ->withPivot(['is_restricted', 'start_date', 'end_date'])
            ->get();
        
        return view('users.permissions', compact('user', 'permissions', 'userPermissions'));
    }

    public function assignModelPermission(Request $request, User $user)
    {
        $validated = $request->validate([
            'model_type' => 'required|string',
            'model_id' => 'required|integer',
            'permission_id' => 'required|exists:permissions,id',
            'model_ids' => 'required|array',
            'model_ids.*' => 'integer',
        ]);

        foreach ($validated['model_ids'] as $modelId) {
            $user->modelPermissions()->create([
                'model_type' => $validated['model_type'],
                'model_id' => $modelId,
                'permission_id' => $validated['permission_id'],
            ]);
        }

        return redirect()->back()->with('success', 'Model bazlı izin başarıyla atandı.');
    }

    public function revokeModelPermission(Request $request, User $user)
    {
        $validated = $request->validate([
            'permission_id' => 'required|exists:permissions,id'
        ]);

        $user->modelPermissions()
            ->where('id', $validated['permission_id'])
            ->delete();

        return redirect()->back()->with('success', 'Model bazlı izin başarıyla kaldırıldı.');
    }

    public function modelPermissions(User $user)
    {
        $permissions = Permission::all();
        $modelTypes = [
            \App\Models\Hospital::class,
            \App\Models\Device::class,
            // Diğer model türlerini ekleyin
        ];
        
        return view('users.model-permissions', compact('user', 'permissions', 'modelTypes'));
    }

    public function profile()
    {
        $user = auth()->user();
        return view('users.profile', compact('user'));
    }
}
