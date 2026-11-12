<script setup>
import { ref } from 'vue';
import { Link, usePage, useForm } from '@inertiajs/vue3';
import {
    LayoutDashboard,
    UserCheck,
    FileText,
    Database,
    FolderKanban,
    Users,
    LogOut,
    Menu,
    X,
    ChevronDown,
    Building2,
    Award,
    ShieldCheck
} from 'lucide-vue-next';

const page = usePage();
const user = page.props.auth?.user;

const isMobileMenuOpen = ref(false);
const isUserDropdownOpen = ref(false);

const logoutForm = useForm({});
const logout = () => {
    logoutForm.post(route('logout'));
};
</script>

<template>
    <div class="min-h-screen bg-slate-100 flex flex-col md:flex-row font-sans">

        <!-- Sidebar Navigation (Desktop) -->
        <aside class="hidden md:flex md:w-64 bg-slate-900 text-slate-300 flex-col shrink-0 border-r border-slate-800 shadow-xl">
            <!-- App Brand Header -->
            <div class="p-5 border-b border-slate-800 flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-indigo-600 flex items-center justify-center font-bold text-xl text-white shadow-lg shadow-indigo-600/30">
                    ASN
                </div>
                <div>
                    <h1 class="font-bold text-sm text-white tracking-tight leading-none">Riwayat Hidup ASN</h1>
                    <p class="text-[10px] text-indigo-400 font-medium mt-0.5">Digital DRH Management</p>
                </div>
            </div>

            <!-- Navigation Links -->
            <nav class="flex-1 p-4 space-y-1.5 overflow-y-auto">
                <div class="text-[10px] font-bold uppercase tracking-wider text-slate-500 px-3 pt-2 pb-1">
                    Utama
                </div>

                <Link
                    href="/dashboard"
                    :class="[
                        'flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition',
                        $page.component === 'Dashboard' ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/30' : 'hover:bg-slate-800 text-slate-300 hover:text-white'
                    ]"
                >
                    <LayoutDashboard class="w-4 h-4" />
                    <span>Dashboard</span>
                </Link>

                <div v-if="user?.is_approved || user?.role === 'admin'" class="space-y-1 pt-3">
                    <div class="text-[10px] font-bold uppercase tracking-wider text-slate-500 px-3 pb-1">
                        Pegawai & DRH
                    </div>

                    <Link
                        href="/pegawai/profil"
                        :class="[
                            'flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition',
                            $page.component.startsWith('Pegawai/') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/30' : 'hover:bg-slate-800 text-slate-300 hover:text-white'
                        ]"
                    >
                        <FileText class="w-4 h-4" />
                        <span>Riwayat Hidup Saya</span>
                    </Link>

                    <Link
                        v-if="user?.role === 'admin' || user?.role === 'opd_admin'"
                        href="/pegawai"
                        :class="[
                            'flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition',
                            $page.component === 'Pegawai/Index' ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/30' : 'hover:bg-slate-800 text-slate-300 hover:text-white'
                        ]"
                    >
                        <Users class="w-4 h-4" />
                        <span>Daftar Seluruh Pegawai</span>
                    </Link>
                </div>

                <!-- Admin Management Menu -->
                <div v-if="user?.role === 'admin' || user?.role === 'opd_admin'" class="space-y-1 pt-3">
                    <div class="text-[10px] font-bold uppercase tracking-wider text-slate-500 px-3 pb-1">
                        Kelola & Master
                    </div>

                    <Link
                        v-if="user?.role === 'admin'"
                        href="/admin/users"
                        :class="[
                            'flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition',
                            $page.component === 'Admin/Users' ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/30' : 'hover:bg-slate-800 text-slate-300 hover:text-white'
                        ]"
                    >
                        <UserCheck class="w-4 h-4" />
                        <span>Persetujuan User</span>
                    </Link>

                    <Link
                        href="/master/opd"
                        :class="[
                            'flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition',
                            $page.component === 'Master/Opd' ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/30' : 'hover:bg-slate-800 text-slate-300 hover:text-white'
                        ]"
                    >
                        <Building2 class="w-4 h-4" />
                        <span>Data Master OPD</span>
                    </Link>

                    <Link
                        href="/master/pangkat"
                        :class="[
                            'flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition',
                            $page.component === 'Master/Pangkat' ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/30' : 'hover:bg-slate-800 text-slate-300 hover:text-white'
                        ]"
                    >
                        <Award class="w-4 h-4" />
                        <span>Golongan & Pangkat</span>
                    </Link>
                </div>
            </nav>

            <!-- User Footer Profile -->
            <div class="p-4 border-t border-slate-800 bg-slate-950/50 flex items-center justify-between">
                <div class="flex items-center gap-3 truncate">
                    <div class="w-8 h-8 rounded-full bg-slate-700 text-white flex items-center justify-center font-bold text-xs shrink-0">
                        {{ user?.name?.charAt(0) || 'U' }}
                    </div>
                    <div class="truncate text-left">
                        <div class="text-xs font-semibold text-white truncate">{{ user?.name }}</div>
                        <div class="text-[10px] text-slate-400 capitalize">{{ user?.role }}</div>
                    </div>
                </div>
                <button
                    @click="logout"
                    title="Keluar"
                    class="text-slate-400 hover:text-rose-400 p-1.5 rounded-lg hover:bg-slate-800 transition cursor-pointer"
                >
                    <LogOut class="w-4 h-4" />
                </button>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
            <!-- Top Navbar (Mobile & Header) -->
            <header class="bg-white border-b border-slate-200 py-3 px-4 md:px-8 flex items-center justify-between shadow-xs z-10">
                <div class="flex items-center gap-3">
                    <button
                        @click="isMobileMenuOpen = !isMobileMenuOpen"
                        class="md:hidden p-2 rounded-lg bg-slate-100 text-slate-700 hover:bg-slate-200 transition"
                    >
                        <Menu v-if="!isMobileMenuOpen" class="w-5 h-5" />
                        <X v-else class="w-5 h-5" />
                    </button>

                    <h2 class="text-lg font-bold text-slate-800 tracking-tight">
                        <slot name="header">Aplikasi Riwayat Hidup Digital ASN</slot>
                    </h2>
                </div>

                <div class="flex items-center gap-3">
                    <span v-if="user?.is_approved" class="hidden sm:inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 text-xs font-medium">
                        <ShieldCheck class="w-3.5 h-3.5" />
                        Terverifikasi
                    </span>
                    <span v-else class="hidden sm:inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-amber-50 text-amber-700 border border-amber-200 text-xs font-medium">
                        Pending Persetujuan
                    </span>

                    <div class="relative">
                        <button
                            @click="isUserDropdownOpen = !isUserDropdownOpen"
                            class="flex items-center gap-2 p-1.5 rounded-xl hover:bg-slate-100 transition cursor-pointer"
                        >
                            <div class="w-8 h-8 rounded-full bg-indigo-600 text-white flex items-center justify-center font-bold text-xs">
                                {{ user?.name?.charAt(0) || 'U' }}
                            </div>
                            <span class="text-xs font-semibold text-slate-700 hidden sm:inline">{{ user?.name }}</span>
                            <ChevronDown class="w-3.5 h-3.5 text-slate-400" />
                        </button>

                        <div
                            v-if="isUserDropdownOpen"
                            class="absolute right-0 mt-2 w-48 bg-white border border-slate-200 rounded-xl shadow-xl py-1 text-slate-700 text-xs z-50"
                        >
                            <div class="px-4 py-2 border-b border-slate-100">
                                <div class="font-bold text-slate-800 truncate">{{ user?.name }}</div>
                                <div class="text-[10px] text-slate-500 font-mono">NIP: {{ user?.nip || '-' }}</div>
                            </div>
                            <button
                                @click="logout"
                                class="w-full text-left px-4 py-2 hover:bg-rose-50 text-rose-600 flex items-center gap-2 font-medium cursor-pointer"
                            >
                                <LogOut class="w-3.5 h-3.5" />
                                Keluar Aplikasi
                            </button>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-4 md:p-8">
                <slot />
            </main>
        </div>
    </div>
</template>
