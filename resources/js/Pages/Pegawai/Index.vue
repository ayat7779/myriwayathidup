<script setup>
import { ref, watch } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {
    Users,
    Search,
    Building2,
    Eye,
    Award,
    FileText,
    CheckCircle2
} from 'lucide-vue-next';

const props = defineProps({
    pegawais: Object,
    opds: Array,
    filters: Object,
    flash: Object,
});

const search = ref(props.filters.search || '');
const selectedOpd = ref(props.filters.opd_id || '');

let searchTimeout;
watch([search, selectedOpd], () => {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        router.get(
            route('pegawai.index'),
            { search: search.value, opd_id: selectedOpd.value },
            { preserveState: true, replace: true }
        );
    }, 300);
});
</script>

<template>
    <Head title="Daftar Seluruh Pegawai ASN" />

    <AuthenticatedLayout>
        <template #header>
            Daftar Seluruh Pegawai ASN
        </template>

        <div class="space-y-6 max-w-7xl mx-auto">

            <!-- Flash Alert -->
            <div v-if="flash?.success" class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-center justify-between shadow-xs">
                <div class="flex items-center gap-2">
                    <CheckCircle2 class="w-5 h-5 text-emerald-600 shrink-0" />
                    <span class="font-medium">{{ flash.success }}</span>
                </div>
            </div>

            <!-- Page Title Card -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h2 class="text-xl font-bold text-slate-800 tracking-tight">Direktori Pegawai ASN</h2>
                    <p class="text-xs text-slate-500 mt-1">Daftar pegawai ASN terdata beserta status kelengkapan DRH dan dokumen digital.</p>
                </div>
            </div>

            <!-- Filter Controls -->
            <div class="bg-white rounded-2xl p-4 border border-slate-200 shadow-xs flex flex-col sm:flex-row gap-4">
                <div class="flex-1 relative">
                    <Search class="w-4 h-4 text-slate-400 absolute left-3.5 top-3" />
                    <input
                        v-model="search"
                        type="text"
                        placeholder="Cari NIP, Nama Lengkap, Jabatan..."
                        class="w-full pl-10 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition"
                    />
                </div>

                <div v-if="$page.props.auth?.user?.role === 'admin'" class="w-full sm:w-64">
                    <select
                        v-model="selectedOpd"
                        class="w-full py-2 px-3 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition"
                    >
                        <option value="">-- Semua Unit Kerja / OPD --</option>
                        <option v-for="opd in opds" :key="opd.id" :value="opd.id">
                            {{ opd.nama_opd }} ({{ opd.singkatan }})
                        </option>
                    </select>
                </div>
            </div>

            <!-- Pegawai Table -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200 text-[11px] font-bold uppercase tracking-wider text-slate-500">
                                <th class="py-3.5 px-4">Nama Lengkap & NIP</th>
                                <th class="py-3.5 px-4">Golongan / Pangkat</th>
                                <th class="py-3.5 px-4">Unit Kerja (OPD)</th>
                                <th class="py-3.5 px-4">Jabatan Saat Ini</th>
                                <th class="py-3.5 px-4 text-right">Aksi DRH</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-xs text-slate-700">
                            <tr v-if="pegawais.data.length === 0">
                                <td colspan="5" class="py-12 text-center text-slate-400">
                                    <Users class="w-10 h-10 mx-auto mb-2 text-slate-300" />
                                    <span>Tidak ada data pegawai ditemukan.</span>
                                </td>
                            </tr>

                            <tr v-for="p in pegawais.data" :key="p.id" class="hover:bg-slate-50/80 transition">
                                <td class="py-3.5 px-4">
                                    <div class="font-bold text-slate-900 text-sm">
                                        {{ p.gelar_depan ? p.gelar_depan + ' ' : '' }}{{ p.nama_lengkap }}{{ p.gelar_belakang ? ', ' + p.gelar_belakang : '' }}
                                    </div>
                                    <div class="text-[11px] text-slate-500 font-mono mt-0.5">
                                        NIP: {{ p.nip }}
                                    </div>
                                </td>

                                <td class="py-3.5 px-4">
                                    <span v-if="p.pangkat" class="px-2.5 py-1 rounded-lg bg-indigo-50 text-indigo-700 font-mono font-bold text-xs border border-indigo-100">
                                        Gol. {{ p.pangkat.golongan }} ({{ p.pangkat.pangkat }})
                                    </span>
                                    <span v-else class="text-slate-400 font-italic">-</span>
                                </td>

                                <td class="py-3.5 px-4">
                                    <div class="font-semibold text-slate-800">{{ p.opd?.nama_opd || '-' }}</div>
                                    <div class="text-[10px] text-slate-500 font-bold">{{ p.opd?.singkatan }}</div>
                                </td>

                                <td class="py-3.5 px-4 font-medium text-slate-700">
                                    {{ p.jabatan_saat_ini || '-' }}
                                </td>

                                <td class="py-3.5 px-4 text-right">
                                    <Link
                                        :href="route('pegawai.show', p.id)"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-indigo-50 text-indigo-700 hover:bg-indigo-100 border border-indigo-200 font-bold text-xs transition cursor-pointer"
                                    >
                                        <Eye class="w-3.5 h-3.5" />
                                        Lihat DRH
                                    </Link>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div v-if="pegawais.links.length > 3" class="p-4 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                    <div>Menampilkan {{ pegawais.from }} s/d {{ pegawais.to }} dari total {{ pegawais.total }} pegawai.</div>
                    <div class="flex gap-1">
                        <Link
                            v-for="(link, k) in pegawais.links"
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

        </div>
    </AuthenticatedLayout>
</template>
