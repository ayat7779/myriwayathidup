<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Pangkat;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PangkatController extends Controller
{
    public function index(Request $request): Response
    {
        $search = $request->input('search');

        $query = Pangkat::withCount('pegawais');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('golongan', 'like', "%{$search}%")
                    ->orWhere('pangkat', 'like', "%{$search}%");
            });
        }

        $pangkats = $query->orderBy('tingkat')->get();

        return Inertia::render('Master/Pangkat', [
            'pangkats' => $pangkats,
            'filters' => ['search' => $search],
            'flash' => [
                'success' => session('success'),
                'error' => session('error'),
            ],
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'golongan' => 'required|string|max:20|unique:pangkats,golongan',
            'pangkat' => 'required|string|max:255',
            'tingkat' => 'required|integer',
        ]);

        Pangkat::create($validated);

        return redirect()->back()->with('success', 'Data Golongan & Pangkat berhasil ditambahkan!');
    }

    public function update(Request $request, Pangkat $pangkat): RedirectResponse
    {
        $validated = $request->validate([
            'golongan' => 'required|string|max:20|unique:pangkats,golongan,'.$pangkat->id,
            'pangkat' => 'required|string|max:255',
            'tingkat' => 'required|integer',
        ]);

        $pangkat->update($validated);

        return redirect()->back()->with('success', 'Data Golongan & Pangkat berhasil diperbarui!');
    }

    public function destroy(Pangkat $pangkat): RedirectResponse
    {
        if ($pangkat->pegawais()->count() > 0) {
            return redirect()->back()->with('error', 'Pangkat/Golongan tidak dapat dihapus karena masih terhubung dengan data pegawai.');
        }

        $pangkat->delete();

        return redirect()->back()->with('success', 'Data Pangkat/Golongan berhasil dihapus.');
    }
}
