<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';
// Mengimpor ikon dari library profesional
import { Calendar, DownloadCloud } from 'lucide-vue-next';

const user = usePage().props.auth.user;

// Mendapatkan tanggal hari ini secara dinamis
const today = new Date().toLocaleDateString('id-ID', {
    weekday: 'long',
    year: 'numeric',
    month: 'long',
    day: 'numeric'
});
</script>

<template>
    <Head title="Dashboard Overview" />

    <AuthenticatedLayout>
        <div class="max-w-7xl mx-auto space-y-8 sm:px-6 lg:px-8 py-8">

            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-900 tracking-tight">
                        Dashboard Overview
                    </h1>
                    <p class="mt-1.5 text-sm text-gray-500 flex items-center gap-2">
                        <Calendar class="w-4 h-4 text-gray-400" />
                        {{ today }} &mdash; CV. Mustika Advertising. Logged in as <span class="font-medium text-gray-700">{{ user.jabatan }}</span>.
                    </p>
                </div>

                <div class="flex items-center gap-3">
                    <div class="flex items-center gap-2 px-3 py-1.5 bg-emerald-50 border border-emerald-100 rounded-md">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span class="text-xs font-medium text-emerald-700 uppercase tracking-wide">System Online</span>
                    </div>

                    <button class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors shadow-sm">
                        <DownloadCloud class="w-4 h-4 text-gray-500" />
                        Export Report
                    </button>
                </div>
            </div>

            <hr class="border-gray-200" />

            </div>
    </AuthenticatedLayout>
</template>
