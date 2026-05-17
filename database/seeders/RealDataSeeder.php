<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class RealDataSeeder extends Seeder
{
    public function run()
    {
        ini_set('auto_detect_line_endings', true);

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('assignments')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $users = User::all();
        $defaultUserId = $users->where('role', 'staff')->first()->id ?? 1;

        $csvFile = database_path('seeders/data_asli.csv');
        if (!file_exists($csvFile)) return;

        $lines = file($csvFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $delimiter = ',';
        foreach ($lines as $line) {
            if (strpos($line, 'Nama Project') !== false) {
                $delimiter = strpos($line, ';') !== false ? ';' : ',';
                break;
            }
        }

        $count = 0;
        $this->command->info("Menyedot data... (Mode Tanpa Outlet)");

        foreach ($lines as $line) {
            $row = str_getcsv($line, $delimiter);

            // Filter
            if (!is_numeric(trim($row[0] ?? ''))) continue;

            $namaProject = trim($row[1] ?? '');
            if (empty($namaProject) || $namaProject === '(blank)') continue;

            $noSps     = trim($row[4] ?? '');
            $statusRaw = trim($row[5] ?? '');
            $pic       = trim($row[7] ?? '');
            $tglRaw    = trim($row[3] ?? '');

            if (empty($noSps) || $noSps === '(blank)') {
                $noSps = 'SPS-' . strtoupper(substr(md5(uniqid()), 0, 8));
            }

            $tgl = date('Y-m-d');
            if (!empty($tglRaw) && $tglRaw !== '(blank)') {
                $tglParsed = strtotime(str_replace('/', '-', $tglRaw));
                if ($tglParsed !== false) $tgl = date('Y-m-d', $tglParsed);
            }

            $statusLower = strtolower($statusRaw);
            $mappedStatus = 'Survey';
            if (str_contains($statusLower, 'done') || str_contains($statusLower, 'lunas') || str_contains($statusLower, 'complete')) $mappedStatus = 'Lunas';
            elseif (str_contains($statusLower, 'cancel') || str_contains($statusLower, 'pengajuan') || str_contains($statusLower, 'review')) $mappedStatus = 'Quotation';
            elseif (str_contains($statusLower, 'proses') || str_contains($statusLower, 'produksi') || str_contains($statusLower, 'release')) $mappedStatus = 'Produksi';

            $userId = $defaultUserId;
            if (!empty($pic)) {
                $matchedUser = $users->first(function($u) use ($pic) {
                    return stripos(strtolower($u->name), strtolower($pic)) !== false;
                });
                if ($matchedUser) $userId = $matchedUser->id;
            }

            // TEMBAK DATA KE TABEL ASSIGNMENTS (OUTLET DIGANTI JADI NAMA_PEKERJAAN)
            DB::table('assignments')->insert([
                'no_sps'             => substr($noSps, 0, 50),
                'nama_pekerjaan'     => substr($namaProject, 0, 255), // <--- INI PENGGANTINYA
                'id_user_surveyor'   => $userId,
                'status_workflow'    => $mappedStatus,
                'tgl_sps'            => $tgl,
                'created_at'         => $tgl . ' 10:00:00',
                'updated_at'         => $tgl . ' 10:00:00',
            ]);

            $count++;
        }
        $this->command->info("OPERASI SELESAI: $count Data Berhasil Masuk!");
    }
}
