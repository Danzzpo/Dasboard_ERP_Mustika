<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

// 1. Langsung lempar ke halaman Login saat web dibuka
Route::get('/', function () {
    return redirect()->route('login');
});

// 2. Rute Dashboard (SEKARANG MENGGUNAKAN DATA REAL DARI DATABASE)
Route::get('/dashboard', function () {

    // Menghitung jumlah riil dari tabel assignments (Pekerjaan)
    $totalPekerjaan = DB::table('assignments')->count();
    $menungguSurvey = DB::table('assignments')->where('status_workflow', 'Survey')->count();
    $prosesProduksi = DB::table('assignments')->where('status_workflow', 'Produksi')->count();

    // Mengambil 10 antrean pekerjaan terbaru, join dengan tabel toko dan user
    $recentJobs = DB::table('assignments')
        ->join('users', 'assignments.id_user_surveyor', '=', 'users.id')
        ->select(
            'assignments.no_sps',
            'assignments.nama_pekerjaan as outlet', // <-- Ambil langsung dari tabel assignments
            'users.name as pic',
            'assignments.status_workflow as status',
            'assignments.updated_at'
        )
        ->orderBy('assignments.updated_at', 'desc')
        ->limit(10)
        ->get()
        ->map(function ($job) {
            // ... (kode pewarnaan color biarkan sama)
            $statusLower = strtolower($job->status);
            if (str_contains($statusLower, 'lunas') || str_contains($statusLower, 'pemasangan')) {
                $job->color = 'bg-emerald-100 text-emerald-700 border-emerald-200';
            } elseif (str_contains($statusLower, 'survey') || str_contains($statusLower, 'quotation')) {
                $job->color = 'bg-amber-100 text-amber-700 border-amber-200';
            } elseif (str_contains($statusLower, 'produksi')) {
                $job->color = 'bg-purple-100 text-purple-700 border-purple-200';
            } else {
                $job->color = 'bg-blue-100 text-blue-700 border-blue-200';
            }

            $job->date = date('d M Y', strtotime($job->updated_at));
            return $job;
        });

    return Inertia::render('Dashboard/Dashboard', [
        'realStats' => [
            'totalPekerjaan' => $totalPekerjaan,
            'menungguSurvey' => $menungguSurvey,
            'prosesProduksi' => $prosesProduksi,
        ],
        'realJobs' => $recentJobs
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

// 3. Rute Profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

require __DIR__.'/auth.php';
