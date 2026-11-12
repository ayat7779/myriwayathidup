<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import { User, Phone, Mail, Lock, Building, CreditCard, ArrowRight, AlertCircle } from 'lucide-vue-next';

defineProps({
    opds: Array,
});

const form = useForm({
    name: '',
    nip: '',
    nik: '',
    phone: '',
    email: '',
    opd_id: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <Head title="Pendaftaran Pegawai Baru - Aplikasi Riwayat Hidup Digital ASN" />

    <div class="min-h-screen bg-slate-950 flex flex-col justify-center py-12 sm:px-6 lg:px-8 relative overflow-hidden">
        <!-- Background Gradient Glows -->
        <div class="absolute -top-40 -left-40 w-96 h-96 bg-indigo-600/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-40 -right-40 w-96 h-96 bg-emerald-600/20 rounded-full blur-3xl pointer-events-none"></div>

        <div class="sm:mx-auto sm:w-full sm:max-w-md text-center relative z-10">
            <Link href="/" class="inline-flex items-center gap-3 group">
                <div class="w-12 h-12 rounded-2xl bg-indigo-600 flex items-center justify-center font-black text-2xl text-white shadow-xl shadow-indigo-600/30 group-hover:scale-105 transition-transform">
                    ASN
                </div>
                <div class="text-left">
                    <h1 class="font-bold text-xl text-white tracking-tight leading-none">Riwayat Hidup Digital</h1>
                    <p class="text-xs text-indigo-400 font-medium">Sistem Informasi Pendataan ASN</p>
                </div>
            </Link>
            <h2 class="mt-6 text-2xl font-extrabold text-white tracking-tight">
                Pendaftaran Pegawai Baru
            </h2>
            <p class="mt-2 text-sm text-slate-400">
                Isi formulir pendaftaran akun ASN. Pendaftaran memerlukan verifikasi Admin.
            </p>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-lg relative z-10">
            <div class="bg-slate-900/80 backdrop-blur-xl py-8 px-6 shadow-2xl shadow-black/50 border border-slate-800 sm:rounded-2xl sm:px-10">
                <form @submit.prevent="submit" class="space-y-5">

                    <!-- Nama Lengkap -->
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300">
                            Nama Lengkap & Gelar <span class="text-rose-500">*</span>
                        </label>
                        <div class="mt-1.5 relative rounded-xl shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                                <User class="w-5 h-5" />
                            </div>
                            <input
                                v-model="form.name"
                                type="text"
                                required
                                placeholder="misal: Rahmat Hidayat, S.Kom"
                                class="block w-full pl-11 pr-4 py-2.5 bg-slate-800/80 border border-slate-700/80 rounded-xl text-white placeholder-slate-500 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition"
                            />
                        </div>
                        <p v-if="form.errors.name" class="mt-1 text-xs text-rose-400">{{ form.errors.name }}</p>
                    </div>

                    <!-- NIP & NIK (Grid 2 Kolom) -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300">
                                NIP (18 Digit) <span class="text-rose-500">*</span>
                            </label>
                            <div class="mt-1.5 relative rounded-xl shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                                    <CreditCard class="w-5 h-5" />
                                </div>
                                <input
                                    v-model="form.nip"
                                    type="text"
                                    required
                                    maxlength="18"
                                    placeholder="199003032014021003"
                                    class="block w-full pl-11 pr-4 py-2.5 bg-slate-800/80 border border-slate-700/80 rounded-xl text-white placeholder-slate-500 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition"
                                />
                            </div>
                            <p v-if="form.errors.nip" class="mt-1 text-xs text-rose-400">{{ form.errors.nip }}</p>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300">
                                NIK KTP (16 Digit)
                            </label>
                            <div class="mt-1.5 relative rounded-xl shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                                    <CreditCard class="w-5 h-5" />
                                </div>
                                <input
                                    v-model="form.nik"
                                    type="text"
                                    maxlength="16"
                                    placeholder="1471010303900003"
                                    class="block w-full pl-11 pr-4 py-2.5 bg-slate-800/80 border border-slate-700/80 rounded-xl text-white placeholder-slate-500 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition"
                                />
                            </div>
                            <p v-if="form.errors.nik" class="mt-1 text-xs text-rose-400">{{ form.errors.nik }}</p>
                        </div>
                    </div>

                    <!-- OPD / Instansi -->
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300">
                            Unit Kerja / OPD <span class="text-rose-500">*</span>
                        </label>
                        <div class="mt-1.5 relative rounded-xl shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                                <Building class="w-5 h-5" />
                            </div>
                            <select
                                v-model="form.opd_id"
                                required
                                class="block w-full pl-11 pr-4 py-2.5 bg-slate-800 border border-slate-700/80 rounded-xl text-white text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition"
                            >
                                <option value="" disabled>-- Pilih OPD tempat Anda bertugas --</option>
                                <option v-for="opd in opds" :key="opd.id" :value="opd.id">
                                    {{ opd.nama_opd }} ({{ opd.singkatan }})
                                </option>
                            </select>
                        </div>
                        <p v-if="form.errors.opd_id" class="mt-1 text-xs text-rose-400">{{ form.errors.opd_id }}</p>
                    </div>

                    <!-- Phone & Email (Grid 2 Kolom) -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300">
                                No. Telepon / HP <span class="text-rose-500">*</span>
                            </label>
                            <div class="mt-1.5 relative rounded-xl shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                                    <Phone class="w-5 h-5" />
                                </div>
                                <input
                                    v-model="form.phone"
                                    type="text"
                                    required
                                    placeholder="081234567890"
                                    class="block w-full pl-11 pr-4 py-2.5 bg-slate-800/80 border border-slate-700/80 rounded-xl text-white placeholder-slate-500 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition"
                                />
                            </div>
                            <p v-if="form.errors.phone" class="mt-1 text-xs text-rose-400">{{ form.errors.phone }}</p>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300">
                                Alamat Email <span class="text-rose-500">*</span>
                            </label>
                            <div class="mt-1.5 relative rounded-xl shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                                    <Mail class="w-5 h-5" />
                                </div>
                                <input
                                    v-model="form.email"
                                    type="email"
                                    required
                                    placeholder="pegawai@riwayathidup.go.id"
                                    class="block w-full pl-11 pr-4 py-2.5 bg-slate-800/80 border border-slate-700/80 rounded-xl text-white placeholder-slate-500 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition"
                                />
                            </div>
                            <p v-if="form.errors.email" class="mt-1 text-xs text-rose-400">{{ form.errors.email }}</p>
                        </div>
                    </div>

                    <!-- Password & Password Confirmation -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300">
                                Kata Sandi <span class="text-rose-500">*</span>
                            </label>
                            <div class="mt-1.5 relative rounded-xl shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                                    <Lock class="w-5 h-5" />
                                </div>
                                <input
                                    v-model="form.password"
                                    type="password"
                                    required
                                    placeholder="••••••••"
                                    class="block w-full pl-11 pr-4 py-2.5 bg-slate-800/80 border border-slate-700/80 rounded-xl text-white placeholder-slate-500 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition"
                                />
                            </div>
                            <p v-if="form.errors.password" class="mt-1 text-xs text-rose-400">{{ form.errors.password }}</p>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300">
                                Konfirmasi Sandi <span class="text-rose-500">*</span>
                            </label>
                            <div class="mt-1.5 relative rounded-xl shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                                    <Lock class="w-5 h-5" />
                                </div>
                                <input
                                    v-model="form.password_confirmation"
                                    type="password"
                                    required
                                    placeholder="••••••••"
                                    class="block w-full pl-11 pr-4 py-2.5 bg-slate-800/80 border border-slate-700/80 rounded-xl text-white placeholder-slate-500 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition"
                                />
                            </div>
                        </div>
                    </div>

                    <div class="pt-2">
                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="w-full flex justify-center items-center gap-2 py-3 px-4 border border-transparent rounded-xl shadow-lg shadow-indigo-600/30 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition disabled:opacity-50 cursor-pointer"
                        >
                            <span>{{ form.processing ? 'Mendaftarkan...' : 'Kirim Pendaftaran Pegawai' }}</span>
                            <ArrowRight class="w-4 h-4" />
                        </button>
                    </div>
                </form>

                <div class="mt-6 pt-6 border-t border-slate-800 text-center">
                    <p class="text-sm text-slate-400">
                        Sudah memiliki akun terverifikasi?
                        <Link href="/login" class="font-semibold text-indigo-400 hover:text-indigo-300 transition ml-1">
                            Masuk Ke Akun
                        </Link>
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>
