<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});
</script>

<template>
    <Head title="Pengaturan Profil" />

    <AuthenticatedLayout>

        <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Pengaturan Profil</h2>
                <p class="mt-1 text-sm text-gray-500">
                    Perbarui informasi akun dan kata sandi Anda di sini.
                </p>
            </div>

            <div class="space-y-6">
                <div class="p-4 sm:p-8 bg-white border border-gray-100 shadow-sm sm:rounded-2xl">
                    <UpdateProfileInformationForm
                        :must-verify-email="mustVerifyEmail"
                        :status="status"
                        class="max-w-xl"
                    />
                </div>

                <div class="p-4 sm:p-8 bg-white border border-gray-100 shadow-sm sm:rounded-2xl">
                    <UpdatePasswordForm class="max-w-xl" />
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>
