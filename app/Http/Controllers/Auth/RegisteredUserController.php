<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Opd;
use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register', [
            'opds' => Opd::select('id', 'nama_opd', 'singkatan')->get(),
        ]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nip' => 'required|string|numeric|digits:18|unique:users,nip',
            'nik' => 'nullable|string|numeric|digits:16|unique:users,nik',
            'phone' => 'required|string|max:20|unique:users,phone',
            'email' => 'required|string|lowercase|email|max:255|unique:users,email',
            'opd_id' => 'required|exists:opds,id',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'nip.required' => 'NIP wajib diisi.',
            'nip.digits' => 'NIP harus terdiri dari 18 digit angka.',
            'nip.unique' => 'NIP ini sudah terdaftar dalam sistem.',
            'nik.digits' => 'NIK harus terdiri dari 16 digit angka.',
            'phone.required' => 'Nomor HP/Telepon wajib diisi.',
            'phone.unique' => 'Nomor Telepon sudah terdaftar.',
            'email.unique' => 'Email ini sudah terdaftar.',
            'opd_id.required' => 'Silakan pilih OPD/Instansi tempat Anda bertugas.',
        ]);

        // Create user with default is_approved = false
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'nip' => $request->nip,
            'nik' => $request->nik,
            'phone' => $request->phone,
            'opd_id' => $request->opd_id,
            'password' => Hash::make($request->password),
            'role' => 'pegawai',
            'is_approved' => false,
        ]);

        // Create draft record in pegawais table
        Pegawai::create([
            'user_id' => $user->id,
            'nip' => $user->nip,
            'nik' => $user->nik,
            'nama_lengkap' => $user->name,
            'opd_id' => $user->opd_id,
            'tempat_lahir' => '-',
            'tanggal_lahir' => '1990-01-01',
            'jenis_kelamin' => 'Laki-laki',
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('pending-approval')->with('success', 'Pendaftaran berhasil! Akun Anda sedang menunggu verifikasi dan persetujuan dari Admin.');
    }
}
