<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\PoliController;
use App\Http\Controllers\Admin\DokterController;
use App\Http\Controllers\Admin\PasienController;
use App\Http\Controllers\Admin\ObatController;
use App\Http\Controllers\Admin\PembayaranController as AdminPembayaranController;
use App\Http\Controllers\Dokter\JadwalPeriksaController;
use App\Http\Controllers\Pasien\PoliController as PasienPoliController;
use App\Http\Controllers\Pasien\PembayaranController as PasienPembayaranController;
use App\Http\Controllers\Dokter\PeriksaPasienController;
use App\Http\Controllers\Dokter\RiwayatPasienController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Poli;
use App\Models\Obat;
use App\Models\DaftarPoli;
use App\Models\Periksa;
use App\Models\JadwalPeriksa;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// --- DASHBOARD ADMIN ---
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        $total_dokter = User::query()->where('role', 'dokter')->count('id');
        $total_pasien = User::query()->where('role', 'pasien')->count('id');
        $total_poli   = Poli::query()->count('id');
        $total_obat   = Obat::query()->count('id');

        $pasien_terbaru = User::where('role', 'pasien')
            ->latest()
            ->take(5)
            ->get();

        $dokter_terbaru = User::where('role', 'dokter')
            ->with('poli')
            ->latest()
            ->take(5)
            ->get();

        // Total antrean aktif hari ini
        $antrean_hari_ini = DaftarPoli::doesntHave('periksas')
            ->whereDate('created_at', today())
            ->count();

        return view('admin.dashboard', compact(
            'total_dokter',
            'total_pasien',
            'total_poli',
            'total_obat',
            'pasien_terbaru',
            'dokter_terbaru',
            'antrean_hari_ini'
        ));
    })->name('admin.dashboard');

    Route::resource('polis', PoliController::class);
    Route::resource('dokter', DokterController::class);
    Route::resource('pasien', PasienController::class);
    Route::resource('obat', ObatController::class);

    Route::get('/pembayaran', [AdminPembayaranController::class, 'index'])->name('admin.pembayaran.index');
    Route::post('/pembayaran/{id}/lunas', [AdminPembayaranController::class, 'lunas'])->name('admin.pembayaran.lunas');
});

// --- DASHBOARD DOKTER ---
Route::middleware(['auth', 'role:dokter'])->prefix('dokter')->group(function () {
    Route::get('/dashboard', function () {
        $dokterId = Auth::id();
        $dokter   = Auth::user()->load('poli');

        $pasien_hari_ini = DaftarPoli::query()
            ->whereHas('jadwalPeriksa', function ($q) use ($dokterId) {
                $q->where('id_dokter', $dokterId);
            })->doesntHave('periksas')->count('id');

        $total_diperiksa = Periksa::query()
            ->whereHas('daftarPoli.jadwalPeriksa', function ($q) use ($dokterId) {
                $q->where('id_dokter', $dokterId);
            })->count('id');

        // Total jadwal aktif dokter ini
        $total_jadwal = JadwalPeriksa::where('id_dokter', $dokterId)->count();

        // 5 pasien terbaru yang menunggu
        $antrean_terbaru = DaftarPoli::with(['pasien', 'jadwalPeriksa'])
            ->whereHas('jadwalPeriksa', function ($q) use ($dokterId) {
                $q->where('id_dokter', $dokterId);
            })->doesntHave('periksas')
            ->orderBy('no_antrian')
            ->take(5)
            ->get();

        return view('dokter.dashboard', compact(
            'pasien_hari_ini',
            'total_diperiksa',
            'total_jadwal',
            'antrean_terbaru',
            'dokter'
        ));
    })->name('dokter.dashboard');

    Route::resource('jadwal-periksa', JadwalPeriksaController::class);

    Route::get('/periksa-pasien', [PeriksaPasienController::class, 'index'])->name('periksa-pasien.index');
    Route::post('/periksa-pasien', [PeriksaPasienController::class, 'store'])->name('periksa-pasien.store');
    Route::get('/periksa-pasien/create/{id}', [PeriksaPasienController::class, 'create'])->name('periksa-pasien.create');

    Route::get('/riwayat-pasien', [RiwayatPasienController::class, 'index'])->name('riwayat-pasien.index');
    Route::get('/riwayat-pasien/{id}', [RiwayatPasienController::class, 'show'])->name('riwayat-pasien.show');
});

// --- DASHBOARD PASIEN ---
Route::middleware(['auth', 'role:pasien'])->prefix('pasien')->group(function () {
    Route::get('/dashboard', function () {
        $pasienId = Auth::id();
        $pasien   = Auth::user();

        // Antrean aktif (belum diperiksa)
        $antrean_aktif = DaftarPoli::query()
            ->with(['jadwalPeriksa.dokter.poli'])
            ->where('id_pasien', $pasienId)
            ->doesntHave('periksas')
            ->orderBy('created_at', 'desc')
            ->first();

        // Total antrean yang sudah selesai (riwayat)
        $total_riwayat = Periksa::whereHas('daftarPoli', function ($q) use ($pasienId) {
            $q->where('id_pasien', $pasienId);
        })->count();

        // Riwayat terbaru pasien
        $riwayat_terbaru = Periksa::with(['daftarPoli.jadwalPeriksa.dokter.poli', 'detailPeriksas.obat'])
            ->whereHas('daftarPoli', function ($q) use ($pasienId) {
                $q->where('id_pasien', $pasienId);
            })
            ->orderBy('tgl_periksa', 'desc')
            ->take(3)
            ->get();

        return view('pasien.dashboard', compact(
            'antrean_aktif',
            'total_riwayat',
            'riwayat_terbaru',
            'pasien'
        ));
    })->name('pasien.dashboard');

    Route::get('/daftar', [PasienPoliController::class, 'get'])->name('pasien.daftar');
    Route::post('/daftar', [PasienPoliController::class, 'submit'])->name('pasien.daftar.submit');

    Route::get('/pembayaran', [PasienPembayaranController::class, 'index'])->name('pasien.pembayaran.index');
});