<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Opd;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class UserApprovalController extends Controller
{
    public function index(Request $request): Response
    {
        $search = $request->input('search');
        $opdId = $request->input('opd_id');
        $status = $request->input('status', 'pending'); // pending, approved, all

        $query = User::with('opd')->where('role', '!=', 'admin');

        if ($status === 'pending') {
            $query->where('is_approved', false);
        } elseif ($status === 'approved') {
            $query->where('is_approved', true);
        }

        if ($opdId) {
            $query->where('opd_id', $opdId);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('nip', 'like', "%{$search}%")
                    ->orWhere('nik', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->latest()->paginate(10)->withQueryString();

        return Inertia::render('Admin/Users', [
            'users' => $users,
            'opds' => Opd::select('id', 'nama_opd', 'singkatan')->get(),
            'filters' => [
                'search' => $search,
                'opd_id' => $opdId,
                'status' => $status,
            ],
            'flash' => [
                'success' => session('success'),
                'error' => session('error'),
            ],
        ]);
    }

    public function approve(User $user): RedirectResponse
    {
        $user->update([
            'is_approved' => true,
            'approved_at' => now(),
            'approved_by' => auth()->id(),
        ]);

        return redirect()->back()->with('success', "Akun pegawai {$user->name} (NIP: {$user->nip}) berhasil disetujui!");
    }

    public function reject(User $user): RedirectResponse
    {
        $name = $user->name;
        $user->delete();

        return redirect()->back()->with('success', "Pendaftaran pendaftaran user {$name} telah ditolak dan dihapus.");
    }
}
