<script setup>
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ShieldCheck, UserCheck, Lock, ArrowRight, AlertCircle } from 'lucide-vue-next';

defineProps({
    status: String,
    flash: Object,
});

const form = useForm({
    login: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <Head title="Masuk - Aplikasi Riwayat Hidup Digital ASN" />

    <div class="min-h-screen bg-slate-950 flex flex-col justify-center py-12 sm:px-6 lg:px-8 relative overflow-hidden">
        <!-- Background Gradient Glows -->
        <div class="absolute -top-40 -left-40 w-96 h-96 bg-indigo-600/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-40 -right-40 w-96 h-96 bg-emerald-600/20 rounded-full blur-3xl pointer-events-none"></div>

        <div class="sm:mx-auto sm:w-full sm:max-w-md text-center relative z-10">
            <Link href="/" class="inline-flex items-center gap-3 group">
                <div class="w-12 h-12 rounded-2xl bg-indigo-600 flex items-center justify-center font-black text-2xl text-white shadow-xl shadow-indigo-600/30 group-hover:scale-105 transition-transform">
                    ASN
                </div>
                <div class="text-left">
                    <h1 class="font-bold text-xl text-white tracking-tight leading-none">Riwayat Hidup Digital</h1>
                    <p class="text-xs text-indigo-400 font-medium">Sistem Informasi Pendataan ASN</p>
                </div>
            </Link>
            <h2 class="mt-8 text-2xl font-extrabold text-white tracking-tight">
                Masuk ke Akun Anda
            </h2>
            <p class="mt-2 text-sm text-slate-400">
                Gunakan NIP (18 Digit), NIK, No. Telepon, atau Email Anda
            </p>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md relative z-10">
            <div class="bg-slate-900/80 backdrop-blur-xl py-8 px-6 shadow-2xl shadow-black/50 border border-slate-800 sm:rounded-2xl sm:px-10">

                <div v-if="status" class="mb-4 p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-sm flex items-center gap-2">
                    <ShieldCheck class="w-5 h-5 shrink-0" />
                    <span>{{ status }}</span>
                </div>

                <div v-if="flash?.error" class="mb-4 p-4 rounded-xl bg-rose-500/10 border border-rose-500/20 text-rose-400 text-sm flex items-center gap-2">
                    <AlertCircle class="w-5 h-5 shrink-0" />
                    <span>{{ flash.error }}</span>
                </div>

                <form @submit.prevent="submit" class="space-y-6">
                    <div>
                        <label for="login" class="block text-xs font-semibold uppercase tracking-wider text-slate-300">
                            NIP / NIK / No. HP / Email
                        </label>
                        <div class="mt-2 relative rounded-xl shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                                <UserCheck class="w-5 h-5" />
                            </div>
                            <input
                                id="login"
                                v-model="form.login"
                                type="text"
                                required
                                autofocus
                                placeholder="Masukkan NIP (18 digit) / NIK / No HP"
                                class="block w-full pl-11 pr-4 py-3 bg-slate-800/80 border border-slate-700/80 rounded-xl text-white placeholder-slate-500 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                            />
                        </div>
                        <p v-if="form.errors.login" class="mt-2 text-xs text-rose-400 flex items-center gap-1">
                            <AlertCircle class="w-3.5 h-3.5" />
                            {{ form.errors.login }}
                        </p>
                    </div>

                    <div>
                        <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-slate-300">
                            Kata Sandi
                        </label>
                        <div class="mt-2 relative rounded-xl shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                                <Lock class="w-5 h-5" />
                            </div>
                            <input
                                id="password"
                                v-model="form.password"
                                type="password"
                                required
                                placeholder="••••••••"
                                class="block w-full pl-11 pr-4 py-3 bg-slate-800/80 border border-slate-700/80 rounded-xl text-white placeholder-slate-500 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                            />
                        </div>
                        <p v-if="form.errors.password" class="mt-2 text-xs text-rose-400 flex items-center gap-1">
                            <AlertCircle class="w-3.5 h-3.5" />
                            {{ form.errors.password }}
                        </p>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input
                                id="remember"
                                v-model="form.remember"
                                type="checkbox"
                                class="h-4 w-4 text-indigo-600 bg-slate-800 border-slate-700 rounded focus:ring-indigo-500 focus:ring-offset-slate-900"
                            />
                            <label for="remember" class="ml-2 block text-sm text-slate-400">
                                Ingat Saya
                            </label>
                        </div>
                    </div>

                    <div>
                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="w-full flex justify-center items-center gap-2 py-3 px-4 border border-transparent rounded-xl shadow-lg shadow-indigo-600/30 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 focus:ring-offset-slate-900 transition disabled:opacity-50 cursor-pointer"
                        >
                            <span>{{ form.processing ? 'Memproses...' : 'Masuk Aplikasi' }}</span>
                            <ArrowRight class="w-4 h-4" />
                        </button>
                    </div>
                </form>

                <div class="mt-8 pt-6 border-t border-slate-800 text-center">
                    <p class="text-sm text-slate-400">
                        Belum memiliki akun pegawai?
                        <Link href="/register" class="font-semibold text-indigo-400 hover:text-indigo-300 transition ml-1">
                            Daftar Pendaftaran Baru
                        </Link>
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>
