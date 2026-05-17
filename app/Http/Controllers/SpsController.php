<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class SpsController extends Controller
{
    // --- 1. MENAMPILKAN DAFTAR SEMUA PEKERJAAN (MEJA KERJA) ---
    public function index()
    {
        $jobs = DB::table('assignments')
            ->leftJoin('users', 'assignments.id_user_surveyor', '=', 'users.id')
            ->select(
                'assignments.id_assignment',
                'assignments.no_sps',
                'assignments.nama_pekerjaan',
                'assignments.nama_brand',
                'assignments.status_workflow',
                'users.name as pic',
                'assignments.tgl_sps'
            )
            ->orderBy('assignments.created_at', 'desc')
            ->get()->map(function ($job) {
                // Pewarnaan Badge Status
                $statusLower = strtolower($job->status_workflow);
                if (str_contains($statusLower, 'lunas') || str_contains($statusLower, 'pemasangan')) {
                    $job->color = 'bg-emerald-100 text-emerald-700 border-emerald-200';
                } elseif (str_contains($statusLower, 'survey') || str_contains($statusLower, 'quotation')) {
                    $job->color = 'bg-amber-100 text-amber-700 border-amber-200';
                } elseif (str_contains($statusLower, 'produksi')) {
                    $job->color = 'bg-purple-100 text-purple-700 border-purple-200';
                } else {
                    $job->color = 'bg-blue-100 text-blue-700 border-blue-200';
                }
                return $job;
            });

        // MENGARAH KE FILE DaftarPekerjaan.vue
        return Inertia::render('Pekerjaan/DaftarPekerjaan', [
            'jobs' => $jobs
        ]);
    }

    // --- 2. MENAMPILKAN FORM INPUT SPS BARU ---
    public function create()
    {
        $surveyors = DB::table('users')
                        ->where('role', 'staff')
                        ->select('id', 'name', 'jabatan')
                        ->get();

        $bulanRomawi = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];
        $bulanIni = date('n');
        $tahunIni = date('y');
        $tahunFull = date('Y');

        $romawi = $bulanRomawi[$bulanIni - 1];

        $lastJob = DB::table('assignments')
            ->whereYear('created_at', $tahunFull)
            ->whereMonth('created_at', $bulanIni)
            ->orderBy('id_assignment', 'desc')
            ->first();

        $urutan = 1;

        if ($lastJob && $lastJob->no_sps) {
            $parts = explode('/', $lastJob->no_sps);
            if (isset($parts[0]) && is_numeric($parts[0])) {
                $urutan = intval($parts[0]) + 1;
            } else {
                $urutan = DB::table('assignments')
                            ->whereYear('created_at', $tahunFull)
                            ->whereMonth('created_at', $bulanIni)
                            ->count() + 1;
            }
        }

        $noSpsOtomatis = sprintf("%03d/CV.MUSTIKA/MLG/SPS-%s/%s", $urutan, $romawi, $tahunIni);

        return Inertia::render('Pekerjaan/CreateSps', [
            'surveyors' => $surveyors,
            'noSpsOtomatis' => $noSpsOtomatis
        ]);
    }

    // --- 3. MENYIMPAN DATA SPS KE DATABASE ---
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

    // 4. MENAMPILKAN HALAMAN DETAIL / EDIT PEKERJAAN ---
    public function edit($id)
    {
        // Ambil data pekerjaan spesifik
        $job = DB::table('assignments')->where('id_assignment', $id)->first();

        if (!$job) {
            return redirect()->route('pekerjaan.index')->with('error', 'Data Pekerjaan tidak ditemukan.');
        }

        // Ambil daftar staff untuk pilihan PIC
        $surveyors = DB::table('users')
                        ->where('role', 'staff')
                        ->select('id', 'name', 'jabatan')
                        ->get();

        return Inertia::render('Pekerjaan/DetailPekerjaan', [
            'job' => $job,
            'surveyors' => $surveyors
        ]);
    }

    // --- 5. MENYIMPAN PERUBAHAN (UPDATE STATUS & HARGA) ---
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_pekerjaan'    => 'required|string|max:255',
            'nama_brand'        => 'nullable|string|max:100',
            'prioritas'         => 'required|in:Standart,Urgent',
            'id_user_surveyor'  => 'nullable|exists:users,id',
            'status_workflow'   => 'required|in:Survey,Desain,Quotation,Produksi,Pemasangan,Penagihan,Lunas', // Bebas lompat status!
            'catatan_pekerjaan' => 'nullable|string',
            'nilai_quo'         => 'nullable|numeric', // Input harga penawaran
            'no_po'             => 'nullable|string|max:50',
            'nilai_po'          => 'nullable|numeric',
        ]);

        $validated['updated_at'] = now();

        DB::table('assignments')
            ->where('id_assignment', $id)
            ->update($validated);

        return redirect()->route('pekerjaan.index')->with('success', 'Detail & Status Pekerjaan Berhasil Diperbarui!');
    }

    // --- 6. MENGHAPUS PEKERJAAN (CANCEL TOTAL) ---
    public function destroy($id)
    {
        DB::table('assignments')->where('id_assignment', $id)->delete();

        return redirect()->route('pekerjaan.index')->with('success', 'Pekerjaan Berhasil Dihapus/Dibatalkan.');
    }
}
