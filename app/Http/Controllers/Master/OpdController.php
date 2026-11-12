<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Opd;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class OpdController extends Controller
{
    public function index(Request $request): Response
    {
        $search = $request->input('search');

        $query = Opd::withCount('pegawais');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('kode_opd', 'like', "%{$search}%")
                    ->orWhere('nama_opd', 'like', "%{$search}%")
                    ->orWhere('singkatan', 'like', "%{$search}%")
                    ->orWhere('kepala_opd', 'like', "%{$search}%")
                    ->orWhere('nip_kepala', 'like', "%{$search}%");
            });
        }

        $opds = $query->orderBy('kode_opd')->paginate(10)->withQueryString();

        return Inertia::render('Master/Opd', [
            'opds' => $opds,
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
            'kode_opd' => 'required|string|max:50|unique:opds,kode_opd',
            'nama_opd' => 'required|string|max:255',
            'singkatan' => 'nullable|string|max:50',
            'kepala_opd' => 'nullable|string|max:255',
            'nip_kepala' => 'nullable|string|max:50',
            'alamat' => 'nullable|string',
        ], [
            'kode_opd.required' => 'Kode OPD wajib diisi.',
            'kode_opd.unique' => 'Kode OPD ini sudah ada.',
            'nama_opd.required' => 'Nama OPD/Instansi wajib diisi.',
        ]);

        Opd::create($validated);

        return redirect()->back()->with('success', 'Data OPD baru berhasil ditambahkan!');
    }

    public function update(Request $request, Opd $opd): RedirectResponse
    {
        $validated = $request->validate([
            'kode_opd' => 'required|string|max:50|unique:opds,kode_opd,'.$opd->id,
            'nama_opd' => 'required|string|max:255',
            'singkatan' => 'nullable|string|max:50',
            'kepala_opd' => 'nullable|string|max:255',
            'nip_kepala' => 'nullable|string|max:50',
            'alamat' => 'nullable|string',
        ]);

        $opd->update($validated);

        return redirect()->back()->with('success', 'Data OPD berhasil diperbarui!');
    }

    public function destroy(Opd $opd): RedirectResponse
    {
        if ($opd->pegawais()->count() > 0) {
            return redirect()->back()->with('error', 'OPD tidak dapat dihapus karena masih terdapat pegawai yang terhubung.');
        }

        $opd->delete();

        return redirect()->back()->with('success', 'Data OPD berhasil dihapus.');
    }
}
