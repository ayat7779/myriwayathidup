<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {
    Users,
    Building2,
    CheckCircle2,
    Clock,
    FileCheck2,
    FileText,
    ArrowUpRight,
    TrendingUp
} from 'lucide-vue-next';

defineProps({
    kpi: Object,
    pegawaiPerOpd: Array,
    genderComposition: Object,
    pangkatComposition: Array,
});
</script>

<template>
    <Head title="Dashboard KPI Kepegawaian ASN" />

    <AuthenticatedLayout>
        <template #header>
            Dashboard KPI Kepegawaian ASN
        </template>

        <div class="space-y-6 max-w-7xl mx-auto">

            <!-- Welcome Banner -->
            <div class="bg-gradient-to-r from-indigo-900 via-indigo-800 to-slate-900 rounded-2xl p-6 md:p-8 text-white shadow-xl relative overflow-hidden">
                <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-indigo-500/20 rounded-full blur-3xl pointer-events-none"></div>
                <div class="relative z-10 max-w-2xl">
                    <span class="px-3 py-1 rounded-full bg-indigo-500/30 border border-indigo-400/30 text-indigo-200 text-xs font-semibold">
                        Sistem Informasi DRH ASN Digital
                    </span>
                    <h1 class="text-2xl md:text-3xl font-extrabold tracking-tight mt-3">
                        Selamat Datang di Aplikasi Riwayat Hidup Digital
                    </h1>
                    <p class="text-slate-300 text-sm mt-2 leading-relaxed">
                        Pantau indikator kinerja kepegawaian, verifikasi pendaftaran pegawai baru, serta kelola dokumen Daftar Riwayat Hidup (DRH) secara terpusat.
                    </p>

                    <div class="mt-6 flex flex-wrap gap-3">
                        <Link
                            href="/pegawai/profil"
                            class="px-4 py-2.5 rounded-xl bg-white text-indigo-900 font-bold text-xs shadow-lg hover:bg-slate-100 transition inline-flex items-center gap-2"
                        >
                            <FileText class="w-4 h-4 text-indigo-600" />
                            Isi / Lihat Riwayat Hidup Saya
                        </Link>
                    </div>
                </div>
            </div>

            <!-- KPI Cards Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                <!-- Total Pegawai -->
                <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-xs hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Total Pegawai</span>
                        <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                            <Users class="w-5 h-5" />
                        </div>
                    </div>
                    <div class="text-2xl font-black text-slate-800 mt-3">{{ kpi?.total_pegawai || 0 }}</div>
                    <div class="text-[11px] text-slate-500 mt-1">Pegawai terdata di sistem</div>
                </div>

                <!-- User Approved -->
                <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-xs hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-500">User Disetujui</span>
                        <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                            <CheckCircle2 class="w-5 h-5" />
                        </div>
                    </div>
                    <div class="text-2xl font-black text-emerald-600 mt-3">{{ kpi?.total_user_approved || 0 }}</div>
                    <div class="text-[11px] text-slate-500 mt-1">Akun aktif & terverifikasi</div>
                </div>

                <!-- User Pending -->
                <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-xs hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Pending Admin</span>
                        <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                            <Clock class="w-5 h-5" />
                        </div>
                    </div>
                    <div class="text-2xl font-black text-amber-600 mt-3">{{ kpi?.total_user_pending || 0 }}</div>
                    <div class="text-[11px] text-slate-500 mt-1">Menunggu persetujuan</div>
                </div>

                <!-- Total OPD -->
                <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-xs hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Total OPD</span>
                        <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                            <Building2 class="w-5 h-5" />
                        </div>
                    </div>
                    <div class="text-2xl font-black text-slate-800 mt-3">{{ kpi?.total_opd || 0 }}</div>
                    <div class="text-[11px] text-slate-500 mt-1">Unit kerja terintegrasi</div>
                </div>

                <!-- Total Dokumen -->
                <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-xs hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Dokumen Digital</span>
                        <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center">
                            <FileCheck2 class="w-5 h-5" />
                        </div>
                    </div>
                    <div class="text-2xl font-black text-slate-800 mt-3">{{ kpi?.total_dokumen || 0 }}</div>
                    <div class="text-[11px] text-slate-500 mt-1">Berkas terupload</div>
                </div>
            </div>

            <!-- Detail Graphics & Statistics Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <!-- 1. Pegawai per OPD List -->
                <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-xs lg:col-span-2">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-4">
                        <div>
                            <h3 class="font-bold text-slate-800 text-sm">Jumlah Pegawai per OPD / Unit Kerja</h3>
                            <p class="text-xs text-slate-500">Distribusi ASN di setiap Organisasi Perangkat Daerah</p>
                        </div>
                        <Building2 class="w-5 h-5 text-slate-400" />
                    </div>

                    <div class="space-y-3">
                        <div
                            v-for="opd in pegawaiPerOpd"
                            :key="opd.id"
                            class="flex items-center justify-between p-3 rounded-xl bg-slate-50 border border-slate-100"
                        >
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-indigo-100 text-indigo-700 font-bold text-xs flex items-center justify-center">
                                    {{ opd.nama.charAt(0) }}
                                </div>
                                <span class="text-xs font-semibold text-slate-800">{{ opd.nama }}</span>
                            </div>

                            <div class="flex items-center gap-2">
                                <span class="text-xs font-bold text-indigo-600 bg-indigo-50 px-2.5 py-1 rounded-full border border-indigo-100">
                                    {{ opd.total }} Pegawai
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 2. Demografi Gender & Golongan -->
                <div class="space-y-6">

                    <!-- Gender Composition Card -->
                    <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-xs">
                        <h3 class="font-bold text-slate-800 text-sm mb-1">Komposisi Jenis Kelamin</h3>
                        <p class="text-xs text-slate-500 mb-4">Distribusi Gender ASN</p>

                        <div class="space-y-3">
                            <div>
                                <div class="flex justify-between text-xs font-medium text-slate-700 mb-1">
                                    <span>Laki-laki</span>
                                    <span class="font-bold">{{ genderComposition['Laki-laki'] || 0 }} Orang</span>
                                </div>
                                <div class="w-full bg-slate-100 h-2.5 rounded-full overflow-hidden">
                                    <div
                                        class="bg-blue-600 h-full rounded-full"
                                        :style="{ width: ((genderComposition['Laki-laki'] / (kpi?.total_pegawai || 1)) * 100) + '%' }"
                                    ></div>
                                </div>
                            </div>

                            <div>
                                <div class="flex justify-between text-xs font-medium text-slate-700 mb-1">
                                    <span>Perempuan</span>
                                    <span class="font-bold">{{ genderComposition['Perempuan'] || 0 }} Orang</span>
                                </div>
                                <div class="w-full bg-slate-100 h-2.5 rounded-full overflow-hidden">
                                    <div
                                        class="bg-pink-500 h-full rounded-full"
                                        :style="{ width: ((genderComposition['Perempuan'] / (kpi?.total_pegawai || 1)) * 100) + '%' }"
                                    ></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Golongan Summary -->
                    <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-xs">
                        <h3 class="font-bold text-slate-800 text-sm mb-1">Komposisi Pangkat / Golongan</h3>
                        <p class="text-xs text-slate-500 mb-4">Ringkasan Golongan Ruang Penggajian</p>

                        <div class="space-y-2 max-h-48 overflow-y-auto pr-1">
                            <div
                                v-for="pangkat in pangkatComposition"
                                :key="pangkat.golongan"
                                class="flex items-center justify-between text-xs p-2 rounded-lg hover:bg-slate-50"
                            >
                                <span class="font-semibold text-slate-700">Gol. {{ pangkat.golongan }} ({{ pangkat.pangkat }})</span>
                                <span class="font-bold text-indigo-600">{{ pangkat.total }} Pegawai</span>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </AuthenticatedLayout>
</template>
