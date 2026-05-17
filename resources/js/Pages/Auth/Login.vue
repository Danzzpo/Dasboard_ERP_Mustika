<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import { LogIn } from 'lucide-vue-next'; // Pakai ikon profesional

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
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
    <Head title="Log in ERP Mustika" />

    <div class="min-h-screen bg-[#1a1d27] flex flex-col justify-center py-12 sm:px-6 lg:px-8 relative overflow-hidden">

        <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0 pointer-events-none">
            <div class="absolute -top-[20%] -left-[10%] w-[50%] h-[50%] rounded-full bg-blue-600/20 blur-[120px]"></div>
            <div class="absolute top-[60%] -right-[10%] w-[40%] h-[60%] rounded-full bg-indigo-600/10 blur-[100px]"></div>
        </div>

        <div class="sm:mx-auto sm:w-full sm:max-w-md relative z-10">
            <h2 class="mt-6 text-center text-4xl font-extrabold text-white tracking-wider drop-shadow-md">
                MUSTIKA <span class="text-blue-500">ERP</span>
            </h2>
            <p class="mt-2 text-center text-sm text-gray-400">
                Sistem Manajemen Operasional Terpadu
            </p>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md relative z-10">
            <div class="bg-white/10 backdrop-blur-xl py-8 px-4 shadow-2xl sm:rounded-2xl sm:px-10 border border-white/10">

                <div v-if="status" class="mb-4 font-medium text-sm text-green-400 text-center bg-green-900/30 py-2 rounded-lg">
                    {{ status }}
                </div>

                <form @submit.prevent="submit" class="space-y-6">
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-300">Alamat Email</label>
                        <div class="mt-1">
                            <input id="email" type="email" v-model="form.email" required autofocus autocomplete="username"
                                class="appearance-none block w-full px-3 py-2.5 border border-gray-600 bg-gray-800/50 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all sm:text-sm"
                                placeholder="nama@mustika.com">
                        </div>
                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-300">Kata Sandi</label>
                        <div class="mt-1">
                            <input id="password" type="password" v-model="form.password" required autocomplete="current-password"
                                class="appearance-none block w-full px-3 py-2.5 border border-gray-600 bg-gray-800/50 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all sm:text-sm"
                                placeholder="••••••••">
                        </div>
                        <InputError class="mt-2" :message="form.errors.password" />
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember_me" type="checkbox" v-model="form.remember"
                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-600 rounded bg-gray-800">
                            <label for="remember_me" class="ml-2 block text-sm text-gray-400">
                                Ingat Saya
                            </label>
                        </div>
                    </div>

                    <div>
                        <button type="submit" :disabled="form.processing"
                            class="w-full flex justify-center items-center gap-2 py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 focus:ring-offset-gray-900 transition-all disabled:opacity-50">
                            <LogIn class="w-4 h-4" />
                            Masuk ke Sistem
                        </button>
                    </div>
                </form>
            </div>

            <div class="mt-6 text-center text-xs text-gray-500">
                &copy; 2026 CV. Mustika Advertising. Hak Cipta Dilindungi.
            </div>
        </div>
    </div>
</template>
