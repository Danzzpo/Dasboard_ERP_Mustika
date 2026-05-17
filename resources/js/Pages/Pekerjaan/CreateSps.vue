<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import { FileText, ArrowLeft, Save, AlertCircle, Lock } from 'lucide-vue-next';

// Menangkap properti dari Controller, termasuk Nomor SPS Otomatis
const props = defineProps({
    surveyors: Array,
    noSpsOtomatis: String
});

const form = useForm({
    no_sps: props.noSpsOtomatis, // Otomatis terisi dari Backend!
    nama_pekerjaan: '',
    nama_brand: '',
    prioritas: 'Standart',
    id_user_surveyor: '',
    catatan_pekerjaan: '',
    tgl_sps: new Date().toISOString().split('T')[0],
});

const submit = () => {
    form.post(route('sps.store'));
};
</script>

<template>
    <Head title="Input Penerimaan SPS Baru" />

    <AuthenticatedLayout>
        <div class="max-w-4xl mx-auto py-4 space-y-6">

            <div class="flex items-center gap-4">
                <Link :href="route('dashboard')" class="p-2 bg-white hover:bg-gray-100 border border-gray-200 rounded-xl transition-colors text-gray-600 shadow-sm">
                    <ArrowLeft class="w-5 h-5" />
                </Link>
                <div>
                    <h1 class="text-2xl font-semibold text-gray-900 tracking-tight">Penerimaan SPS Baru</h1>
                    <p class="text-sm text-gray-500 mt-1">Pencatatan awal dokumen perintah kerja. Nomor dokumen dibuat otomatis oleh sistem.</p>
                </div>
            </div>

            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                <div class="p-6 border-b border-gray-100 bg-gray-50/50 flex items-center gap-3">
                    <FileText class="w-5 h-5 text-blue-600" />
                    <h2 class="text-sm font-bold uppercase text-gray-700 tracking-wider">Formulir Data Proyek</h2>
                </div>

                <form @submit.prevent="submit" class="p-6 space-y-6">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 flex items-center gap-2">
                                Nomor SPS (Auto-Generate) <Lock class="w-3.5 h-3.5 text-gray-400" />
                            </label>
                            <input type="text" v-model="form.no_sps" readonly
                                   class="mt-1.5 block w-full rounded-xl border border-gray-200 px-3 py-2.5 text-sm text-gray-600 bg-gray-100 cursor-not-allowed font-semibold tracking-wide focus:ring-0">
                            <p class="mt-1.5 text-xs text-gray-500">Nomor ini sudah otomatis terkunci untuk mencegah duplikasi.</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tanggal Dokumen Masuk</label>
                            <input type="date" v-model="form.tgl_sps"
                                   class="mt-1.5 block w-full rounded-xl border border-gray-300 px-3 py-2.5 text-sm text-gray-900 bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama Pekerjaan / Nama Project</label>
                        <input type="text" v-model="form.nama_pekerjaan"
                               class="mt-1.5 block w-full rounded-xl border border-gray-300 px-3 py-2.5 text-sm text-gray-900 placeholder-gray-400 bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all"
                               placeholder="Contoh: BRANDING BAKSO GONDHOL / PENGADAAN SERAGAM MAYORA">
                        <p v-if="form.errors.nama_pekerjaan" class="mt-1.5 text-xs text-red-600 flex items-center gap-1">
                            <AlertCircle class="w-3.5 h-3.5" /> {{ form.errors.nama_pekerjaan }}
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nama Brand / Klien Utama</label>
                            <input type="text" v-model="form.nama_brand"
                                   class="mt-1.5 block w-full rounded-xl border border-gray-300 px-3 py-2.5 text-sm text-gray-900 placeholder-gray-400 bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all"
                                   placeholder="Contoh: TPH / LE MINERALE / MAYORA">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tingkat Prioritas</label>
                            <select v-model="form.prioritas"
                                    class="mt-1.5 block w-full rounded-xl border border-gray-300 px-3 py-2.5 text-sm text-gray-900 bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all">
                                <option value="Standart">Standart</option>
                                <option value="Urgent">Urgent</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Delegasikan Ke (PIC Lapangan / Surveyor)</label>
                        <select v-model="form.id_user_surveyor"
                                class="mt-1.5 block w-full rounded-xl border border-gray-300 px-3 py-2.5 text-sm text-gray-900 bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all">
                            <option value="">-- Pilih Anggota Lapangan --</option>
                            <option v-for="staff in surveyors" :key="staff.id" :value="staff.id">
                                {{ staff.name }} &mdash; ({{ staff.jabatan }})
                            </option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Catatan / Detail Spesifikasi Pekerjaan</label>
                        <textarea v-model="form.catatan_pekerjaan" rows="4"
                                  class="mt-1.5 block w-full rounded-xl border border-gray-300 px-3 py-2.5 text-sm text-gray-900 placeholder-gray-400 bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all"
                                  placeholder="Masukkan deskripsi ukuran, material, atau instruksi khusus dari klien di sini..."></textarea>
                    </div>

                    <div class="pt-4 border-t border-gray-100 flex justify-end gap-3">
                        <Link :href="route('dashboard')" class="px-5 py-2.5 border border-gray-300 text-gray-700 rounded-xl text-sm font-medium hover:bg-gray-50 transition-colors">
                            Batal
                        </Link>
                        <button type="submit" :disabled="form.processing"
                                class="inline-flex items-center gap-2 px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-medium shadow-sm transition-all disabled:opacity-50">
                            <Save class="w-4 h-4" />
                            Simpan Pekerjaan
                        </button>
                    </div>

                </form>
            </div>

        </div>
    </AuthenticatedLayout>
</template>
