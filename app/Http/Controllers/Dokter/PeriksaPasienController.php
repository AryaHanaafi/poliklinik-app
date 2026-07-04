<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\DaftarPoli;
use App\Models\DetailPeriksa;
use App\Models\Obat;
use App\Models\Periksa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeriksaPasienController extends Controller
{
    public function index()
    {
        $dokterId = Auth::id();

        $daftarPasien = DaftarPoli::with(['pasien', 'jadwalPeriksa', 'periksas'])
            ->whereHas('jadwalPeriksa', function ($query) use ($dokterId) {
                $query->where('id_dokter', $dokterId);
            })
            ->orderBy('no_antrian')
            ->get();

        return view('dokter.periksa-pasien.index', compact('daftarPasien'));
    }

    public function create($id)
    {
        $obats = Obat::all();
        return view('dokter.periksa-pasien.create', compact('obats', 'id'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_daftar_poli' => 'required',
            'obat_json' => 'required',
            'catatan' => 'nullable|string',
            'biaya_periksa' => 'required|numeric',
        ]);

        $obatIds = json_decode($request->input('obat_json'), true);

        // Simpan data pemeriksaan utama
        $periksa = Periksa::query()->create([
            'id_daftar_poli' => $request->input('id_daftar_poli'),
            'tgl_periksa' => now(),
            'catatan' => $request->input('catatan'),
            'biaya_periksa' => (int) $request->input('biaya_periksa') + 150000,
        ]);

        if (is_array($obatIds)) {
            foreach ($obatIds as $idObat) {
                // Catat riwayat obat yang diresepkan
                DetailPeriksa::query()->create([
                    'id_periksa' => $periksa->id,
                    'id_obat' => $idObat,
                ]);

                // Kurangi stok obat secara otomatis
                // Kondisi stok > 0 untuk memastikan stok tidak minus
                Obat::query()
                    ->where('id', $idObat)
                    ->where('stok', '>', 0)
                    ->decrement('stok', 1);
            }
        }

        return redirect()->route('periksa-pasien.index')->with('success', 'Data periksa berhasil disimpan.');
    }
}