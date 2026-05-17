<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // KELOMPOK SUPER ADMIN
        $super_admins = [
            ['name' => 'Bapak Direktur', 'email' => 'direktur@mustika.com', 'role' => 'super_admin', 'jabatan' => 'Direktur'],
            ['name' => 'Bapak CIO', 'email' => 'cio@mustika.com', 'role' => 'super_admin', 'jabatan' => 'CIO'],
            ['name' => 'Bapak JM', 'email' => 'jm@mustika.com', 'role' => 'super_admin', 'jabatan' => 'JM'],
            ['name' => 'Admin Utama', 'email' => 'admin@mustika.com', 'role' => 'super_admin', 'jabatan' => 'Admin'],
        ];

        foreach ($super_admins as $user) {
            User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'role' => $user['role'],
                'jabatan' => $user['jabatan'],
                'password' => Hash::make('mustika123') 
            ]);
        }

        // KELOMPOK STAFF BIASA
        $staff_biasa = [
            ['name' => 'Mas Desainer', 'email' => 'desainer@mustika.com', 'role' => 'staff', 'jabatan' => 'Desainer'],
            ['name' => 'Pak Produksi', 'email' => 'produksi@mustika.com', 'role' => 'staff', 'jabatan' => 'Produksi'],
            ['name' => 'Tim Surveyor', 'email' => 'surveyor@mustika.com', 'role' => 'staff', 'jabatan' => 'Surveyor'],
        ];

        foreach ($staff_biasa as $user) {
            User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'role' => $user['role'],
                'jabatan' => $user['jabatan'],
                'password' => Hash::make('staff123')
            ]);
        }
    }
}
