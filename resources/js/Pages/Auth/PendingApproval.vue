<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Clock, ShieldAlert, LogOut, CheckCircle2, Home } from 'lucide-vue-next';

defineProps({
    auth: Object,
});

const form = useForm({});

const logout = () => {
    form.post(route('logout'));
};
</script>

<template>
    <Head title="Menunggu Persetujuan Admin - Aplikasi Riwayat Hidup Digital ASN" />

    <div class="min-h-screen bg-slate-950 flex flex-col justify-center py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
        <!-- Background Gradient Glows -->
        <div class="absolute -top-40 -left-40 w-96 h-96 bg-amber-600/15 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-40 -right-40 w-96 h-96 bg-indigo-600/15 rounded-full blur-3xl pointer-events-none"></div>

        <div class="sm:mx-auto sm:w-full sm:max-w-lg text-center relative z-10">
            <div class="w-16 h-16 rounded-2xl bg-amber-500/10 border border-amber-500/20 text-amber-400 flex items-center justify-center mx-auto mb-6 shadow-xl shadow-amber-500/10">
                <Clock class="w-8 h-8 animate-pulse" />
            </div>

            <h1 class="text-2xl font-extrabold text-white tracking-tight">
                Persetujuan Akun Sedang Diproses
            </h1>
            <p class="mt-2 text-sm text-slate-400 max-w-md mx-auto">
                Halo, <span class="font-semibold text-amber-300">{{ auth.user?.name }}</span>! Akun pendaftaran pegawai Anda saat ini masih dalam status persetujuan verifikasi oleh Administrator Aplikasi.
            </p>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-lg relative z-10">
            <div class="bg-slate-900/80 backdrop-blur-xl py-8 px-6 shadow-2xl shadow-black/50 border border-slate-800 sm:rounded-2xl sm:px-10 text-slate-300 space-y-6">

                <div class="p-4 rounded-xl bg-amber-500/10 border border-amber-500/20 flex items-start gap-3 text-amber-300 text-sm">
                    <ShieldAlert class="w-5 h-5 text-amber-400 shrink-0 mt-0.5" />
                    <div>
                        <h2 class="font-semibold">Informasi Alur Pendaftaran:</h2>
                        <ul class="mt-2 space-y-1 text-xs text-amber-200/80 list-disc list-inside">
                            <li>NIP: <span class="font-mono text-amber-300">{{ auth.user?.nip }}</span></li>
                            <li>Persetujuan diperlukan sebelum Anda dapat mengisi & mengunduh DRH ASN.</li>
                            <li>Anda hanya bisa melihat halaman Dashboard Publik selama status belum disetujui.</li>
                        </ul>
                    </div>
                </div>

                <div class="space-y-3">
                    <div class="flex items-center gap-3 text-xs text-slate-400">
                        <CheckCircle2 class="w-4 h-4 text-emerald-400" />
                        <span>Pendaftaran Akun Berhasil</span>
                    </div>
                    <div class="flex items-center gap-3 text-xs text-amber-400 font-medium">
                        <Clock class="w-4 h-4 text-amber-400 animate-spin" />
                        <span>Sedang Menunggu Persetujuan Admin / BKPSDM</span>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-800 flex flex-col sm:flex-row gap-3">
                    <Link
                        href="/"
                        class="flex-1 inline-flex justify-center items-center gap-2 px-4 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-200 text-sm font-semibold transition"
                    >
                        <Home class="w-4 h-4" />
                        Halaman Utama
                    </Link>

                    <button
                        @click="logout"
                        class="flex-1 inline-flex justify-center items-center gap-2 px-4 py-2.5 rounded-xl bg-rose-600/20 hover:bg-rose-600/30 text-rose-300 border border-rose-500/30 text-sm font-semibold transition cursor-pointer"
                    >
                        <LogOut class="w-4 h-4" />
                        Keluar (Logout)
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
