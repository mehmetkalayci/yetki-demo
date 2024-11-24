<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReportController extends Controller
{

    public function index()
    {
        $reports = Report::all(); // veya istediğiniz şekilde verileri alın
        return view('reports.index', compact('reports'));
    }

    public function create(): View
    {
        return view('reports.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Report::create($validated);

        return redirect()->route('reports.index')->with('success', 'Rapor başarıyla oluşturuldu.');
    }
}