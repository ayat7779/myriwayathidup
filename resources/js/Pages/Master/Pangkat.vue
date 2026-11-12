<script setup>
import { ref } from 'vue';
import { Head, router, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {
    Award,
    Plus,
    Edit2,
    Trash2,
    CheckCircle2,
    AlertCircle,
    X
} from 'lucide-vue-next';

const props = defineProps({
    pangkats: Array,
    flash: Object,
});

const isModalOpen = ref(false);
const editingPangkat = ref(null);

const form = useForm({
    golongan: '',
    pangkat: '',
    tingkat: 1,
});

const openCreateModal = () => {
    editingPangkat.value = null;
    form.reset();
    form.clearErrors();
    form.tingkat = (props.pangkats.length || 0) + 1;
    isModalOpen.value = true;
};

const openEditModal = (item) => {
    editingPangkat.value = item;
    form.clearErrors();
    form.golongan = item.golongan;
    form.pangkat = item.pangkat;
    form.tingkat = item.tingkat;
    isModalOpen.value = true;
};

const closeModal = () => {
    isModalOpen.value = false;
    form.reset();
};

const submitForm = () => {
    if (editingPangkat.value) {
        form.put(route('master.pangkat.update', editingPangkat.value.id), {
            onSuccess: () => closeModal(),
        });
    } else {
        form.post(route('master.pangkat.store'), {
            onSuccess: () => closeModal(),
        });
    }
};

const deletePangkat = (item) => {
    if (confirm(`Apakah Anda yakin ingin menghapus Golongan ${item.golongan}?`)) {
        router.delete(route('master.pangkat.destroy', item.id));
    }
};
</script>

<template>
    <Head title="Data Master Golongan & Pangkat ASN" />

    <AuthenticatedLayout>
        <template #header>
            Data Master Golongan & Pangkat ASN
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

            <!-- Header Title -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h2 class="text-xl font-bold text-slate-800 tracking-tight">Golongan & Pangkat ASN</h2>
                    <p class="text-xs text-slate-500 mt-1">Struktur hirarki kepangkatan pegawai PNS/ASN (I/a s/d IV/e).</p>
                </div>

                <button
                    @click="openCreateModal"
                    class="px-4 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-bold text-xs shadow-lg shadow-indigo-600/30 transition flex items-center gap-2 self-start md:self-auto cursor-pointer"
                >
                    <Plus class="w-4 h-4" />
                    Tambah Golongan Baru
                </button>
            </div>

            <!-- Pangkat Table -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200 text-[11px] font-bold uppercase tracking-wider text-slate-500">
                                <th class="py-3.5 px-4 text-center w-16">Urutan</th>
                                <th class="py-3.5 px-4">Golongan / Ruang</th>
                                <th class="py-3.5 px-4">Nama Pangkat</th>
                                <th class="py-3.5 px-4 text-center">Jumlah Pegawai</th>
                                <th class="py-3.5 px-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-xs text-slate-700">
                            <tr v-if="pangkats.length === 0">
                                <td colspan="5" class="py-12 text-center text-slate-400">
                                    <Award class="w-10 h-10 mx-auto mb-2 text-slate-300" />
                                    <span>Belum ada data kepangkatan.</span>
                                </td>
                            </tr>

                            <tr v-for="item in pangkats" :key="item.id" class="hover:bg-slate-50/80 transition">
                                <td class="py-3.5 px-4 text-center font-mono font-bold text-slate-500">
                                    #{{ item.tingkat }}
                                </td>

                                <td class="py-3.5 px-4">
                                    <span class="px-2.5 py-1 rounded-lg bg-indigo-50 text-indigo-700 font-mono font-bold text-xs border border-indigo-100">
                                        Golongan {{ item.golongan }}
                                    </span>
                                </td>

                                <td class="py-3.5 px-4 font-bold text-slate-800">
                                    {{ item.pangkat }}
                                </td>

                                <td class="py-3.5 px-4 text-center">
                                    <span class="px-2.5 py-1 rounded-full bg-slate-100 font-bold text-slate-700 border border-slate-200">
                                        {{ item.pegawais_count || 0 }} Pegawai
                                    </span>
                                </td>

                                <td class="py-3.5 px-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <button
                                            @click="openEditModal(item)"
                                            class="p-1.5 rounded-lg bg-amber-50 text-amber-700 border border-amber-200 hover:bg-amber-100 transition cursor-pointer"
                                            title="Edit"
                                        >
                                            <Edit2 class="w-3.5 h-3.5" />
                                        </button>

                                        <button
                                            @click="deletePangkat(item)"
                                            class="p-1.5 rounded-lg bg-rose-50 text-rose-700 border border-rose-200 hover:bg-rose-100 transition cursor-pointer"
                                            title="Hapus"
                                        >
                                            <Trash2 class="w-3.5 h-3.5" />
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Modal Form -->
            <div v-if="isModalOpen" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4 z-50">
                <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl border border-slate-200 relative">
                    <button @click="closeModal" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 p-1">
                        <X class="w-5 h-5" />
                    </button>

                    <h3 class="text-lg font-bold text-slate-800 mb-1">
                        {{ editingPangkat ? 'Edit Golongan & Pangkat' : 'Tambah Golongan Baru' }}
                    </h3>
                    <p class="text-xs text-slate-500 mb-6">Isi rincian nama pangkat dan golongan ruang.</p>

                    <form @submit.prevent="submitForm" class="space-y-4 text-xs">
                        <div>
                            <label class="block font-semibold text-slate-700 mb-1">Golongan / Ruang <span class="text-rose-500">*</span></label>
                            <input
                                v-model="form.golongan"
                                type="text"
                                required
                                placeholder="misal: III/c"
                                class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition"
                            />
                            <p v-if="form.errors.golongan" class="text-rose-500 mt-1">{{ form.errors.golongan }}</p>
                        </div>

                        <div>
                            <label class="block font-semibold text-slate-700 mb-1">Nama Pangkat <span class="text-rose-500">*</span></label>
                            <input
                                v-model="form.pangkat"
                                type="text"
                                required
                                placeholder="misal: Penata"
                                class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition"
                            />
                            <p v-if="form.errors.pangkat" class="text-rose-500 mt-1">{{ form.errors.pangkat }}</p>
                        </div>

                        <div>
                            <label class="block font-semibold text-slate-700 mb-1">Urutan Tingkat (1 - 20) <span class="text-rose-500">*</span></label>
                            <input
                                v-model="form.tingkat"
                                type="number"
                                required
                                class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition"
                            />
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
                                {{ form.processing ? 'Menyimpan...' : 'Simpan Data' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </AuthenticatedLayout>
</template>
