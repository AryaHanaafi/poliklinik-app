<x-layouts.app title="Pembayaran (Kasir)">

<div class="mb-6">
    <h1 class="text-2xl font-bold text-slate-800">Pembayaran</h1>
    <p class="text-slate-500 text-sm">Kelola pembayaran dari pasien yang telah selesai diperiksa.</p>
</div>

<div class="glass-card rounded-2xl overflow-hidden border border-slate-200 bg-white">
    <div class="p-4 border-b border-slate-100 flex items-center justify-between">
        <h2 class="font-semibold text-slate-800">Daftar Tagihan Pasien</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200">
                    <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Tgl Periksa</th>
                    <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Nama Pasien</th>
                    <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Poli & Dokter</th>
                    <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Biaya</th>
                    <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($tagihans as $tagihan)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-slate-800">{{ \Carbon\Carbon::parse($tagihan->tgl_periksa)->format('d M Y') }}</div>
                        <div class="text-xs text-slate-500">{{ \Carbon\Carbon::parse($tagihan->tgl_periksa)->format('H:i') }} WIB</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm font-semibold text-slate-800">
                            {{ $tagihan->daftarPoli?->pasien?->nama ?? '-' }}
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm font-medium text-slate-800">
                            {{ $tagihan->daftarPoli?->jadwalPeriksa?->dokter?->poli?->nama_poli ?? 'Poli Umum' }}
                        </div>
                        <div class="text-xs text-slate-500">
                            dr. {{ $tagihan->daftarPoli?->jadwalPeriksa?->dokter?->nama ?? '-' }}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-bold text-slate-800">
                            Rp {{ number_format($tagihan->biaya_periksa, 0, ',', '.') }}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($tagihan->status_bayar == 'Belum Lunas')
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                <i class="fas fa-times-circle mr-1.5"></i> Belum Lunas
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                <i class="fas fa-check-circle mr-1.5"></i> Lunas
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        @if($tagihan->status_bayar == 'Belum Lunas')
                            <form action="{{ route('admin.pembayaran.lunas', $tagihan->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin pasien ini telah membayar lunas sejumlah Rp {{ number_format($tagihan->biaya_periksa, 0, ',', '.') }}?')">
                                @csrf
                                <button type="submit" class="inline-flex items-center justify-center gap-2 px-3 py-1.5 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold transition-colors" title="Konfirmasi Pembayaran Lunas">
                                    <i class="fas fa-check"></i> Konfirmasi Lunas
                                </button>
                            </form>
                        @else
                            <button disabled class="inline-flex items-center justify-center gap-2 px-3 py-1.5 rounded-lg bg-slate-100 text-slate-400 text-xs font-semibold cursor-not-allowed">
                                <i class="fas fa-check-double"></i> Selesai
                            </button>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-slate-500">
                        <i class="fas fa-inbox text-3xl mb-3 opacity-30 block"></i>
                        Belum ada data pemeriksaan pasien.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

</x-layouts.app>
