<?php

namespace App\Http\Controllers;

use App\Models\Hospital;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controllers\HasMiddleware;

class HospitalController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return ['permission:hastane-görüntüle'];
    }

    public function index(): View
    {
        $hospitals = Hospital::withCount(['modelPermissions', 'devices'])->get();
        return view('hospitals.index', compact('hospitals'));
    }

    public function create(): View
    {
        if (!auth()->user()->hasPermission('hastane-ekle')) {
            abort(403, 'Bu işlem için yetkiniz bulunmuyor.');
        }
        return view('hospitals.create');
    }

    public function store(Request $request): RedirectResponse
    {
        if (!auth()->user()->hasPermission('hastane-ekle')) {
            abort(403, 'Bu işlem için yetkiniz bulunmuyor.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email'
        ]);

        Hospital::create($validated);

        return redirect()->route('hospitals.index')
            ->with('success', 'Hastane başarıyla oluşturuldu.');
    }

    public function edit(Hospital $hospital): View
    {
        $user = auth()->user();
        
        if (!$user->hasPermission('hastane-düzenle') && 
            !$user->hasModelPermission($hospital, 'hastane-düzenle')) {
            abort(403, 'Bu işlem için yetkiniz bulunmuyor.');
        }

        return view('hospitals.edit', compact('hospital'));
    }

    public function update(Request $request, Hospital $hospital): RedirectResponse
    {
        $user = auth()->user();
        
        if (!$user->hasPermission('hastane-düzenle') && 
            !$user->hasModelPermission($hospital, 'hastane-düzenle')) {
            abort(403, 'Bu işlem için yetkiniz bulunmuyor.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email'
        ]);

        $hospital->update($validated);

        return redirect()->route('hospitals.index')
            ->with('success', 'Hastane başarıyla güncellendi.');
    }

    public function destroy(Hospital $hospital): RedirectResponse
    {
        $user = auth()->user();
        
        if (!$user->hasPermission('hastane-sil') && 
            !$user->hasModelPermission($hospital, 'hastane-sil')) {
            abort(403, 'Bu işlem için yetkiniz bulunmuyor.');
        }
        
        $hospital->delete();
        return redirect()->route('hospitals.index')
            ->with('success', 'Hastane başarıyla silindi.');
    }
}
