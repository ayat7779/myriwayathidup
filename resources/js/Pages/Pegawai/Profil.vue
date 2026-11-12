<script setup>
import { ref } from 'vue';
import { Head, useForm, router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {
    User,
    GraduationCap,
    Briefcase,
    Award,
    Globe,
    Users,
    Building2,
    FileCheck2,
    Save,
    Plus,
    Trash2,
    CheckCircle2,
    AlertCircle,
    Upload
} from 'lucide-vue-next';

const props = defineProps({
    pegawai: Object,
    opds: Array,
    pangkats: Array,
    pendidikanDegrees: Array,
    provinces: Array,
    flash: Object,
});

const activeTab = ref('perorangan'); // perorangan, pendidikan, pekerjaan, tandajasa, keluarga, organisasi, dokumen

// 1. Form Keterangan Perorangan
const formPerorangan = useForm({
    nama_lengkap: props.pegawai.nama_lengkap || '',
    gelar_depan: props.pegawai.gelar_depan || '',
    gelar_belakang: props.pegawai.gelar_belakang || '',
    nip: props.pegawai.nip || '',
    nik: props.pegawai.nik || '',
    opd_id: props.pegawai.opd_id || '',
    pangkat_id: props.pegawai.pangkat_id || '',
    jabatan_saat_ini: props.pegawai.jabatan_saat_ini || '',
    tempat_lahir: props.pegawai.tempat_lahir || '',
    tanggal_lahir: props.pegawai.tanggal_lahir || '',
    jenis_kelamin: props.pegawai.jenis_kelamin || 'Laki-laki',
    agama: props.pegawai.agama || 'Islam',
    status_perkawinan: props.pegawai.status_perkawinan || 'Belum Kawin',
    alamat_domisili: props.pegawai.alamat_domisili || '',
    tinggi_cm: props.pegawai.tinggi_cm || '',
    berat_badan_kg: props.pegawai.berat_badan_kg || '',
    rambut: props.pegawai.rambut || '',
    bentuk_muka: props.pegawai.bentuk_muka || '',
    warna_kulit: props.pegawai.warna_kulit || '',
    ciri_khas: props.pegawai.ciri_khas || '',
    cacat_tubuh: props.pegawai.cacat_tubuh || '',
    hobby: props.pegawai.hobby || '',
    foto: null,
});

const submitPerorangan = () => {
    formPerorangan.post(route('pegawai.updateKeteranganPerorangan', props.pegawai.id), {
        preserveScroll: true,
    });
};

// 2a. Pendidikan Formal Form
const formPF = useForm({
    jenis_lokasi: 'Dalam Negeri',
    pendidikan_degree_id: '',
    nama_pendidikan: '',
    jurusan: '',
    tahun_lulus: '',
    nomor_sttb: '',
    tempat: '',
    nama_pimpinan: '',
});

const submitPF = () => {
    formPF.post(route('pegawai.storePendidikanFormal', props.pegawai.id), {
        onSuccess: () => formPF.reset(),
        preserveScroll: true,
    });
};

const deletePF = (id) => {
    if (confirm('Hapus riwayat pendidikan ini?')) {
        router.delete(route('pegawai.destroyPendidikanFormal', id), { preserveScroll: true });
    }
};

// 2b. Pendidikan Kursus Form
const formKursus = useForm({
    jenis_lokasi: 'Dalam Negeri',
    nama_kursus: '',
    tanggal_mulai: '',
    tanggal_selesai: '',
    tahun_ijazah: '',
    nomor_ijazah: '',
    tempat: '',
    keterangan: '',
});

const submitKursus = () => {
    formKursus.post(route('pegawai.storePendidikanKursus', props.pegawai.id), {
        onSuccess: () => formKursus.reset(),
        preserveScroll: true,
    });
};

const deleteKursus = (id) => {
    if (confirm('Hapus riwayat kursus ini?')) {
        router.delete(route('pegawai.destroyPendidikanKursus', id), { preserveScroll: true });
    }
};

// 3a. Riwayat Kepangkatan Form
const formPangkat = useForm({
    pangkat_id: '',
    tmt_pangkat: '',
    gaji_pokok: 0,
    sk_pejabat: '',
    sk_nomor: '',
    sk_tanggal: '',
    dasar_peraturan: '',
});

const submitPangkat = () => {
    formPangkat.post(route('pegawai.storeRiwayatKepangkatan', props.pegawai.id), {
        onSuccess: () => formPangkat.reset(),
        preserveScroll: true,
    });
};

const deletePangkat = (id) => {
    if (confirm('Hapus riwayat kepangkatan ini?')) {
        router.delete(route('pegawai.destroyRiwayatKepangkatan', id), { preserveScroll: true });
    }
};

// 3b. Riwayat Jabatan Form
const formJabatan = useForm({
    nama_jabatan: '',
    tanggal_mulai: '',
    tanggal_selesai: '',
    pangkat_id: '',
    gaji_pokok: '',
    sk_pejabat: '',
    sk_nomor: '',
    sk_tanggal: '',
});

const submitJabatan = () => {
    formJabatan.post(route('pegawai.storeRiwayatJabatan', props.pegawai.id), {
        onSuccess: () => formJabatan.reset(),
        preserveScroll: true,
    });
};

const deleteJabatan = (id) => {
    if (confirm('Hapus riwayat jabatan ini?')) {
        router.delete(route('pegawai.destroyRiwayatJabatan', id), { preserveScroll: true });
    }
};

// 4. Tanda Jasa Form
const formTandaJasa = useForm({
    nama_penghargaan: '',
    tahun_perolehan: '',
    instansi_pemberi: '',
});

const submitTandaJasa = () => {
    formTandaJasa.post(route('pegawai.storeTandaJasa', props.pegawai.id), {
        onSuccess: () => formTandaJasa.reset(),
        preserveScroll: true,
    });
};

const deleteTandaJasa = (id) => {
    if (confirm('Hapus tanda jasa ini?')) {
        router.delete(route('pegawai.destroyTandaJasa', id), { preserveScroll: true });
    }
};

// 5. Kunjungan Luar Negeri Form
const formKunjungan = useForm({
    negara_tujuan: '',
    tujuan_kunjungan: '',
    lama_kunjungan: '',
    yang_membiayai: '',
});

const submitKunjungan = () => {
    formKunjungan.post(route('pegawai.storeKunjunganLuarNegeri', props.pegawai.id), {
        onSuccess: () => formKunjungan.reset(),
        preserveScroll: true,
    });
};

const deleteKunjungan = (id) => {
    if (confirm('Hapus data kunjungan luar negeri ini?')) {
        router.delete(route('pegawai.destroyKunjunganLuarNegeri', id), { preserveScroll: true });
    }
};

// 6. Keterangan Keluarga Form
const formKeluarga = useForm({
    hub_keluarga: 'Istri',
    nama: '',
    jenis_kelamin: 'Laki-laki',
    tempat_lahir: '',
    tanggal_lahir: '',
    umur: '',
    tanggal_nikah: '',
    pekerjaan: '',
    keterangan: '',
});

const submitKeluarga = () => {
    formKeluarga.post(route('pegawai.storeKeteranganKeluarga', props.pegawai.id), {
        onSuccess: () => formKeluarga.reset(),
        preserveScroll: true,
    });
};

const deleteKeluarga = (id) => {
    if (confirm('Hapus anggota keluarga ini?')) {
        router.delete(route('pegawai.destroyKeteranganKeluarga', id), { preserveScroll: true });
    }
};

// 7. Keterangan Organisasi Form
const formOrganisasi = useForm({
    periode: 'SLTA ke bawah',
    nama_organisasi: '',
    kedudukan: '',
    tahun_mulai: '',
    tahun_selesai: '',
    tempat: '',
    nama_pimpinan: '',
});

const submitOrganisasi = () => {
    formOrganisasi.post(route('pegawai.storeKeteranganOrganisasi', props.pegawai.id), {
        onSuccess: () => formOrganisasi.reset(),
        preserveScroll: true,
    });
};

const deleteOrganisasi = (id) => {
    if (confirm('Hapus data organisasi ini?')) {
        router.delete(route('pegawai.destroyKeteranganOrganisasi', id), { preserveScroll: true });
    }
};

// 8. Dokumen Digital Upload Form
const formDokumen = useForm({
    kategori: 'SK CPNS',
    nama_dokumen: '',
    file: null,
});

const submitDokumen = () => {
    formDokumen.post(route('pegawai.storeDokumenDigital', props.pegawai.id), {
        onSuccess: () => formDokumen.reset(),
        preserveScroll: true,
    });
};

const deleteDokumen = (id) => {
    if (confirm('Hapus dokumen digital ini?')) {
        router.delete(route('pegawai.destroyDokumenDigital', id), { preserveScroll: true });
    }
};
</script>

<template>
    <Head title="Pengisian Daftar Riwayat Hidup (DRH) ASN" />

    <AuthenticatedLayout>
        <template #header>
            Daftar Riwayat Hidup (DRH) Saya
        </template>

        <div class="space-y-6 max-w-7xl mx-auto pb-12">

            <!-- Flash Alert -->
            <div v-if="flash?.success" class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-center justify-between shadow-xs">
                <div class="flex items-center gap-2">
                    <CheckCircle2 class="w-5 h-5 text-emerald-600 shrink-0" />
                    <span class="font-medium">{{ flash.success }}</span>
                </div>
            </div>

            <!-- Page Title Card -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-xs flex flex-col md:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 rounded-2xl bg-indigo-600 text-white font-black text-xl flex items-center justify-center shadow-lg shadow-indigo-600/30 overflow-hidden shrink-0">
                        <img v-if="pegawai.foto_path" :src="`/storage/${pegawai.foto_path}`" class="w-full h-full object-cover" />
                        <span v-else>{{ pegawai.nama_lengkap?.charAt(0) }}</span>
                    </div>

                    <div>
                        <h2 class="text-xl font-bold text-slate-800 tracking-tight">
                            {{ pegawai.gelar_depan ? pegawai.gelar_depan + ' ' : '' }}{{ pegawai.nama_lengkap }}{{ pegawai.gelar_belakang ? ', ' + pegawai.gelar_belakang : '' }}
                        </h2>
                        <p class="text-xs font-mono font-bold text-indigo-600">NIP: {{ pegawai.nip }}</p>
                        <p class="text-xs text-slate-500 mt-0.5">{{ pegawai.jabatan_saat_ini || 'Jabatan Belum Diisi' }} • {{ pegawai.opd?.nama_opd }}</p>
                    </div>
                </div>
            </div>

            <!-- Navigation Tabs -->
            <div class="flex items-center gap-2 overflow-x-auto pb-2 scrollbar-none border-b border-slate-200">
                <button
                    @click="activeTab = 'perorangan'"
                    :class="[
                        'px-4 py-2.5 rounded-xl font-bold text-xs transition whitespace-nowrap flex items-center gap-2 cursor-pointer',
                        activeTab === 'perorangan' ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/30' : 'bg-white text-slate-600 hover:bg-slate-50 border border-slate-200'
                    ]"
                >
                    <User class="w-4 h-4" />
                    I. Perorangan & Badan
                </button>

                <button
                    @click="activeTab = 'pendidikan'"
                    :class="[
                        'px-4 py-2.5 rounded-xl font-bold text-xs transition whitespace-nowrap flex items-center gap-2 cursor-pointer',
                        activeTab === 'pendidikan' ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/30' : 'bg-white text-slate-600 hover:bg-slate-50 border border-slate-200'
                    ]"
                >
                    <GraduationCap class="w-4 h-4" />
                    II. Pendidikan & Kursus
                </button>

                <button
                    @click="activeTab = 'pekerjaan'"
                    :class="[
                        'px-4 py-2.5 rounded-xl font-bold text-xs transition whitespace-nowrap flex items-center gap-2 cursor-pointer',
                        activeTab === 'pekerjaan' ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/30' : 'bg-white text-slate-600 hover:bg-slate-50 border border-slate-200'
                    ]"
                >
                    <Briefcase class="w-4 h-4" />
                    III. Pangkat & Jabatan
                </button>

                <button
                    @click="activeTab = 'tandajasa'"
                    :class="[
                        'px-4 py-2.5 rounded-xl font-bold text-xs transition whitespace-nowrap flex items-center gap-2 cursor-pointer',
                        activeTab === 'tandajasa' ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/30' : 'bg-white text-slate-600 hover:bg-slate-50 border border-slate-200'
                    ]"
                >
                    <Award class="w-4 h-4" />
                    IV. Tanda Jasa & Kunjungan LN
                </button>

                <button
                    @click="activeTab = 'keluarga'"
                    :class="[
                        'px-4 py-2.5 rounded-xl font-bold text-xs transition whitespace-nowrap flex items-center gap-2 cursor-pointer',
                        activeTab === 'keluarga' ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/30' : 'bg-white text-slate-600 hover:bg-slate-50 border border-slate-200'
                    ]"
                >
                    <Users class="w-4 h-4" />
                    V. Keluarga
                </button>

                <button
                    @click="activeTab = 'organisasi'"
                    :class="[
                        'px-4 py-2.5 rounded-xl font-bold text-xs transition whitespace-nowrap flex items-center gap-2 cursor-pointer',
                        activeTab === 'organisasi' ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/30' : 'bg-white text-slate-600 hover:bg-slate-50 border border-slate-200'
                    ]"
                >
                    <Building2 class="w-4 h-4" />
                    VI. Organisasi
                </button>

                <button
                    @click="activeTab = 'dokumen'"
                    :class="[
                        'px-4 py-2.5 rounded-xl font-bold text-xs transition whitespace-nowrap flex items-center gap-2 cursor-pointer',
                        activeTab === 'dokumen' ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/30' : 'bg-white text-slate-600 hover:bg-slate-50 border border-slate-200'
                    ]"
                >
                    <FileCheck2 class="w-4 h-4" />
                    VII. Dokumen Digital
                </button>
            </div>

            <!-- TAB 1: KETERANGAN PERORANGAN & BADAN -->
            <div v-if="activeTab === 'perorangan'" class="bg-white rounded-2xl p-6 border border-slate-200 shadow-xs">
                <form @submit.prevent="submitPerorangan" class="space-y-6 text-xs">
                    <h3 class="font-bold text-slate-800 text-sm border-b border-slate-100 pb-3 flex items-center gap-2">
                        <User class="w-4 h-4 text-indigo-600" />
                        I. Keterangan Perorangan & Badan
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block font-semibold text-slate-700 mb-1">Gelar Depan</label>
                            <input v-model="formPerorangan.gelar_depan" type="text" placeholder="Drs. / Dr. / Ir." class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500" />
                        </div>
                        <div>
                            <label class="block font-semibold text-slate-700 mb-1">Nama Lengkap *</label>
                            <input v-model="formPerorangan.nama_lengkap" type="text" required class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500" />
                        </div>
                        <div>
                            <label class="block font-semibold text-slate-700 mb-1">Gelar Belakang</label>
                            <input v-model="formPerorangan.gelar_belakang" type="text" placeholder="S.Kom / M.Si" class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block font-semibold text-slate-700 mb-1">NIP (18 Digit) *</label>
                            <input v-model="formPerorangan.nip" type="text" required maxlength="18" class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl font-mono focus:ring-2 focus:ring-indigo-500" />
                        </div>
                        <div>
                            <label class="block font-semibold text-slate-700 mb-1">NIK KTP</label>
                            <input v-model="formPerorangan.nik" type="text" maxlength="16" class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl font-mono focus:ring-2 focus:ring-indigo-500" />
                        </div>
                        <div>
                            <label class="block font-semibold text-slate-700 mb-1">Unit Kerja / OPD *</label>
                            <select v-model="formPerorangan.opd_id" required class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500">
                                <option v-for="opd in opds" :key="opd.id" :value="opd.id">{{ opd.nama_opd }}</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block font-semibold text-slate-700 mb-1">Golongan & Pangkat</label>
                            <select v-model="formPerorangan.pangkat_id" class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500">
                                <option value="">-- Pilih Golongan --</option>
                                <option v-for="p in pangkats" :key="p.id" :value="p.id">Gol. {{ p.golongan }} ({{ p.pangkat }})</option>
                            </select>
                        </div>
                        <div>
                            <label class="block font-semibold text-slate-700 mb-1">Jabatan Saat Ini</label>
                            <input v-model="formPerorangan.jabatan_saat_ini" type="text" placeholder="Pranata Komputer Ahli Muda" class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500" />
                        </div>
                        <div>
                            <label class="block font-semibold text-slate-700 mb-1">Foto Profil / Pas Foto</label>
                            <input @change="formPerorangan.foto = $event.target.files[0]" type="file" accept="image/*" class="w-full p-2 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label class="block font-semibold text-slate-700 mb-1">Tempat Lahir *</label>
                            <input v-model="formPerorangan.tempat_lahir" type="text" required class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500" />
                        </div>
                        <div>
                            <label class="block font-semibold text-slate-700 mb-1">Tanggal Lahir *</label>
                            <input v-model="formPerorangan.tanggal_lahir" type="date" required class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500" />
                        </div>
                        <div>
                            <label class="block font-semibold text-slate-700 mb-1">Jenis Kelamin *</label>
                            <select v-model="formPerorangan.jenis_kelamin" required class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500">
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                        <div>
                            <label class="block font-semibold text-slate-700 mb-1">Agama *</label>
                            <select v-model="formPerorangan.agama" required class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500">
                                <option value="Islam">Islam</option>
                                <option value="Kristen">Kristen</option>
                                <option value="Katolik">Katolik</option>
                                <option value="Hindu">Hindu</option>
                                <option value="Buddha">Buddha</option>
                                <option value="Khonghucu">Khonghucu</option>
                            </select>
                        </div>
                    </div>

                    <!-- Keterangan Badan -->
                    <div class="pt-4 border-t border-slate-100">
                        <h4 class="font-bold text-slate-800 text-xs mb-3">Keterangan Badan & Hobi:</h4>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <div>
                                <label class="block text-slate-600 mb-1">Tinggi Badan (cm)</label>
                                <input v-model="formPerorangan.tinggi_cm" type="number" placeholder="170" class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl" />
                            </div>
                            <div>
                                <label class="block text-slate-600 mb-1">Berat Badan (kg)</label>
                                <input v-model="formPerorangan.berat_badan_kg" type="number" placeholder="65" class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl" />
                            </div>
                            <div>
                                <label class="block text-slate-600 mb-1">Rambut</label>
                                <input v-model="formPerorangan.rambut" type="text" placeholder="Lurus Hitam" class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl" />
                            </div>
                            <div>
                                <label class="block text-slate-600 mb-1">Bentuk Muka</label>
                                <input v-model="formPerorangan.bentuk_muka" type="text" placeholder="Lonjong" class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl" />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-3">
                            <div>
                                <label class="block text-slate-600 mb-1">Warna Kulit</label>
                                <input v-model="formPerorangan.warna_kulit" type="text" placeholder="Sawo Matang" class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl" />
                            </div>
                            <div>
                                <label class="block text-slate-600 mb-1">Ciri-ciri Khas</label>
                                <input v-model="formPerorangan.ciri_khas" type="text" placeholder="Tahi lalat dipipi" class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl" />
                            </div>
                            <div>
                                <label class="block text-slate-600 mb-1">Cacat Tubuh</label>
                                <input v-model="formPerorangan.cacat_tubuh" type="text" placeholder="Tidak ada" class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl" />
                            </div>
                        </div>

                        <div class="mt-3">
                            <label class="block text-slate-600 mb-1">Kegemaran (Hobby)</label>
                            <textarea v-model="formPerorangan.hobby" rows="2" placeholder="Membaca, Koding, Bulutangkis..." class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl"></textarea>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex justify-end">
                        <button type="submit" :disabled="formPerorangan.processing" class="px-6 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-bold transition shadow-lg shadow-indigo-600/30 flex items-center gap-2 cursor-pointer">
                            <Save class="w-4 h-4" />
                            <span>{{ formPerorangan.processing ? 'Memproses...' : 'Simpan Keterangan Perorangan' }}</span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- TAB 2: PENDIDIKAN FORMAL & KURSUS -->
            <div v-if="activeTab === 'pendidikan'" class="space-y-6">
                <!-- 2a. Form Pendidikan Formal -->
                <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-xs space-y-4">
                    <h3 class="font-bold text-slate-800 text-sm border-b border-slate-100 pb-3 flex items-center gap-2">
                        <GraduationCap class="w-4 h-4 text-indigo-600" />
                        II-A. Riwayat Pendidikan Formal (Dalam & Luar Negeri)
                    </h3>

                    <form @submit.prevent="submitPF" class="grid grid-cols-1 md:grid-cols-3 gap-3 text-xs bg-slate-50 p-4 rounded-xl border border-slate-200">
                        <div>
                            <label class="block font-semibold mb-1">Lokasi *</label>
                            <select v-model="formPF.jenis_lokasi" required class="w-full p-2 bg-white border border-slate-200 rounded-lg">
                                <option value="Dalam Negeri">Dalam Negeri</option>
                                <option value="Luar Negeri">Luar Negeri</option>
                            </select>
                        </div>

                        <div>
                            <label class="block font-semibold mb-1">Tingkat Pendidikan *</label>
                            <select v-model="formPF.pendidikan_degree_id" required class="w-full p-2 bg-white border border-slate-200 rounded-lg">
                                <option value="">-- Pilih Tingkat --</option>
                                <option v-for="d in pendidikanDegrees" :key="d.id" :value="d.id">{{ d.nama }}</option>
                            </select>
                        </div>

                        <div>
                            <label class="block font-semibold mb-1">Nama Sekolah / Universitas *</label>
                            <input v-model="formPF.nama_pendidikan" type="text" required placeholder="Universitas Gadjah Mada" class="w-full p-2 bg-white border border-slate-200 rounded-lg" />
                        </div>

                        <div>
                            <label class="block font-semibold mb-1">Jurusan / Program Studi</label>
                            <input v-model="formPF.jurusan" type="text" placeholder="Teknik Informatika" class="w-full p-2 bg-white border border-slate-200 rounded-lg" />
                        </div>

                        <div>
                            <label class="block font-semibold mb-1">Tahun Lulus *</label>
                            <input v-model="formPF.tahun_lulus" type="text" required placeholder="2012" class="w-full p-2 bg-white border border-slate-200 rounded-lg" />
                        </div>

                        <div>
                            <label class="block font-semibold mb-1">Nomor STTB / Ijazah</label>
                            <input v-model="formPF.nomor_sttb" type="text" placeholder="1234/STTB/2012" class="w-full p-2 bg-white border border-slate-200 rounded-lg" />
                        </div>

                        <div>
                            <label class="block font-semibold mb-1">Tempat / Kota *</label>
                            <input v-model="formPF.tempat" type="text" required placeholder="Yogyakarta" class="w-full p-2 bg-white border border-slate-200 rounded-lg" />
                        </div>

                        <div>
                            <label class="block font-semibold mb-1">Nama Kepala / Dekan / Rektor</label>
                            <input v-model="formPF.nama_pimpinan" type="text" placeholder="Prof. Dr. M. Nuh" class="w-full p-2 bg-white border border-slate-200 rounded-lg" />
                        </div>

                        <div class="flex items-end">
                            <button type="submit" :disabled="formPF.processing" class="w-full py-2 px-3 bg-indigo-600 hover:bg-indigo-500 text-white font-bold rounded-lg transition flex items-center justify-center gap-1 cursor-pointer">
                                <Plus class="w-4 h-4" />
                                <span>Tambah Pendidikan</span>
                            </button>
                        </div>
                    </form>

                    <!-- Table Pendidikan Formal -->
                    <div class="overflow-x-auto text-xs">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-100 text-[10px] font-bold uppercase text-slate-500 border-b border-slate-200">
                                    <th class="p-2">Tingkat & Sekolah</th>
                                    <th class="p-2">Jurusan</th>
                                    <th class="p-2">Tahun / STTB</th>
                                    <th class="p-2">Tempat & Pimpinan</th>
                                    <th class="p-2 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                <tr v-for="pf in pegawai.pendidikan_formals" :key="pf.id">
                                    <td class="p-2">
                                        <div class="font-bold text-slate-800">{{ pf.degree?.nama }} - {{ pf.nama_pendidikan }}</div>
                                        <div class="text-[10px] text-slate-500">{{ pf.jenis_lokasi }}</div>
                                    </td>
                                    <td class="p-2">{{ pf.jurusan || '-' }}</td>
                                    <td class="p-2">
                                        <div class="font-bold text-indigo-600">{{ pf.tahun_lulus }}</div>
                                        <div class="text-[10px] text-slate-500">{{ pf.nomor_sttb || '-' }}</div>
                                    </td>
                                    <td class="p-2">{{ pf.tempat }} ({{ pf.nama_pimpinan || '-' }})</td>
                                    <td class="p-2 text-right">
                                        <button @click="deletePF(pf.id)" class="p-1 rounded text-rose-600 hover:bg-rose-50"><Trash2 class="w-4 h-4" /></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- 2b. Form Kursus / Pelatihan -->
                <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-xs space-y-4">
                    <h3 class="font-bold text-slate-800 text-sm border-b border-slate-100 pb-3 flex items-center gap-2">
                        <Award class="w-4 h-4 text-indigo-600" />
                        II-B. Kursus / Pelatihan (Dalam & Luar Negeri)
                    </h3>

                    <form @submit.prevent="submitKursus" class="grid grid-cols-1 md:grid-cols-3 gap-3 text-xs bg-slate-50 p-4 rounded-xl border border-slate-200">
                        <div>
                            <label class="block font-semibold mb-1">Nama Kursus / Pelatihan *</label>
                            <input v-model="formKursus.nama_kursus" type="text" required placeholder="Diklat Pim III" class="w-full p-2 bg-white border border-slate-200 rounded-lg" />
                        </div>

                        <div>
                            <label class="block font-semibold mb-1">Tanggal Mulai s/d Selesai</label>
                            <div class="grid grid-cols-2 gap-1">
                                <input v-model="formKursus.tanggal_mulai" type="date" class="p-1.5 bg-white border border-slate-200 rounded-lg text-[11px]" />
                                <input v-model="formKursus.tanggal_selesai" type="date" class="p-1.5 bg-white border border-slate-200 rounded-lg text-[11px]" />
                            </div>
                        </div>

                        <div>
                            <label class="block font-semibold mb-1">Tempat *</label>
                            <input v-model="formKursus.tempat" type="text" required placeholder="Jakarta" class="w-full p-2 bg-white border border-slate-200 rounded-lg" />
                        </div>

                        <div>
                            <label class="block font-semibold mb-1">Nomor / Tahun Ijazah</label>
                            <input v-model="formKursus.nomor_ijazah" type="text" placeholder="123/DIKLAT/2020" class="w-full p-2 bg-white border border-slate-200 rounded-lg" />
                        </div>

                        <div class="md:col-span-2 flex items-end gap-2">
                            <input v-model="formKursus.keterangan" type="text" placeholder="Keterangan..." class="w-full p-2 bg-white border border-slate-200 rounded-lg" />
                            <button type="submit" :disabled="formKursus.processing" class="py-2 px-4 bg-indigo-600 hover:bg-indigo-500 text-white font-bold rounded-lg transition flex items-center gap-1 shrink-0 cursor-pointer">
                                <Plus class="w-4 h-4" />
                                <span>Tambah Kursus</span>
                            </button>
                        </div>
                    </form>

                    <!-- Table Kursus -->
                    <div class="overflow-x-auto text-xs">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-100 text-[10px] font-bold uppercase text-slate-500 border-b border-slate-200">
                                    <th class="p-2">Nama Kursus</th>
                                    <th class="p-2">Tanggal / Tempat</th>
                                    <th class="p-2">No. Ijazah</th>
                                    <th class="p-2 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                <tr v-for="k in pegawai.pendidikan_kursuses" :key="k.id">
                                    <td class="p-2 font-bold text-slate-800">{{ k.nama_kursus }}</td>
                                    <td class="p-2">{{ k.tanggal_mulai }} s/d {{ k.tanggal_selesai }} ({{ k.tempat }})</td>
                                    <td class="p-2">{{ k.nomor_ijazah || '-' }}</td>
                                    <td class="p-2 text-right">
                                        <button @click="deleteKursus(k.id)" class="p-1 rounded text-rose-600 hover:bg-rose-50"><Trash2 class="w-4 h-4" /></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- TAB 3: PANGKAT & JABATAN -->
            <div v-if="activeTab === 'pekerjaan'" class="space-y-6">
                <!-- 3a. Form Riwayat Kepangkatan -->
                <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-xs space-y-4">
                    <h3 class="font-bold text-slate-800 text-sm border-b border-slate-100 pb-3 flex items-center gap-2">
                        <Briefcase class="w-4 h-4 text-indigo-600" />
                        III-A. Riwayat Kepangkatan & Golongan Ruang Penggajian
                    </h3>

                    <form @submit.prevent="submitPangkat" class="grid grid-cols-1 md:grid-cols-3 gap-3 text-xs bg-slate-50 p-4 rounded-xl border border-slate-200">
                        <div>
                            <label class="block font-semibold mb-1">Golongan & Pangkat *</label>
                            <select v-model="formPangkat.pangkat_id" required class="w-full p-2 bg-white border border-slate-200 rounded-lg">
                                <option value="">-- Pilih --</option>
                                <option v-for="p in pangkats" :key="p.id" :value="p.id">Gol. {{ p.golongan }} ({{ p.pangkat }})</option>
                            </select>
                        </div>

                        <div>
                            <label class="block font-semibold mb-1">TMT Pangkat *</label>
                            <input v-model="formPangkat.tmt_pangkat" type="date" required class="w-full p-2 bg-white border border-slate-200 rounded-lg" />
                        </div>

                        <div>
                            <label class="block font-semibold mb-1">Gaji Pokok (Rp) *</label>
                            <input v-model="formPangkat.gaji_pokok" type="number" required placeholder="3000000" class="w-full p-2 bg-white border border-slate-200 rounded-lg" />
                        </div>

                        <div>
                            <label class="block font-semibold mb-1">Pejabat SK *</label>
                            <input v-model="formPangkat.sk_pejabat" type="text" required placeholder="Bupati / Kepala BKPSDM" class="w-full p-2 bg-white border border-slate-200 rounded-lg" />
                        </div>

                        <div>
                            <label class="block font-semibold mb-1">Nomor SK *</label>
                            <input v-model="formPangkat.sk_nomor" type="text" required placeholder="821/SK/2022" class="w-full p-2 bg-white border border-slate-200 rounded-lg" />
                        </div>

                        <div>
                            <label class="block font-semibold mb-1">Tanggal SK *</label>
                            <input v-model="formPangkat.sk_tanggal" type="date" required class="w-full p-2 bg-white border border-slate-200 rounded-lg" />
                        </div>

                        <div class="md:col-span-3 flex justify-end">
                            <button type="submit" :disabled="formPangkat.processing" class="py-2 px-4 bg-indigo-600 hover:bg-indigo-500 text-white font-bold rounded-lg transition flex items-center gap-1 cursor-pointer">
                                <Plus class="w-4 h-4" />
                                <span>Tambah Riwayat Pangkat</span>
                            </button>
                        </div>
                    </form>

                    <!-- Table Kepangkatan -->
                    <div class="overflow-x-auto text-xs">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-100 text-[10px] font-bold uppercase text-slate-500 border-b border-slate-200">
                                    <th class="p-2">Golongan / Pangkat</th>
                                    <th class="p-2">TMT</th>
                                    <th class="p-2">Gaji Pokok</th>
                                    <th class="p-2">Nomor & Pejabat SK</th>
                                    <th class="p-2 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                <tr v-for="rk in pegawai.riwayat_kepangkatans" :key="rk.id">
                                    <td class="p-2 font-bold text-slate-800">Gol. {{ rk.pangkat?.golongan }} ({{ rk.pangkat?.pangkat }})</td>
                                    <td class="p-2">{{ rk.tmt_pangkat }}</td>
                                    <td class="p-2 font-mono font-bold text-emerald-600">Rp {{ Number(rk.gaji_pokok).toLocaleString('id-ID') }}</td>
                                    <td class="p-2">{{ rk.sk_nomor }} ({{ rk.sk_pejabat }})</td>
                                    <td class="p-2 text-right">
                                        <button @click="deletePangkat(rk.id)" class="p-1 rounded text-rose-600 hover:bg-rose-50"><Trash2 class="w-4 h-4" /></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- TAB 4: TANDA JASA & KUNJUNGAN LN -->
            <div v-if="activeTab === 'tandajasa'" class="space-y-6">
                <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-xs space-y-4">
                    <h3 class="font-bold text-slate-800 text-sm border-b border-slate-100 pb-3 flex items-center gap-2">
                        <Award class="w-4 h-4 text-indigo-600" />
                        IV-A. Tanda Jasa / Penghargaan
                    </h3>

                    <form @submit.prevent="submitTandaJasa" class="grid grid-cols-1 md:grid-cols-3 gap-3 text-xs bg-slate-50 p-4 rounded-xl border border-slate-200">
                        <div>
                            <label class="block font-semibold mb-1">Nama Penghargaan *</label>
                            <input v-model="formTandaJasa.nama_penghargaan" type="text" required placeholder="Satyalancana Karya Satya X Tahun" class="w-full p-2 bg-white border border-slate-200 rounded-lg" />
                        </div>
                        <div>
                            <label class="block font-semibold mb-1">Tahun Perolehan *</label>
                            <input v-model="formTandaJasa.tahun_perolehan" type="text" required placeholder="2020" class="w-full p-2 bg-white border border-slate-200 rounded-lg" />
                        </div>
                        <div>
                            <label class="block font-semibold mb-1">Instansi Pemberi *</label>
                            <input v-model="formTandaJasa.instansi_pemberi" type="text" required placeholder="Presiden Republik Indonesia" class="w-full p-2 bg-white border border-slate-200 rounded-lg" />
                        </div>
                        <div class="md:col-span-3 flex justify-end">
                            <button type="submit" :disabled="formTandaJasa.processing" class="py-2 px-4 bg-indigo-600 text-white font-bold rounded-lg cursor-pointer">
                                + Tambah Tanda Jasa
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- TAB 5: KELUARGA -->
            <div v-if="activeTab === 'keluarga'" class="bg-white rounded-2xl p-6 border border-slate-200 shadow-xs space-y-4">
                <h3 class="font-bold text-slate-800 text-sm border-b border-slate-100 pb-3 flex items-center gap-2">
                    <Users class="w-4 h-4 text-indigo-600" />
                    V. Keterangan Keluarga (Pasangan, Anak, Orang Tua, Mertua, Saudara)
                </h3>

                <form @submit.prevent="submitKeluarga" class="grid grid-cols-1 md:grid-cols-3 gap-3 text-xs bg-slate-50 p-4 rounded-xl border border-slate-200">
                    <div>
                        <label class="block font-semibold mb-1">Hubungan Keluarga *</label>
                        <select v-model="formKeluarga.hub_keluarga" required class="w-full p-2 bg-white border border-slate-200 rounded-lg">
                            <option value="Istri">Istri</option>
                            <option value="Suami">Suami</option>
                            <option value="Anak">Anak</option>
                            <option value="Bapak Kandung">Bapak Kandung</option>
                            <option value="Ibu Kandung">Ibu Kandung</option>
                            <option value="Bapak Mertua">Bapak Mertua</option>
                            <option value="Ibu Mertua">Ibu Mertua</option>
                            <option value="Saudara Kandung">Saudara Kandung</option>
                        </select>
                    </div>

                    <div>
                        <label class="block font-semibold mb-1">Nama Lengkap *</label>
                        <input v-model="formKeluarga.nama" type="text" required placeholder="Nama Anggota Keluarga" class="w-full p-2 bg-white border border-slate-200 rounded-lg" />
                    </div>

                    <div>
                        <label class="block font-semibold mb-1">Pekerjaan</label>
                        <input v-model="formKeluarga.pekerjaan" type="text" placeholder="PNS / Swasta / Pelajar" class="w-full p-2 bg-white border border-slate-200 rounded-lg" />
                    </div>

                    <div class="md:col-span-3 flex justify-end">
                        <button type="submit" :disabled="formKeluarga.processing" class="py-2 px-4 bg-indigo-600 text-white font-bold rounded-lg cursor-pointer">
                            + Tambah Anggota Keluarga
                        </button>
                    </div>
                </form>

                <div class="overflow-x-auto text-xs">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-100 text-[10px] font-bold uppercase text-slate-500 border-b border-slate-200">
                                <th class="p-2">Hubungan</th>
                                <th class="p-2">Nama Lengkap</th>
                                <th class="p-2">Pekerjaan</th>
                                <th class="p-2 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <tr v-for="kk in pegawai.keterangan_keluargas" :key="kk.id">
                                <td class="p-2 font-bold text-indigo-600">{{ kk.hub_keluarga }}</td>
                                <td class="p-2 font-bold text-slate-800">{{ kk.nama }}</td>
                                <td class="p-2">{{ kk.pekerjaan || '-' }}</td>
                                <td class="p-2 text-right">
                                    <button @click="deleteKeluarga(kk.id)" class="p-1 text-rose-600"><Trash2 class="w-4 h-4" /></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- TAB 7: DOKUMEN DIGITAL -->
            <div v-if="activeTab === 'dokumen'" class="bg-white rounded-2xl p-6 border border-slate-200 shadow-xs space-y-4">
                <h3 class="font-bold text-slate-800 text-sm border-b border-slate-100 pb-3 flex items-center gap-2">
                    <FileCheck2 class="w-4 h-4 text-indigo-600" />
                    VII. Manajemen Dokumen Digital ASN
                </h3>

                <form @submit.prevent="submitDokumen" class="grid grid-cols-1 md:grid-cols-3 gap-3 text-xs bg-slate-50 p-4 rounded-xl border border-slate-200">
                    <div>
                        <label class="block font-semibold mb-1">Kategori Dokumen *</label>
                        <select v-model="formDokumen.kategori" required class="w-full p-2 bg-white border border-slate-200 rounded-lg">
                            <option value="KTP">KTP</option>
                            <option value="NPWP">NPWP</option>
                            <option value="SK CPNS">SK CPNS</option>
                            <option value="SK PNS">SK PNS</option>
                            <option value="SK Pangkat">SK Pangkat</option>
                            <option value="SK Jabatan">SK Jabatan</option>
                            <option value="Ijazah">Ijazah</option>
                            <option value="Transkrip">Transkrip Nilai</option>
                            <option value="Sertifikat">Sertifikat Kursus/Pelatihan</option>
                            <option value="KK">Kartu Keluarga (KK)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block font-semibold mb-1">Nama / Judul Dokumen *</label>
                        <input v-model="formDokumen.nama_dokumen" type="text" required placeholder="Scan SK CPNS 2014" class="w-full p-2 bg-white border border-slate-200 rounded-lg" />
                    </div>

                    <div>
                        <label class="block font-semibold mb-1">Pilih File (PDF/JPG/PNG max 5MB) *</label>
                        <input @change="formDokumen.file = $event.target.files[0]" type="file" required accept=".pdf,.png,.jpg,.jpeg" class="w-full p-1.5 bg-white border border-slate-200 rounded-lg" />
                    </div>

                    <div class="md:col-span-3 flex justify-end">
                        <button type="submit" :disabled="formDokumen.processing" class="py-2 px-4 bg-indigo-600 text-white font-bold rounded-lg flex items-center gap-1 cursor-pointer">
                            <Upload class="w-4 h-4" />
                            <span>Upload Dokumen</span>
                        </button>
                    </div>
                </form>

                <!-- Table Dokumen Upload -->
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3 text-xs">
                    <div v-for="doc in pegawai.dokumen_digitals" :key="doc.id" class="p-3 bg-slate-50 border border-slate-200 rounded-xl flex items-center justify-between">
                        <div class="truncate">
                            <div class="font-bold text-slate-800 truncate">{{ doc.nama_dokumen }}</div>
                            <div class="text-[10px] text-indigo-600 font-semibold">{{ doc.kategori }}</div>
                        </div>
                        <div class="flex items-center gap-1">
                            <a :href="`/storage/${doc.file_path}`" target="_blank" class="px-2 py-1 bg-indigo-50 text-indigo-700 font-bold text-[10px] rounded hover:bg-indigo-100">Buka</a>
                            <button @click="deleteDokumen(doc.id)" class="p-1 text-rose-600 hover:bg-rose-50 rounded"><Trash2 class="w-3.5 h-3.5" /></button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </AuthenticatedLayout>
</template>
