<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { Calendar, DownloadCloud, Briefcase, Clock, Hammer, TrendingUp, MoreVertical } from 'lucide-vue-next';

const user = usePage().props.auth.user;
const today = new Date().toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });

// MENANGKAP DATA REAL DARI DATABASE
defineProps({
    realStats: Object,
    realJobs: Array
});
</script>

<template>
    <Head title="Dashboard Overview" />

    <AuthenticatedLayout>
        <div class="max-w-7xl mx-auto space-y-8">

            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-900 tracking-tight">Dashboard Overview</h1>
                    <p class="mt-1.5 text-sm text-gray-500 flex items-center gap-2">
                        <Calendar class="w-4 h-4 text-gray-400" />
                        {{ today }} &mdash; CV. Mustika. Logged in as <span class="font-medium text-gray-700">{{ user.jabatan }}</span>.
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">

                <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div><p class="text-sm font-medium text-gray-500">Total Pekerjaan Aktif</p><p class="mt-2 text-3xl font-bold text-gray-900">{{ realStats?.totalPekerjaan || 0 }}</p></div>
                        <div class="p-3 rounded-lg border bg-blue-50 border-blue-100"><Briefcase class="w-6 h-6 text-blue-600" /></div>
                    </div>
                </div>

                <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div><p class="text-sm font-medium text-gray-500">Menunggu Survey</p><p class="mt-2 text-3xl font-bold text-gray-900">{{ realStats?.menungguSurvey || 0 }}</p></div>
                        <div class="p-3 rounded-lg border bg-amber-50 border-amber-100"><Clock class="w-6 h-6 text-amber-600" /></div>
                    </div>
                </div>

                <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div><p class="text-sm font-medium text-gray-500">Proses Produksi</p><p class="mt-2 text-3xl font-bold text-gray-900">{{ realStats?.prosesProduksi || 0 }}</p></div>
                        <div class="p-3 rounded-lg border bg-purple-50 border-purple-100"><Hammer class="w-6 h-6 text-purple-600" /></div>
                    </div>
                </div>

                <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm opacity-60">
                    <div class="flex items-center justify-between">
                        <div><p class="text-sm font-medium text-gray-500">Estimasi Omset</p><p class="mt-2 text-xl font-bold text-gray-900">Menunggu Modul PO</p></div>
                        <div class="p-3 rounded-lg border bg-gray-50 border-gray-200"><TrendingUp class="w-6 h-6 text-gray-400" /></div>
                    </div>
                </div>

            </div>

            <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-200 bg-gray-50/50">
                    <h3 class="text-lg font-semibold text-gray-800">Antrean Pekerjaan Terkini</h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-600">
                        <thead class="text-xs text-gray-500 uppercase bg-gray-50/80 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-4 font-semibold">No SPS / Quo</th>
                                <th class="px-6 py-4 font-semibold">Nama Pekerjaan / Project</th>
                                <th class="px-6 py-4 font-semibold">PIC Lapangan</th>
                                <th class="px-6 py-4 font-semibold">Tanggal Update</th>
                                <th class="px-6 py-4 font-semibold">Status Workflow</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <tr v-for="job in realJobs" :key="job.no_sps" class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 font-bold text-gray-900">{{ job.no_sps }}</td>
                                <td class="px-6 py-4 font-medium text-gray-800">{{ job.outlet }}</td>
                                <td class="px-6 py-4">{{ job.pic }}</td>
                                <td class="px-6 py-4 text-gray-500">{{ job.date }}</td>
                                <td class="px-6 py-4">
                                    <span :class="['px-2.5 py-1 text-xs font-bold rounded-md border', job.color]">
                                        {{ job.status }}
                                    </span>
                                </td>
                            </tr>
                            <tr v-if="!realJobs || realJobs.length === 0">
                                <td colspan="5" class="px-6 py-8 text-center text-gray-400 font-medium">
                                    Belum ada data pekerjaan di Database. Silakan tambah data baru.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </AuthenticatedLayout>
</template>
