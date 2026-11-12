<script setup>
import { ref, watch } from 'vue';
import { Head, router, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {
    UserCheck,
    Search,
    Filter,
    CheckCircle2,
    XCircle,
    Building2,
    Mail,
    Phone,
    CreditCard,
    AlertCircle,
    Check,
    Trash2
} from 'lucide-vue-next';

const props = defineProps({
    users: Object,
    opds: Array,
    filters: Object,
    flash: Object,
});

const search = ref(props.filters.search || '');
const selectedOpd = ref(props.filters.opd_id || '');
const selectedStatus = ref(props.filters.status || 'pending');

let searchTimeout;
watch([search, selectedOpd, selectedStatus], () => {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        router.get(
            route('admin.users.index'),
            {
                search: search.value,
                opd_id: selectedOpd.value,
                status: selectedStatus.value,
            },
            { preserveState: true, replace: true }
        );
    }, 300);
});

const approveUser = (user) => {
    if (confirm(`Apakah Anda yakin ingin menyetujui pendaftaran pegawai ${user.name} (NIP: ${user.nip})?`)) {
        router.post(route('admin.users.approve', user.id));
    }
};

const rejectUser = (user) => {
    if (confirm(`Peringatan: Pendaftaran ${user.name} akan ditolak dan dihapus. Lanjutkan?`)) {
        router.post(route('admin.users.reject', user.id));
    }
};
</script>

<template>
    <Head title="Kelola Persetujuan User Pegawai - Admin" />

    <AuthenticatedLayout>
        <template #header>
            Kelola Persetujuan User Pegawai
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
                    <h2 class="text-xl font-bold text-slate-800 tracking-tight">Persetujuan Registrasi Pegawai</h2>
                    <p class="text-xs text-slate-500 mt-1">Verifikasi dan beri hak akses login bagi pegawai baru di lingkungan OPD Anda.</p>
                </div>

                <!-- Status Filter Tabs -->
                <div class="flex rounded-xl bg-slate-100 p-1 border border-slate-200 self-start md:self-auto">
                    <button
                        @click="selectedStatus = 'pending'"
                        :class="[
                            'px-4 py-2 rounded-lg text-xs font-bold transition cursor-pointer',
                            selectedStatus === 'pending' ? 'bg-white text-indigo-600 shadow-xs' : 'text-slate-600 hover:text-slate-900'
                        ]"
                    >
                        Pending Approval
                    </button>
                    <button
                        @click="selectedStatus = 'approved'"
                        :class="[
                            'px-4 py-2 rounded-lg text-xs font-bold transition cursor-pointer',
                            selectedStatus === 'approved' ? 'bg-white text-emerald-600 shadow-xs' : 'text-slate-600 hover:text-slate-900'
                        ]"
                    >
                        Disetujui
                    </button>
                    <button
                        @click="selectedStatus = 'all'"
                        :class="[
                            'px-4 py-2 rounded-lg text-xs font-bold transition cursor-pointer',
                            selectedStatus === 'all' ? 'bg-white text-slate-900 shadow-xs' : 'text-slate-600 hover:text-slate-900'
                        ]"
                    >
                        Semua Akun
                    </button>
                </div>
            </div>

            <!-- Filter Controls Bar -->
            <div class="bg-white rounded-2xl p-4 border border-slate-200 shadow-xs flex flex-col sm:flex-row gap-4">
                <!-- Search Box -->
                <div class="flex-1 relative">
                    <Search class="w-4 h-4 text-slate-400 absolute left-3.5 top-3" />
                    <input
                        v-model="search"
                        type="text"
                        placeholder="Cari berdasarkan Nama, NIP, NIK, No. Telp, Email..."
                        class="w-full pl-10 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition"
                    />
                </div>

                <!-- OPD Filter Dropdown -->
                <div class="w-full sm:w-64">
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

            <!-- Users Data Table -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200 text-[11px] font-bold uppercase tracking-wider text-slate-500">
                                <th class="py-3.5 px-4">Pegawai / Identitas</th>
                                <th class="py-3.5 px-4">Unit Kerja (OPD)</th>
                                <th class="py-3.5 px-4">Kontak</th>
                                <th class="py-3.5 px-4 text-center">Status</th>
                                <th class="py-3.5 px-4 text-right">Aksi Persetujuan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-xs text-slate-700">
                            <tr v-if="users.data.length === 0">
                                <td colspan="5" class="py-12 text-center text-slate-400">
                                    <UserCheck class="w-10 h-10 mx-auto mb-2 text-slate-300" />
                                    <span>Tidak ada pendaftaran user ditemukan.</span>
                                </td>
                            </tr>

                            <tr v-for="u in users.data" :key="u.id" class="hover:bg-slate-50/80 transition">
                                <td class="py-3.5 px-4">
                                    <div class="font-bold text-slate-900 text-sm">{{ u.name }}</div>
                                    <div class="flex items-center gap-3 text-[11px] text-slate-500 mt-1 font-mono">
                                        <span>NIP: {{ u.nip || '-' }}</span>
                                        <span>•</span>
                                        <span>NIK: {{ u.nik || '-' }}</span>
                                    </div>
                                </td>

                                <td class="py-3.5 px-4">
                                    <div class="font-semibold text-slate-800">{{ u.opd?.nama_opd || 'Belum Diatur' }}</div>
                                    <div class="text-[10px] text-slate-500 font-semibold">{{ u.opd?.singkatan }}</div>
                                </td>

                                <td class="py-3.5 px-4 space-y-0.5">
                                    <div class="flex items-center gap-1.5 text-slate-600">
                                        <Mail class="w-3.5 h-3.5 text-slate-400 shrink-0" />
                                        <span class="truncate">{{ u.email }}</span>
                                    </div>
                                    <div class="flex items-center gap-1.5 text-slate-600">
                                        <Phone class="w-3.5 h-3.5 text-slate-400 shrink-0" />
                                        <span>{{ u.phone || '-' }}</span>
                                    </div>
                                </td>

                                <td class="py-3.5 px-4 text-center">
                                    <span
                                        v-if="u.is_approved"
                                        class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 text-[10px] font-bold"
                                    >
                                        <CheckCircle2 class="w-3 h-3" />
                                        Disetujui
                                    </span>
                                    <span
                                        v-else
                                        class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-amber-50 text-amber-700 border border-amber-200 text-[10px] font-bold"
                                    >
                                        <XCircle class="w-3 h-3" />
                                        Pending
                                    </span>
                                </td>

                                <td class="py-3.5 px-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <button
                                            v-if="!u.is_approved"
                                            @click="approveUser(u)"
                                            class="px-3 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-500 text-white font-semibold text-xs transition shadow-xs flex items-center gap-1 cursor-pointer"
                                        >
                                            <Check class="w-3.5 h-3.5" />
                                            Setujui
                                        </button>

                                        <button
                                            @click="rejectUser(u)"
                                            class="px-3 py-1.5 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 font-semibold text-xs transition flex items-center gap-1 cursor-pointer"
                                            title="Tolak / Hapus Registrasi"
                                        >
                                            <Trash2 class="w-3.5 h-3.5" />
                                            Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination Links -->
                <div v-if="users.links.length > 3" class="p-4 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                    <div>
                        Menampilkan {{ users.from }} s/d {{ users.to }} dari total {{ users.total }} pendaftaran.
                    </div>
                    <div class="flex gap-1">
                        <Link
                            v-for="(link, k) in users.links"
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
