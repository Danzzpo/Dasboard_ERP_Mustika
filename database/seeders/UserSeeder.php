<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Menghapus data akun dummy yang lama agar tidak bentrok
        DB::table('users')->delete();

        // DATA KARYAWAN ASLI CV. MUSTIKA
        $users = [
            // KELOMPOK SUPER USER & ADMIN (Hak Akses: super_admin)
            ['name' => 'Amang Zainuri', 'email' => 'amang@mustika.com', 'role' => 'super_admin', 'jabatan' => 'Super User'],
            ['name' => 'Yoyon', 'email' => 'yoyon@mustika.com', 'role' => 'super_admin', 'jabatan' => 'Super User'],
            ['name' => 'Arik Setiawan', 'email' => 'arik@mustika.com', 'role' => 'super_admin', 'jabatan' => 'Super User'],
            ['name' => 'Lia', 'email' => 'lia@mustika.com', 'role' => 'super_admin', 'jabatan' => 'Admin Utama'],

            // KELOMPOK LAPANGAN & PRODUKSI (Hak Akses: staff)
            ['name' => 'Rega', 'email' => 'rega@mustika.com', 'role' => 'staff', 'jabatan' => 'Tim Survey & Desain'],
            ['name' => 'Rangga', 'email' => 'rangga@mustika.com', 'role' => 'staff', 'jabatan' => 'Tim Survey & Desain'],
            ['name' => 'Agus Kurniawan', 'email' => 'agus@mustika.com', 'role' => 'staff', 'jabatan' => 'Head Produksi (Probolinggo)'],
            ['name' => 'Yogi', 'email' => 'yogi@mustika.com', 'role' => 'staff', 'jabatan' => 'Head Produksi (Malang)'],
        ];

        // Looping untuk memasukkan data ke database
        foreach ($users as $user) {
            User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'role' => $user['role'],
                'jabatan' => $user['jabatan'],
                'password' => Hash::make('mustika123') // Password seragam untuk awal
            ]);
        }
    }
}
