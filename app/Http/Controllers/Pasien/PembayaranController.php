<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Periksa;
use Illuminate\Support\Facades\Auth;

class PembayaranController extends Controller
{
    public function index()
    {
        $pasienId = Auth::id();
        
        $tagihans = Periksa::with(['daftarPoli.jadwalPeriksa.dokter.poli', 'detailPeriksas.obat'])
            ->whereHas('daftarPoli', function ($q) use ($pasienId) {
                $q->where('id_pasien', $pasienId);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pasien.pembayaran.index', compact('tagihans'));
    }
}
