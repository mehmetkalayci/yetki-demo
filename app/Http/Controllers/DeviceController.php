<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Hospital;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controllers\HasMiddleware;
use App\Models\User;
use App\Models\Permission;

class DeviceController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return ['permission:cihaz-görüntüle'];
    }

    public function index(): View
    {
        $devices = Device::with(['hospital', 'modelPermissions'])->get();
        return view('devices.index', compact('devices'));
    }

    public function create(): View
    {
        if (!auth()->user()->hasPermission('cihaz-ekle')) {
            abort(403, 'Bu işlem için yetkiniz bulunmuyor.');
        }

        $hospitals = Hospital::all();
        return view('devices.create', compact('hospitals'));
    }

    public function store(Request $request): RedirectResponse
    {
        if (!auth()->user()->hasPermission('cihaz-ekle')) {
            abort(403, 'Bu işlem için yetkiniz bulunmuyor.');
        }
    
        $validated = $request->validate([
            'hospital_id' => 'required|exists:hospitals,id',
            'name' => 'required|string|max:255',
            'serial_number' => 'required|string|unique:devices',
            'model' => 'nullable|string|max:255',
            'brand' => 'nullable|string|max:255',
            'purchase_date' => 'nullable|date',
            'warranty_end' => 'nullable|date|after:purchase_date',
            'notes' => 'nullable|string'
        ]);
    
        Device::create($validated);
    
        return redirect()->route('devices.index')
            ->with('success', 'Cihaz başarıyla oluşturuldu.');
    }

    public function edit(Device $device): View
    {
        $user = auth()->user();
        
        if (!$user->hasPermission('cihaz-düzenle') && 
            !$user->hasModelPermission($device, 'cihaz-düzenle') &&
            !$user->hasModelPermission($device->hospital, 'cihaz-düzenle')) {
            abort(403, 'Bu işlem için yetkiniz bulunmuyor.');
        }

        $hospitals = Hospital::all();
        return view('devices.edit', compact('device', 'hospitals'));
    }

    public function update(Request $request, Device $device): RedirectResponse
    {
        $user = auth()->user();
        
        if (!$user->hasPermission('cihaz-düzenle') && 
            !$user->hasModelPermission($device, 'cihaz-düzenle') &&
            !$user->hasModelPermission($device->hospital, 'cihaz-düzenle')) {
            abort(403, 'Bu işlem için yetkiniz bulunmuyor.');
        }

        $validated = $request->validate([
            'hospital_id' => 'required|exists:hospitals,id',
            'name' => 'required|string|max:255',
            'serial_number' => 'required|string|unique:devices,serial_number,' . $device->id,
            'model' => 'nullable|string|max:255',
            'brand' => 'nullable|string|max:255',
            'purchase_date' => 'nullable|date',
            'warranty_end' => 'nullable|date|after:purchase_date',
            'notes' => 'nullable|string'
        ]);

        $device->update($validated);

        return redirect()->route('devices.index')
            ->with('success', 'Cihaz başarıyla güncellendi.');
    }

    public function destroy(Device $device): RedirectResponse
    {
        $user = auth()->user();
        
        if (!$user->hasPermission('cihaz-sil') && 
            !$user->hasModelPermission($device, 'cihaz-sil') &&
            !$user->hasModelPermission($device->hospital, 'cihaz-sil')) {
            abort(403, 'Bu işlem için yetkiniz bulunmuyor.');
        }
        
        $device->delete();
        return redirect()->route('devices.index')
            ->with('success', 'Cihaz başarıyla silindi.');
    }

    public function modelPermissions(Device $device): View
    {
        $user = auth()->user();
        
        if (!$user->hasPermission('cihaz-izinleri-görüntüle') && 
            !$user->hasModelPermission($device, 'cihaz-izinleri-görüntüle') &&
            !$user->hasModelPermission($device->hospital, 'cihaz-izinleri-görüntüle')) {
            abort(403, 'Bu işlem için yetkiniz bulunmuyor.');
        }

        $users = User::all();
        $permissions = Permission::where('name', 'like', 'cihaz-%')->get();

        return view('devices.model-permissions', compact('device', 'users', 'permissions'));
    }

    public function assignModelPermission(Request $request, Device $device): RedirectResponse
    {
        $user = auth()->user();
        
        if (!$user->hasPermission('cihaz-izni-ekle') && 
            !$user->hasModelPermission($device, 'cihaz-izni-ekle') &&
            !$user->hasModelPermission($device->hospital, 'cihaz-izni-ekle')) {
            abort(403, 'Bu işlem için yetkiniz bulunmuyor.');
        }

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'permission_id' => 'required|exists:permissions,id',
            'is_restricted' => 'boolean',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after:start_date'
        ]);

        $device->modelPermissions()->create([
            'user_id' => $validated['user_id'],
            'permission_id' => $validated['permission_id'],
            'is_restricted' => $validated['is_restricted'] ?? false,
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date']
        ]);

        return redirect()->back()
            ->with('success', 'Model bazlı izin başarıyla atandı.');
    }

    public function revokeModelPermission(Request $request, Device $device): RedirectResponse
    {
        $user = auth()->user();
        
        if (!$user->hasPermission('cihaz-izni-kaldır') && 
            !$user->hasModelPermission($device, 'cihaz-izni-kaldır') &&
            !$user->hasModelPermission($device->hospital, 'cihaz-izni-kaldır')) {
            abort(403, 'Bu işlem için yetkiniz bulunmuyor.');
        }

        $device->modelPermissions()
            ->where('id', $request->permission_id)
            ->delete();

        return redirect()->back()
            ->with('success', 'Model bazlı izin başarıyla kaldırıldı.');
    }
}
