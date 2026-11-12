<script setup>
import { ref, watch } from 'vue';
import { Head, router, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {
    Building2,
    Plus,
    Search,
    Edit2,
    Trash2,
    CheckCircle2,
    AlertCircle,
    X,
    UserCheck
} from 'lucide-vue-next';

const props = defineProps({
    opds: Object,
    filters: Object,
    flash: Object,
});

const search = ref(props.filters.search || '');
const isModalOpen = ref(false);
const editingOpd = ref(null);

let searchTimeout;
watch(search, (val) => {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        router.get(route('master.opd.index'), { search: val }, { preserveState: true, replace: true });
    }, 300);
});

const form = useForm({
    kode_opd: '',
    nama_opd: '',
    singkatan: '',
    kepala_opd: '',
    nip_kepala: '',
    alamat: '',
});

const openCreateModal = () => {
    editingOpd.value = null;
    form.reset();
    form.clearErrors();
    isModalOpen.value = true;
};

const openEditModal = (opd) => {
    editingOpd.value = opd;
    form.clearErrors();
    form.kode_opd = opd.kode_opd;
    form.nama_opd = opd.nama_opd;
    form.singkatan = opd.singkatan || '';
    form.kepala_opd = opd.kepala_opd || '';
    form.nip_kepala = opd.nip_kepala || '';
    form.alamat = opd.alamat || '';
    isModalOpen.value = true;
};

const closeModal = () => {
    isModalOpen.value = false;
    form.reset();
};

const submitForm = () => {
    if (editingOpd.value) {
        form.put(route('master.opd.update', editingOpd.value.id), {
            onSuccess: () => closeModal(),
        });
    } else {
        form.post(route('master.opd.store'), {
            onSuccess: () => closeModal(),
        });
    }
};

const deleteOpd = (opd) => {
    if (confirm(`Apakah Anda yakin ingin menghapus OPD "${opd.nama_opd}"?`)) {
        router.delete(route('master.opd.destroy', opd.id));
    }
};
</script>

