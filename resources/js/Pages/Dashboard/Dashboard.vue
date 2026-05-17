<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';

// Mengambil data user yang sedang login
const user = usePage().props.auth.user;

// Data Dummy Statistik (Nanti kita hubungkan dengan Database)
const stats = [
    { id: 1, title: 'Total Pekerjaan (Aktif)', value: '45', iconColor: 'text-blue-600', bgColor: 'bg-blue-100', icon: 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2' },
    { id: 2, title: 'Menunggu Survey', value: '12', iconColor: 'text-amber-600', bgColor: 'bg-amber-100', icon: 'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z M15 11a3 3 0 11-6 0 3 3 0 016 0z' },
    { id: 3, title: 'Proses Produksi', value: '8', iconColor: 'text-purple-600', bgColor: 'bg-purple-100', icon: 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z' },
    { id: 4, title: 'Total Omset (PO)', value: 'Rp 145 Juta', iconColor: 'text-emerald-600', bgColor: 'bg-emerald-100', icon: 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z' },
];

// Data Dummy Pekerjaan Terkini
const recentJobs = [
    { sps: 'D49598', outlet: 'BAKSO GONDHOL', status: 'PO Release', date: '11 Jul 2025', pic: 'Pak Bon' },
    { sps: 'D48819', outlet: 'BRANDING KOPMA UMM', status: 'Survey Done', date: '14 Jul 2025', pic: 'Heri M' },
    { sps: 'QUO-009', outlet: 'AYAM GORENG NELONGSO', status: 'Desain Review', date: '06 Mei 2026', pic: 'Arul' },
    { sps: 'QUO-012', outlet: 'IGA BAKAR OBAMA', status: 'On Proses', date: '08 Mei 2026', pic: 'Rega' },
];
</script>

<template>
    <Head title="Dashboard Overview" />

    <AuthenticatedLayout>

        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Dashboard Overview</h1>
            <p class="mt-2 text-sm text-gray-500">
                Selamat datang kembali, <span class="font-semibold text-gray-700">{{ user.name }}</span> ({{ user.jabatan }}). Berikut adalah ringkasan operasional Mustika hari ini.
            </p>
        </div>

        <div class="grid grid-cols-1 gap-6 mb-8 sm:grid-cols-2 lg:grid-cols-4">
            <div v-for="stat in stats" :key="stat.id" class="p-6 bg-white border border-gray-100 rounded-2xl shadow-sm flex items-center gap-4 transition-transform hover:-translate-y-1 hover:shadow-md">
                <div :class="[stat.bgColor, stat.iconColor, 'p-4 rounded-xl']">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" :d="stat.icon"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">{{ stat.title }}</p>
                    <p class="text-2xl font-bold text-gray-900">{{ stat.value }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                <h3 class="text-lg font-semibold text-gray-800">Pekerjaan Berjalan (On Going)</h3>
                <button class="text-sm font-medium text-blue-600 hover:text-blue-800 transition-colors">Lihat Semua &rarr;</button>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-600">
                    <thead class="text-xs text-gray-500 uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-4 font-semibold">No SPS / Ref</th>
                            <th scope="col" class="px-6 py-4 font-semibold">Nama Outlet / Project</th>
                            <th scope="col" class="px-6 py-4 font-semibold">PIC Lapangan</th>
                            <th scope="col" class="px-6 py-4 font-semibold">Tanggal</th>
                            <th scope="col" class="px-6 py-4 font-semibold">Status Workflow</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <tr v-for="(job, index) in recentJobs" :key="index" class="hover:bg-gray-50/80 transition-colors">
                            <td class="px-6 py-4 font-medium text-gray-900">{{ job.sps }}</td>
                            <td class="px-6 py-4">{{ job.outlet }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-full bg-gray-200 flex items-center justify-center text-xs font-bold text-gray-600">
                                        {{ job.pic.charAt(0) }}
                                    </div>
                                    {{ job.pic }}
                                </div>
                            </td>
                            <td class="px-6 py-4">{{ job.date }}</td>
                            <td class="px-6 py-4">
                                <span :class="{
                                    'bg-blue-100 text-blue-700': job.status.includes('Release') || job.status.includes('Proses'),
                                    'bg-amber-100 text-amber-700': job.status.includes('Review'),
                                    'bg-emerald-100 text-emerald-700': job.status.includes('Done')
                                }" class="px-3 py-1 text-xs font-semibold rounded-full">
                                    {{ job.status }}
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </AuthenticatedLayout>
</template>
