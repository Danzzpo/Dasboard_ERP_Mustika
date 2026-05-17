<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { Briefcase, Plus, Search, Eye } from 'lucide-vue-next';

defineProps({
    jobs: Array
});
</script>

<template>
    <Head title="Daftar Pekerjaan" />

    <AuthenticatedLayout>
        <div class="max-w-7xl mx-auto py-4 space-y-6">

            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-900 tracking-tight">Rekapan Pekerjaan</h1>
                    <p class="text-sm text-gray-500 mt-1">Daftar seluruh proyek dan order promosi yang sedang berjalan.</p>
                </div>
                <div>
                    <Link :href="route('sps.create')"
                          class="inline-flex items-center gap-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-medium shadow-sm transition-all">
                        <Plus class="w-4 h-4" /> Penerimaan SPS Baru
                    </Link>
                </div>
            </div>

            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                <div class="p-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                    <div class="flex items-center gap-2 text-gray-700 font-semibold">
                        <Briefcase class="w-5 h-5 text-blue-600" /> Semua Pekerjaan
                    </div>
                    <div class="relative w-64">
                        <Search class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" />
                        <input type="text" placeholder="Cari No SPS / Project..."
                               class="w-full pl-9 pr-4 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-600">
                        <thead class="text-xs text-gray-500 uppercase bg-gray-50/80 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-4 font-semibold">No SPS</th>
                                <th class="px-6 py-4 font-semibold">Nama Project / Pekerjaan</th>
                                <th class="px-6 py-4 font-semibold">Klien / Brand</th>
                                <th class="px-6 py-4 font-semibold">Tgl Masuk</th>
                                <th class="px-6 py-4 font-semibold">PIC Lapangan</th>
                                <th class="px-6 py-4 font-semibold">Status Workflow</th>
                                <th class="px-6 py-4 font-semibold text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <tr v-for="job in jobs" :key="job.id_assignment" class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 font-bold text-gray-900">{{ job.no_sps }}</td>
                                <td class="px-6 py-4 font-medium text-gray-800">{{ job.nama_pekerjaan }}</td>
                                <td class="px-6 py-4">{{ job.nama_brand || '-' }}</td>
                                <td class="px-6 py-4 text-gray-500">{{ job.tgl_sps }}</td>
                                <td class="px-6 py-4">{{ job.pic || 'Belum Ada' }}</td>
                                <td class="px-6 py-4">
                                    <span :class="['px-2.5 py-1 text-xs font-bold rounded-md border', job.color]">
                                        {{ job.status_workflow }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <Link :href="route('pekerjaan.edit', job.id_assignment)"
                                          class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white border border-gray-200 hover:bg-gray-50 hover:text-blue-600 text-gray-600 rounded-lg text-xs font-medium transition-colors shadow-sm">
                                        <Eye class="w-3.5 h-3.5" /> Proses
                                    </Link>
                                </td>
                            </tr>
                            <tr v-if="jobs.length === 0">
                                <td colspan="7" class="px-6 py-8 text-center text-gray-400 font-medium">
                                    Belum ada data pekerjaan. Silakan buat Penerimaan SPS Baru.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </AuthenticatedLayout>
</template>