<template>
    <Head title="Data Master OPD / Unit Kerja - Admin" />

    <AuthenticatedLayout>
        <template #header>
            Data Master OPD / Unit Kerja
        </template>

        <div class="space-y-6 max-w-7xl mx-auto">

            <!-- Flash Alert -->
            <div v-if="flash?.success" class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-center justify-between shadow-xs">
                <div class="flex items-center gap-2">
                    <CheckCircle2 class="w-5 h-5 text-emerald-600 shrink-0" />
                    <span class="font-medium">{{ flash.success }}</span>
                </div>
            </div>

            <div v-if="flash?.error" class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-sm flex items-center justify-between shadow-xs">
                <div class="flex items-center gap-2">
                    <AlertCircle class="w-5 h-5 text-rose-600 shrink-0" />
                    <span class="font-medium">{{ flash.error }}</span>
                </div>
            </div>

            <!-- Page Title Card & Action -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h2 class="text-xl font-bold text-slate-800 tracking-tight">Kelola Organisasi Perangkat Daerah (OPD)</h2>
                    <p class="text-xs text-slate-500 mt-1">Daftar unit kerja instansi pemerintah daerah tempat pegawai ASN bertugas.</p>
                </div>

                <button
                    @click="openCreateModal"
                    class="px-4 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-bold text-xs shadow-lg shadow-indigo-600/30 transition flex items-center gap-2 self-start md:self-auto cursor-pointer"
                >
                    <Plus class="w-4 h-4" />
                    Tambah OPD Baru
                </button>
            </div>

            <!-- Search Bar -->
            <div class="bg-white rounded-2xl p-4 border border-slate-200 shadow-xs">
                <div class="relative">
                    <Search class="w-4 h-4 text-slate-400 absolute left-3.5 top-3" />
                    <input
                        v-model="search"
                        type="text"
                        placeholder="Cari berdasarkan Kode OPD, Nama Instansi, Singkatan, Nama Kepala OPD..."
                        class="w-full pl-10 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition"
                    />
                </div>
            </div>

            <!-- OPD Table -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200 text-[11px] font-bold uppercase tracking-wider text-slate-500">
                                <th class="py-3.5 px-4">Kode & Nama OPD</th>
                                <th class="py-3.5 px-4">Kepala OPD / NIP</th>
                                <th class="py-3.5 px-4">Alamat Kantor</th>
                                <th class="py-3.5 px-4 text-center">Jumlah Pegawai</th>
                                <th class="py-3.5 px-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-xs text-slate-700">
                            <tr v-if="opds.data.length === 0">
                                <td colspan="5" class="py-12 text-center text-slate-400">
                                    <Building2 class="w-10 h-10 mx-auto mb-2 text-slate-300" />
                                    <span>Belum ada data OPD terdaftar.</span>
                                </td>
                            </tr>

                            <tr v-for="opd in opds.data" :key="opd.id" class="hover:bg-slate-50/80 transition">
                                <td class="py-3.5 px-4">
                                    <div class="flex items-center gap-2">
                                        <span class="px-2 py-0.5 rounded bg-indigo-50 text-indigo-700 font-mono font-bold text-[10px]">
                                            {{ opd.kode_opd }}
                                        </span>
                                        <span v-if="opd.singkatan" class="text-xs font-bold text-slate-900">({{ opd.singkatan }})</span>
                                    </div>
                                    <div class="font-bold text-slate-800 mt-1">{{ opd.nama_opd }}</div>
                                </td>

                                <td class="py-3.5 px-4">
                                    <div class="font-semibold text-slate-800">{{ opd.kepala_opd || '-' }}</div>
                                    <div class="text-[10px] text-slate-500 font-mono mt-0.5">NIP: {{ opd.nip_kepala || '-' }}</div>
                                </td>

                                <td class="py-3.5 px-4 max-w-xs text-slate-600 truncate">
                                    {{ opd.alamat || '-' }}
                                </td>

                                <td class="py-3.5 px-4 text-center">
                                    <span class="px-2.5 py-1 rounded-full bg-slate-100 font-bold text-indigo-600 border border-slate-200">
                                        {{ opd.pegawais_count || 0 }} ASN
                                    </span>
                                </td>

                                <td class="py-3.5 px-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <button
                                            @click="openEditModal(opd)"
                                            class="p-1.5 rounded-lg bg-amber-50 text-amber-700 border border-amber-200 hover:bg-amber-100 transition cursor-pointer"
                                            title="Edit OPD"
                                        >
                                            <Edit2 class="w-3.5 h-3.5" />
                                        </button>

                                        <button
                                            @click="deleteOpd(opd)"
                                            class="p-1.5 rounded-lg bg-rose-50 text-rose-700 border border-rose-200 hover:bg-rose-100 transition cursor-pointer"
                                            title="Hapus OPD"
                                        >
                                            <Trash2 class="w-3.5 h-3.5" />
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div v-if="opds.links.length > 3" class="p-4 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                    <div>Menampilkan {{ opds.from }} s/d {{ opds.to }} dari {{ opds.total }} OPD.</div>
                    <div class="flex gap-1">
                        <Link
                            v-for="(link, k) in opds.links"
                            :key="k"
                            :href="link.url || '#'"
                            v-html="link.label"
                            :class="[
                                'px-3 py-1.5 rounded-lg text-xs font-semibold transition',
                                link.active ? 'bg-indigo-600 text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200',
                                !link.url && 'opacity-50 pointer-events-none'
                            ]"
                        />
                    </div>
                </div>
            </div>

            <!-- Create / Edit Modal -->
            <div v-if="isModalOpen" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4 z-50">
                <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-2xl border border-slate-200 relative">
                    <button @click="closeModal" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 p-1">
                        <X class="w-5 h-5" />
                    </button>

                    <h3 class="text-lg font-bold text-slate-800 mb-1">
                        {{ editingOpd ? 'Edit Data OPD' : 'Tambah OPD Baru' }}
                    </h3>
                    <p class="text-xs text-slate-500 mb-6">Lengkapi informasi unit kerja / Organisasi Perangkat Daerah.</p>

                    <form @submit.prevent="submitForm" class="space-y-4 text-xs">
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block font-semibold text-slate-700 mb-1">Kode OPD <span class="text-rose-500">*</span></label>
                                <input
                                    v-model="form.kode_opd"
                                    type="text"
                                    required
                                    placeholder="OPD-001"
                                    class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition"
                                />
                                <p v-if="form.errors.kode_opd" class="text-rose-500 mt-1">{{ form.errors.kode_opd }}</p>
                            </div>

                            <div>
                                <label class="block font-semibold text-slate-700 mb-1">Singkatan / Akronim</label>
                                <input
                                    v-model="form.singkatan"
                                    type="text"
                                    placeholder="BKPSDM"
                                    class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition"
                                />
                            </div>
                        </div>

                        <div>
                            <label class="block font-semibold text-slate-700 mb-1">Nama Lengkap OPD <span class="text-rose-500">*</span></label>
                            <input
                                v-model="form.nama_opd"
                                type="text"
                                required
                                placeholder="Badan Kepegawaian dan Pengembangan SDM"
                                class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition"
                            />
                            <p v-if="form.errors.nama_opd" class="text-rose-500 mt-1">{{ form.errors.nama_opd }}</p>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block font-semibold text-slate-700 mb-1">Nama Kepala OPD</label>
                                <input
                                    v-model="form.kepala_opd"
                                    type="text"
                                    placeholder="Drs. H. Ahmad Fauzi, M.Si"
                                    class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition"
                                />
                            </div>

                            <div>
                                <label class="block font-semibold text-slate-700 mb-1">NIP Kepala OPD</label>
                                <input
                                    v-model="form.nip_kepala"
                                    type="text"
                                    placeholder="196805121992031001"
                                    class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition"
                                />
                            </div>
                        </div>

                        <div>
                            <label class="block font-semibold text-slate-700 mb-1">Alamat Kantor</label>
                            <textarea
                                v-model="form.alamat"
                                rows="2"
                                placeholder="Jl. Praja No. 1..."
                                class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition"
                            ></textarea>
                        </div>

                        <div class="pt-4 flex justify-end gap-2 border-t border-slate-100">
                            <button
                                type="button"
                                @click="closeModal"
                                class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold transition cursor-pointer"
                            >
                                Batal
                            </button>
                            <button
                                type="submit"
                                :disabled="form.processing"
                                class="px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-bold transition shadow-md shadow-indigo-600/30 cursor-pointer"
                            >
                                {{ form.processing ? 'Menyimpan...' : 'Simpan OPD' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </AuthenticatedLayout>
</template>
