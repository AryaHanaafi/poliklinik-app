<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Periksa;

class PembayaranController extends Controller
{
    public function index()
    {
        // Ambil semua data pemeriksaan
        $tagihans = Periksa::with(['daftarPoli.pasien', 'daftarPoli.jadwalPeriksa.dokter.poli'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.pembayaran.index', compact('tagihans'));
    }

    public function lunas($id)
    {
        $periksa = Periksa::findOrFail($id);
        $periksa->update([
            'status_bayar' => 'Lunas'
        ]);

        return redirect()->back()->with('success', 'Pembayaran berhasil dikonfirmasi (Lunas).');
    }
}
