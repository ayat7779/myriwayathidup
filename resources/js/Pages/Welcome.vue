<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
});
</script>

<template>
    <Head title="Selamat Datang" />
    <div class="min-h-screen bg-gradient-to-br from-slate-900 via-indigo-950 to-slate-900 text-white flex flex-col justify-between p-6 md:p-12">
        <header class="flex justify-between items-center max-w-7xl w-full mx-auto">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-indigo-600 flex items-center justify-center font-bold text-xl shadow-lg shadow-indigo-500/30">
                    ASN
                </div>
                <div>
                    <h1 class="font-bold text-lg tracking-tight leading-none">Riwayat Hidup Digital</h1>
                    <p class="text-xs text-indigo-300">Aplikasi Pendataan & DRH ASN</p>
                </div>
            </div>

            <nav class="flex items-center gap-4">
                <Link
                    href="/login"
                    class="px-4 py-2 rounded-lg text-sm font-medium bg-slate-800 hover:bg-slate-700 text-slate-200 transition"
                >
                    Masuk (Login)
                </Link>
                <Link
                    href="/register"
                    class="px-4 py-2 rounded-lg text-sm font-medium bg-indigo-600 hover:bg-indigo-500 text-white shadow-lg shadow-indigo-600/30 transition"
                >
                    Daftar Akun
                </Link>
            </nav>
        </header>

        <main class="max-w-4xl mx-auto my-auto text-center py-16">
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-indigo-500/10 border border-indigo-500/20 text-indigo-300 text-xs font-medium mb-6">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                Sistem Informasi Pendataan Pegawai ASN Digital
            </div>
            <h2 class="text-4xl md:text-6xl font-extrabold tracking-tight mb-6 leading-tight">
                Kelola Daftar Riwayat Hidup ASN Secara Digital & Terstruktur
            </h2>
            <p class="text-lg md:text-xl text-slate-400 max-w-2xl mx-auto mb-8">
                Platform terpadu untuk pengisian Keterangan Perorangan, Pendidikan, Riwayat Kepangkatan, Jabatan, Penghargaan, Keluarga, Organisasi, dan Dokumen Digital ASN.
            </p>

            <div class="flex flex-wrap justify-center gap-4">
                <Link
                    href="/login"
                    class="px-6 py-3.5 rounded-xl font-semibold bg-indigo-600 hover:bg-indigo-500 text-white shadow-xl shadow-indigo-600/30 transition flex items-center gap-2"
                >
                    Mulai Sekarang
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </Link>
                <Link
                    href="/dashboard"
                    class="px-6 py-3.5 rounded-xl font-semibold bg-slate-800 hover:bg-slate-700 text-slate-200 transition"
                >
                    Lihat Dashboard Publik
                </Link>
            </div>
        </main>

        <footer class="max-w-7xl w-full mx-auto text-center text-xs text-slate-500">
            &copy; {{ new Date().getFullYear() }} Aplikasi Riwayat Hidup Digital ASN. Powered by Laravel & Inertia Vue 3.
        </footer>
    </div>
</template>
