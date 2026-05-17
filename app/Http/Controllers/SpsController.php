<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class SpsController extends Controller
{
    public function create()
    {
        // 1. Ambil daftar tim lapangan
        $surveyors = DB::table('users')
                        ->where('role', 'staff')
                        ->select('id', 'name', 'jabatan')
                        ->get();

        // 2. MESIN PENOMORAN OTOMATIS (Auto-Generate)
        $bulanRomawi = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];
        $bulanIni = date('n'); // Angka bulan (1-12)
        $tahunIni = date('y'); // 2 digit tahun (contoh: 26)
        $tahunFull = date('Y'); // 4 digit tahun (contoh: 2026)

        $romawi = $bulanRomawi[$bulanIni - 1];

        // Cari nomor pekerjaan terakhir di bulan dan tahun yang sama
        $lastJob = DB::table('assignments')
            ->whereYear('created_at', $tahunFull)
            ->whereMonth('created_at', $bulanIni)
            ->orderBy('id_assignment', 'desc')
            ->first();

        $urutan = 1; // Default jika belum ada pekerjaan sama sekali bulan ini

        if ($lastJob && $lastJob->no_sps) {
            // Memecah nomor sebelumnya (misal: 012/CV.MUSTIKA/...) ambil angka 012-nya
            $parts = explode('/', $lastJob->no_sps);
            if (isset($parts[0]) && is_numeric($parts[0])) {
                $urutan = intval($parts[0]) + 1; // Tambah 1 dari urutan terakhir
            } else {
                // Jika data lama dari excel nomornya berantakan, kita hitung jumlah total bulan ini + 1
                $urutan = DB::table('assignments')
                            ->whereYear('created_at', $tahunFull)
                            ->whereMonth('created_at', $bulanIni)
                            ->count() + 1;
            }
        }

        // Cetak dengan format 3 digit (contoh: 001, 002, 015)
        $noSpsOtomatis = sprintf("%03d/CV.MUSTIKA/MLG/SPS-%s/%s", $urutan, $romawi, $tahunIni);

        return Inertia::render('Pekerjaan/CreateSps', [
            'surveyors' => $surveyors,
            'noSpsOtomatis' => $noSpsOtomatis // Lempar nomor ini ke tampilan Vue
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'no_sps'             => 'required|string|max:50',
            'nama_pekerjaan'     => 'required|string|max:255',
            'nama_brand'         => 'nullable|string|max:100',
            'prioritas'          => 'required|in:Standart,Urgent',
            'id_user_surveyor'   => 'nullable|exists:users,id',
            'catatan_pekerjaan'  => 'nullable|string',
            'tgl_sps'            => 'required|date',
        ]);

        $validated['status_workflow'] = 'Survey';
        $validated['created_at'] = now();
        $validated['updated_at'] = now();

        DB::table('assignments')->insert($validated);

        return redirect()->route('dashboard')->with('success', 'Pekerjaan Berhasil Dibuat dengan Nomor: ' . $validated['no_sps']);
    }
}
