<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {
    FileText,
    ArrowLeft,
    User,
    GraduationCap,
    Briefcase,
    Award,
    Globe,
    Users,
    Building2,
    FileCheck2,
    Printer
} from 'lucide-vue-next';

defineProps({
    pegawai: Object,
});
</script>

<template>
    <Head :title="`Daftar Riwayat Hidup - ${pegawai.nama_lengkap}`" />

    <AuthenticatedLayout>
        <template #header>
            Daftar Riwayat Hidup (DRH) ASN
        </template>

        <div class="space-y-6 max-w-5xl mx-auto pb-12">

            <!-- Back Button & Header -->
            <div class="flex items-center justify-between">
                <Link
                    href="/pegawai"
                    class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 font-bold text-xs shadow-xs transition"
                >
                    <ArrowLeft class="w-4 h-4" />
                    Kembali ke Daftar Pegawai
                </Link>

                <a
                    :href="route('pegawai.cetakDrh', pegawai.id)"
                    target="_blank"
                    class="px-4 py-2 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs shadow-md transition flex items-center gap-2 cursor-pointer"
                >
                    <Printer class="w-4 h-4 text-indigo-400" />
                    <span>Cetak DRH Official PDF</span>
                </a>
            </div>

            <!-- Profile Summary Card -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-xs flex flex-col md:flex-row items-center gap-6">
                <div class="w-24 h-24 rounded-2xl bg-indigo-100 text-indigo-700 font-bold text-2xl flex items-center justify-center shrink-0 border-2 border-indigo-200 overflow-hidden">
                    <img v-if="pegawai.foto_path" :src="'/storage/' + pegawai.foto_path" class="w-full h-full object-cover" />
                    <span v-else>{{ pegawai.nama_lengkap?.charAt(0) }}</span>
                </div>

                <div class="flex-1 text-center md:text-left space-y-1">
                    <h2 class="text-xl font-bold text-slate-900">
                        {{ pegawai.gelar_depan ? pegawai.gelar_depan + ' ' : '' }}{{ pegawai.nama_lengkap }}{{ pegawai.gelar_belakang ? ', ' + pegawai.gelar_belakang : '' }}
                    </h2>
                    <p class="text-xs font-mono font-bold text-indigo-600">NIP: {{ pegawai.nip }}</p>
                    <p class="text-xs text-slate-600 font-medium">{{ pegawai.jabatan_saat_ini || '-' }} • {{ pegawai.opd?.nama_opd }}</p>
                    <div class="pt-2 flex flex-wrap justify-center md:justify-start gap-2 text-[11px]">
                        <span class="px-2.5 py-0.5 rounded-full bg-slate-100 font-semibold text-slate-700">Golongan: {{ pegawai.pangkat?.golongan || '-' }}</span>
                        <span class="px-2.5 py-0.5 rounded-full bg-slate-100 font-semibold text-slate-700">TTL: {{ pegawai.tempat_lahir }}, {{ pegawai.tanggal_lahir }}</span>
                        <span class="px-2.5 py-0.5 rounded-full bg-slate-100 font-semibold text-slate-700">Agama: {{ pegawai.agama }}</span>
                    </div>
                </div>
            </div>

            <!-- 1. Keterangan Perorangan & Badan -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-xs space-y-4">
                <h3 class="text-sm font-bold text-slate-800 flex items-center gap-2 border-b border-slate-100 pb-3">
                    <User class="w-4 h-4 text-indigo-600" />
                    I. Keterangan Perorangan & Badan
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
                    <div><span class="text-slate-500">Nama Lengkap:</span> <strong class="text-slate-800 ml-1">{{ pegawai.nama_lengkap }}</strong></div>
                    <div><span class="text-slate-500">NIP:</span> <strong class="text-slate-800 ml-1 font-mono">{{ pegawai.nip }}</strong></div>
                    <div><span class="text-slate-500">NIK:</span> <strong class="text-slate-800 ml-1 font-mono">{{ pegawai.nik || '-' }}</strong></div>
                    <div><span class="text-slate-500">Jenis Kelamin:</span> <strong class="text-slate-800 ml-1">{{ pegawai.jenis_kelamin }}</strong></div>
                    <div><span class="text-slate-500">Status Perkawinan:</span> <strong class="text-slate-800 ml-1">{{ pegawai.status_perkawinan }}</strong></div>
                    <div><span class="text-slate-500">Alamat Domisili:</span> <strong class="text-slate-800 ml-1">{{ pegawai.alamat_domisili || '-' }}</strong></div>
                    <div><span class="text-slate-500">Tinggi / Berat Badan:</span> <strong class="text-slate-800 ml-1">{{ pegawai.tinggi_cm || '-' }} cm / {{ pegawai.berat_badan_kg || '-' }} kg</strong></div>
                    <div><span class="text-slate-500">Hobi / Kegemaran:</span> <strong class="text-slate-800 ml-1">{{ pegawai.hobby || '-' }}</strong></div>
                </div>
            </div>

            <!-- 2. Pendidikan Formal & Kursus -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-xs space-y-4">
                <h3 class="text-sm font-bold text-slate-800 flex items-center gap-2 border-b border-slate-100 pb-3">
                    <GraduationCap class="w-4 h-4 text-indigo-600" />
                    II. Riwayat Pendidikan Formal & Kursus
                </h3>

                <div class="space-y-2 text-xs">
                    <h4 class="font-bold text-slate-700">1. Pendidikan Formal:</h4>
                    <ul class="divide-y divide-slate-100">
                        <li v-for="pf in pegawai.pendidikan_formals" :key="pf.id" class="py-2 flex justify-between">
                            <div>
                                <div class="font-bold text-slate-800">{{ pf.degree?.nama }} - {{ pf.nama_pendidikan }} ({{ pf.jurusan || '-' }})</div>
                                <div class="text-[11px] text-slate-500">STTB/Ijazah: {{ pf.nomor_sttb || '-' }} • {{ pf.tempat }}</div>
                            </div>
                            <span class="font-bold text-indigo-600">Lulus {{ pf.tahun_lulus }}</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- 3. Riwayat Pekerjaan -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-xs space-y-4">
                <h3 class="text-sm font-bold text-slate-800 flex items-center gap-2 border-b border-slate-100 pb-3">
                    <Briefcase class="w-4 h-4 text-indigo-600" />
                    III. Riwayat Kepangkatan & Jabatan
                </h3>

                <div class="space-y-4 text-xs">
                    <div>
                        <h4 class="font-bold text-slate-700 mb-2">1. Riwayat Kepangkatan Penggajian:</h4>
                        <ul class="divide-y divide-slate-100">
                            <li v-for="rk in pegawai.riwayat_kepangkatans" :key="rk.id" class="py-2 flex justify-between">
                                <div>
                                    <div class="font-bold text-slate-800">Golongan {{ rk.pangkat?.golongan }} ({{ rk.pangkat?.pangkat }})</div>
                                    <div class="text-[11px] text-slate-500">SK No: {{ rk.sk_nomor }} • TMT: {{ rk.tmt_pangkat }}</div>
                                </div>
                                <span class="font-mono font-bold text-emerald-600">Rp {{ Number(rk.gaji_pokok).toLocaleString('id-ID') }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- 4. Keluarga & Organisasi -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-xs space-y-4">
                <h3 class="text-sm font-bold text-slate-800 flex items-center gap-2 border-b border-slate-100 pb-3">
                    <Users class="w-4 h-4 text-indigo-600" />
                    IV. Keterangan Keluarga & Organisasi
                </h3>

                <div class="space-y-3 text-xs">
                    <h4 class="font-bold text-slate-700">Anggota Keluarga:</h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div v-for="kk in pegawai.keterangan_keluargas" :key="kk.id" class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                            <div class="font-bold text-slate-800">{{ kk.nama }} ({{ kk.hub_keluarga }})</div>
                            <div class="text-[11px] text-slate-500">Pekerjaan: {{ kk.pekerjaan || '-' }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 5. Dokumen Digital -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-xs space-y-4">
                <h3 class="text-sm font-bold text-slate-800 flex items-center gap-2 border-b border-slate-100 pb-3">
                    <FileCheck2 class="w-4 h-4 text-indigo-600" />
                    V. Berkas Dokumen Digital Upload
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 text-xs">
                    <div v-for="doc in pegawai.dokumen_digitals" :key="doc.id" class="p-3 bg-slate-50 rounded-xl border border-slate-200 flex items-center justify-between">
                        <div class="truncate">
                            <div class="font-bold text-slate-800 truncate">{{ doc.nama_dokumen }}</div>
                            <div class="text-[10px] text-slate-500">{{ doc.kategori }}</div>
                        </div>
                        <a :href="`/storage/${doc.file_path}`" target="_blank" class="px-2.5 py-1 rounded bg-indigo-600 text-white font-bold text-[10px]">
                            Buka
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </AuthenticatedLayout>
</template>
