<script setup>
import { ref } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
// Mengambil ikon-ikon profesional dari Lucide
import {
    LayoutDashboard, Users, Database, FileText,
    PenTool, Hammer, Wrench, ChevronDown,
    Menu, Bell, Search, LogOut, User as UserIcon
} from 'lucide-vue-next';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';

const user = usePage().props.auth.user;

// Logika untuk buka-tutup Sidebar
const isSidebarOpen = ref(true);

// Logika untuk Dropdown Menu di Sidebar (Accordion)
const expandedMenu = ref(null);
const toggleSubMenu = (menuName) => {
    expandedMenu.value = expandedMenu.value === menuName ? null : menuName;
};
</script>

<template>
    <div class="flex h-screen bg-gray-100 overflow-hidden font-sans">

        <aside
            class="bg-[#1e222d] text-gray-300 flex flex-col transition-all duration-300 z-20 shadow-xl"
            :class="isSidebarOpen ? 'w-64 shrink-0' : 'w-0 md:w-20 shrink-0 overflow-hidden'"
        >
            <div class="h-16 flex items-center justify-center bg-[#1a1d27] border-b border-gray-800 shrink-0">
                <h1 v-if="isSidebarOpen" class="text-xl font-extrabold tracking-widest text-white">
                    <span class="text-blue-500">MUSTIKA</span> ERP
                </h1>
                <h1 v-else class="text-xl font-extrabold tracking-widest text-blue-500">M</h1>
            </div>

            <div class="flex-1 overflow-y-auto py-6 scrollbar-thin scrollbar-thumb-gray-700">

                <div class="px-5 mb-3 text-[11px] font-bold text-gray-500 uppercase tracking-wider" v-show="isSidebarOpen">
                    Menu Utama
                </div>

                <nav class="space-y-1 px-3">
                    <Link :href="route('dashboard')"
                          class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all hover:bg-[#2b303b] hover:text-white"
                          :class="{ 'bg-blue-600 text-white shadow-md hover:bg-blue-700': route().current('dashboard') }">
                        <LayoutDashboard class="w-5 h-5 shrink-0" />
                        <span v-show="isSidebarOpen" class="font-medium text-sm">Dashboard</span>
                    </Link>

                    <div>
                        <button @click="toggleSubMenu('master')"
                                class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg transition-all hover:bg-[#2b303b] hover:text-white"
                                :class="{ 'text-white bg-[#2b303b]/50': expandedMenu === 'master' }">
                            <div class="flex items-center gap-3">
                                <Database class="w-5 h-5 shrink-0" />
                                <span v-show="isSidebarOpen" class="font-medium text-sm">Master Data</span>
                            </div>
                            <ChevronDown v-show="isSidebarOpen" class="w-4 h-4 transition-transform duration-200" :class="{ 'rotate-180': expandedMenu === 'master' }" />
                        </button>

                        <div v-show="isSidebarOpen && expandedMenu === 'master'" class="mt-1 pl-11 space-y-1">
                            <a href="#" class="block py-2 text-sm text-gray-400 hover:text-blue-400 transition-colors">Daftar Harga & Bahan</a>
                            <a href="#" class="block py-2 text-sm text-gray-400 hover:text-blue-400 transition-colors">Daftar Toko / Outlet</a>
                        </div>
                    </div>

                    <div class="px-5 mt-8 mb-3 text-[11px] font-bold text-gray-500 uppercase tracking-wider" v-show="isSidebarOpen">
                        Input & Workflow
                    </div>

                    <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all hover:bg-[#2b303b] hover:text-white">
                        <FileText class="w-5 h-5 shrink-0" />
                        <span v-show="isSidebarOpen" class="font-medium text-sm">Penerimaan SPS</span>
                    </a>

                    <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all hover:bg-[#2b303b] hover:text-white">
                        <PenTool class="w-5 h-5 shrink-0" />
                        <span v-show="isSidebarOpen" class="font-medium text-sm">Desain & Penawaran</span>
                    </a>

                    <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all hover:bg-[#2b303b] hover:text-white">
                        <Hammer class="w-5 h-5 shrink-0" />
                        <span v-show="isSidebarOpen" class="font-medium text-sm">Proses Produksi</span>
                    </a>

                    <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all hover:bg-[#2b303b] hover:text-white">
                        <Wrench class="w-5 h-5 shrink-0" />
                        <span v-show="isSidebarOpen" class="font-medium text-sm">Realisasi Pemasangan</span>
                    </a>

                    <div class="px-5 mt-8 mb-3 text-[11px] font-bold text-gray-500 uppercase tracking-wider" v-show="isSidebarOpen">
                        Administrator
                    </div>

                    <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all hover:bg-[#2b303b] hover:text-white">
                        <Users class="w-5 h-5 shrink-0" />
                        <span v-show="isSidebarOpen" class="font-medium text-sm">Manajemen Pengguna</span>
                    </a>
                </nav>
            </div>
        </aside>

        <div class="flex-1 flex flex-col min-w-0 bg-[#f4f6f9]">

            <header class="h-16 bg-white shadow-sm flex items-center justify-between px-4 lg:px-6 z-10 shrink-0 border-b border-gray-200">

                <div class="flex items-center gap-4 flex-1">
                    <button @click="isSidebarOpen = !isSidebarOpen" class="p-2 rounded-lg text-gray-500 hover:bg-gray-100 hover:text-gray-900 transition-colors focus:outline-none">
                        <Menu class="w-5 h-5" />
                    </button>

                    <div class="hidden md:flex items-center px-4 py-2 bg-gray-100/80 border border-gray-200 rounded-xl w-72 focus-within:ring-2 ring-blue-500/20 focus-within:border-blue-500 transition-all">
                        <Search class="w-4 h-4 text-gray-400" />
                        <input type="text" placeholder="Cari data, no SPS, atau outlet..." class="bg-transparent border-none focus:ring-0 text-sm ml-2 w-full p-0 text-gray-700 placeholder-gray-400">
                    </div>
                </div>

                <div class="flex items-center gap-3 lg:gap-5">

                    <button class="relative p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-full transition-colors">
                        <Bell class="w-5 h-5" />
                        <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-red-500 rounded-full border border-white"></span>
                    </button>

                    <div class="h-6 w-px bg-gray-200 hidden md:block"></div>

                    <Dropdown align="right" width="48">
                        <template #trigger>
                            <button class="flex items-center gap-3 p-1 rounded-lg hover:bg-gray-50 transition-colors text-left focus:outline-none">
                                <div class="w-9 h-9 rounded-full bg-gradient-to-tr from-blue-600 to-indigo-600 flex items-center justify-center text-white font-bold text-sm shrink-0 shadow-sm">
                                    {{ user.name.charAt(0) }}
                                </div>
                                <div class="hidden md:block">
                                    <p class="text-sm font-bold text-gray-800 leading-none">{{ user.name }}</p>
                                    <p class="text-[11px] font-medium text-gray-500 mt-1">{{ user.jabatan }}</p>
                                </div>
                                <ChevronDown class="w-4 h-4 text-gray-400 hidden md:block ml-1" />
                            </button>
                        </template>

                        <template #content>
                            <div class="px-4 py-3 border-b border-gray-100 bg-gray-50/50">
                                <p class="text-sm text-gray-900 font-semibold">{{ user.name }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ user.email }}</p>
                            </div>
                            <DropdownLink :href="route('profile.edit')" class="flex items-center gap-2 py-2.5">
                                <UserIcon class="w-4 h-4 text-gray-400" /> Pengaturan Akun
                            </DropdownLink>
                            <DropdownLink :href="route('logout')" method="post" as="button" class="flex items-center gap-2 py-2.5 text-red-600 hover:bg-red-50">
                                <LogOut class="w-4 h-4 text-red-500" /> Keluar Sistem
                            </DropdownLink>
                        </template>
                    </Dropdown>
                </div>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-[#f4f6f9] p-4 md:p-6 lg:p-8">
                <slot />
            </main>

        </div>
    </div>
</template>

<style>
/* Kostumisasi Scrollbar Sidebar biar halus dan rapi */
.scrollbar-thin::-webkit-scrollbar {
    width: 5px;
}
.scrollbar-thin::-webkit-scrollbar-track {
    background: transparent;
}
.scrollbar-thin::-webkit-scrollbar-thumb {
    background-color: #374151;
    border-radius: 10px;
}
</style>
