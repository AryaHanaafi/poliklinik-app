<x-layouts.app title="Dashboard Pasien">

<style>
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }
    @keyframes slideUp {
        from { opacity: 0; transform: translateY(15px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes blink {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.4; }
    }
    .float-icon { animation: float 4s ease-in-out infinite; }
    .slide-up { animation: slideUp 0.5s ease-out forwards; }
    .blink { animation: blink 2s ease-in-out infinite; }

    .glass-card {
        background: rgba(255,255,255,0.92);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255,255,255,0.6);
    }
    .card-lift {
        transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .card-lift:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px -8px rgba(30,45,107,0.15);
    }
    .badge-pill {
        display: inline-flex; align-items: center; gap: 4px;
        font-size: 11px; font-weight: 700; padding: 3px 10px;
        border-radius: 999px;
    }
    .antrian-number {
        font-size: 5rem; font-weight: 900; line-height: 1;
        background: linear-gradient(135deg, #1e2d6b, #4561c2);
        -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    .step-dot {
        width: 28px; height: 28px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 12px; font-weight: 700; flex-shrink: 0;
    }
    .row-hover:hover { background: #f8f9ff; }
</style>

{{-- ===== HERO BANNER ===== --}}
<div class="relative overflow-hidden rounded-[2rem] p-10 mb-8 text-white"
     style="background: linear-gradient(135deg, #1e2d6b 0%, #2d4499 55%, #3a55c0 100%);">

    <div class="absolute -top-16 -right-16 w-72 h-72 rounded-full opacity-10"
         style="background: radial-gradient(circle, #ffffff, transparent 70%);"></div>
    <div class="absolute bottom-0 right-1/4 w-48 h-48 rounded-full opacity-10 translate-y-1/3"
         style="background: radial-gradient(circle, #6b7ee0, transparent 70%);"></div>

    <div class="relative z-10 flex items-start justify-between gap-6">
        <div>
            <div class="flex items-center gap-3 mb-3">
                <span class="badge-pill bg-white/20 text-white border border-white/30">
                    <i class="fas fa-circle text-[6px] text-emerald-400"></i> Selamat Datang
                </span>
                <span class="text-white/60 text-sm">{{ now()->translatedFormat('l, d F Y') }}</span>
            </div>
            <h1 class="text-4xl font-extrabold mb-2 tracking-tight">
                Halo, {{ auth()->user()->nama ?? 'Pasien' }}! 👋
                <span class="block text-lg font-normal text-blue-200/80 mt-1">Dashboard Pasien — Poliklinik</span>
            </h1>
            <p class="text-blue-100/80 text-base max-w-md leading-relaxed mb-5">
                Pantau status antrean dan riwayat pemeriksaan kesehatan Anda di sini.
            </p>
            <a href="{{ route('pasien.daftar') }}"
               class="inline-flex items-center gap-2 px-6 py-3 rounded-xl font-bold text-sm transition-all hover:opacity-90 hover:-translate-y-0.5 shadow-lg"
               style="background: white; color: #1e2d6b;">
                <i class="fas fa-notes-medical"></i> Daftar Poli Sekarang
            </a>
        </div>
        <div class="hidden lg:flex float-icon mr-4">
            <div class="w-24 h-24 rounded-[2rem] bg-white/10 border border-white/20 flex items-center justify-center">
                <i class="fas fa-heartbeat text-5xl text-white/60"></i>
            </div>
        </div>
    </div>
</div>

{{-- ===== ANTREAN AKTIF ===== --}}
@if($antrean_aktif)
<div class="glass-card rounded-2xl overflow-hidden mb-6 border-2 slide-up"
     style="border-color: #2d4499;">
    <div class="px-6 py-4 flex items-center gap-3 border-b border-slate-100"
         style="background: linear-gradient(135deg, #f0f4ff, #e8edf8);">
        <div class="w-3 h-3 rounded-full blink" style="background: #2d4499;"></div>
        <span class="font-bold text-sm" style="color: #1e2d6b;">Antrean Aktif Anda</span>
        <span class="ml-auto badge-pill bg-indigo-100 text-indigo-700">Menunggu Pemeriksaan</span>
    </div>

    <div class="p-6">
        <div class="flex flex-col md:flex-row items-center md:items-start gap-6">

            {{-- Nomor Antrean --}}
            <div class="flex flex-col items-center text-center px-8 py-4 rounded-2xl flex-shrink-0"
                 style="background: linear-gradient(135deg, #f0f4ff, #e8edf8); min-width: 160px;">
                <div class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-1">No. Antrean</div>
                <div class="antrian-number">{{ str_pad($antrean_aktif->no_antrian, 3, '0', STR_PAD_LEFT) }}</div>
                <div class="mt-1 badge-pill bg-indigo-100 text-indigo-700">Antrean Anda</div>
            </div>

            {{-- Detail Antrean --}}
            <div class="flex-1 w-full">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="rounded-xl p-4" style="background: #f8f9ff;">
                        <div class="text-xs text-slate-400 font-semibold uppercase tracking-wider mb-1">Poli / Dokter</div>
                        <div class="font-bold text-slate-800">
                            {{ $antrean_aktif->jadwalPeriksa?->dokter?->poli?->nama_poli ?? 'Belum diketahui' }}
                        </div>
                        <div class="text-sm text-slate-500">
                            dr. {{ $antrean_aktif->jadwalPeriksa?->dokter?->nama ?? '-' }}
                        </div>
                    </div>
                    <div class="rounded-xl p-4" style="background: #f8f9ff;">
                        <div class="text-xs text-slate-400 font-semibold uppercase tracking-wider mb-1">Jadwal</div>
                        <div class="font-bold text-slate-800">
                            {{ $antrean_aktif->jadwalPeriksa?->hari ?? '-' }}
                        </div>
                        <div class="text-sm text-slate-500">
                            {{ $antrean_aktif->jadwalPeriksa?->jam_mulai ?? '-' }} —
                            {{ $antrean_aktif->jadwalPeriksa?->jam_selesai ?? '-' }}
                        </div>
                    </div>
                    @if($antrean_aktif->keluhan)
                    <div class="rounded-xl p-4 sm:col-span-2" style="background: #fffbf0; border: 1px solid #fde68a;">
                        <div class="text-xs text-amber-600 font-semibold uppercase tracking-wider mb-1">
                            <i class="fas fa-clipboard-list"></i> Keluhan
                        </div>
                        <div class="text-slate-700 text-sm">{{ $antrean_aktif->keluhan }}</div>
                    </div>
                    @endif
                </div>

                <div class="mt-4 flex items-center gap-2 text-xs text-slate-400">
                    <i class="fas fa-info-circle" style="color: #2d4499;"></i>
                    Terdaftar {{ $antrean_aktif->created_at->diffForHumans() }}. Harap datang 15 menit lebih awal.
                </div>
            </div>
        </div>
    </div>
</div>

@else
{{-- Tidak ada antrean aktif --}}
<div class="glass-card rounded-2xl p-8 mb-6 text-center slide-up">
    <div class="w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4"
         style="background: linear-gradient(135deg, #f0f4ff, #e8edf8);">
        <i class="fas fa-calendar-xmark text-4xl" style="color: #c7d2f0;"></i>
    </div>
    <h3 class="text-lg font-bold text-slate-700 mb-1">Belum Ada Antrean Aktif</h3>
    <p class="text-slate-400 text-sm mb-5">Anda belum mendaftar ke poli mana pun saat ini.</p>
    <a href="{{ route('pasien.daftar') }}"
       class="inline-flex items-center gap-2 px-6 py-3 rounded-xl text-white font-bold text-sm transition-all hover:opacity-90 hover:-translate-y-0.5"
       style="background: linear-gradient(135deg, #1e2d6b, #2d4499);">
        <i class="fas fa-plus"></i> Daftar Poli Sekarang
    </a>
</div>
@endif

{{-- ===== STATS + RIWAYAT ===== --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">

    {{-- Stat Total Riwayat --}}
    <div class="glass-card rounded-2xl p-6 card-lift group">
        <div class="w-12 h-12 rounded-xl flex items-center justify-center text-xl mb-4 group-hover:scale-110 transition-transform"
             style="background: linear-gradient(135deg, #e8edf8, #c7d2f0); color: #2d4499;">
            <i class="fas fa-history"></i>
        </div>
        <div class="text-4xl font-black mb-1" style="color: #1e2d6b;">{{ $total_riwayat }}</div>
        <div class="text-xs font-bold uppercase tracking-wider text-slate-400">Total Pemeriksaan</div>
        <div class="mt-4 h-1 rounded-full overflow-hidden" style="background: #e8edf8;">
            <div class="h-full rounded-full" style="width: {{ $total_riwayat > 0 ? '100%' : '0%' }}; background: linear-gradient(90deg, #1e2d6b, #4561c2); transition: width 1s;"></div>
        </div>
    </div>

    {{-- Riwayat Terbaru --}}
    <div class="glass-card rounded-2xl overflow-hidden lg:col-span-2">
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg flex items-center justify-center"
                     style="background: linear-gradient(135deg, #1e2d6b, #2d4499); color: white;">
                    <i class="fas fa-clock-rotate-left text-sm"></i>
                </div>
                <div>
                    <h3 class="font-bold text-slate-800 text-sm">Riwayat Pemeriksaan</h3>
                    <p class="text-xs text-slate-400">3 pemeriksaan terakhir</p>
                </div>
            </div>
        </div>
        @if($riwayat_terbaru->count() > 0)
        <div class="divide-y divide-slate-50">
            @foreach($riwayat_terbaru as $riwayat)
            <div class="flex items-start gap-4 px-6 py-4 row-hover transition-colors">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0 mt-0.5"
                     style="background: linear-gradient(135deg, #f0f4ff, #e8edf8); color: #2d4499;">
                    <i class="fas fa-file-medical text-sm"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="font-semibold text-slate-800 text-sm">
                        {{ $riwayat->daftarPoli?->jadwalPeriksa?->dokter?->poli?->nama_poli ?? 'Poli Umum' }}
                    </div>
                    <div class="text-xs text-slate-400 mt-0.5">
                        dr. {{ $riwayat->daftarPoli?->jadwalPeriksa?->dokter?->nama ?? '-' }}
                    </div>
                    @if($riwayat->catatan)
                    <div class="text-xs text-slate-500 italic mt-1 truncate max-w-xs">"{{ $riwayat->catatan }}"</div>
                    @endif
                    @if($riwayat->detailPeriksas->count() > 0)
                    <div class="flex flex-wrap gap-1 mt-1.5">
                        @foreach($riwayat->detailPeriksas->take(3) as $detail)
                        <span class="badge-pill bg-indigo-50 text-indigo-600" style="font-size:10px; padding:2px 8px;">
                            {{ $detail->obat?->nama_obat ?? '-' }}
                        </span>
                        @endforeach
                    </div>
                    @endif
                </div>
                <div class="text-right flex-shrink-0">
                    <div class="text-xs text-slate-400">{{ \Carbon\Carbon::parse($riwayat->tgl_periksa)->format('d M Y') }}</div>
                    <div class="text-xs font-bold mt-1" style="color: #2d4499;">
                        Rp {{ number_format($riwayat->biaya_periksa, 0, ',', '.') }}
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="flex flex-col items-center justify-center py-10 text-slate-400">
            <i class="fas fa-inbox text-3xl mb-2 opacity-30"></i>
            <p class="text-sm">Belum ada riwayat pemeriksaan.</p>
        </div>
        @endif
    </div>

</div>

{{-- ===== TIPS KESEHATAN ===== --}}
<div class="glass-card rounded-2xl p-6 relative overflow-hidden">
    <div class="absolute left-0 top-0 bottom-0 w-1 rounded-l-2xl"
         style="background: linear-gradient(180deg, #1e2d6b, #4561c2);"></div>
    <div class="ml-3">
        <h3 class="font-bold text-slate-800 mb-4 flex items-center gap-2 text-sm">
            <i class="fas fa-lightbulb" style="color: #f59e0b;"></i> Tips Sebelum Periksa
        </h3>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
            <div class="flex items-start gap-3 rounded-xl p-3" style="background: #f8f9ff;">
                <div class="step-dot" style="background: linear-gradient(135deg, #1e2d6b, #2d4499); color: white;">1</div>
                <div class="text-sm text-slate-600">Pilih jadwal sesuai ketersediaan dokter yang diinginkan.</div>
            </div>
            <div class="flex items-start gap-3 rounded-xl p-3" style="background: #f8f9ff;">
                <div class="step-dot" style="background: linear-gradient(135deg, #1e2d6b, #2d4499); color: white;">2</div>
                <div class="text-sm text-slate-600">Datang 15 menit lebih awal dari jadwal yang tertera.</div>
            </div>
            <div class="flex items-start gap-3 rounded-xl p-3" style="background: #f8f9ff;">
                <div class="step-dot" style="background: linear-gradient(135deg, #1e2d6b, #2d4499); color: white;">3</div>
                <div class="text-sm text-slate-600">Bawa kartu identitas saat melakukan pemeriksaan.</div>
            </div>
        </div>
    </div>
</div>

</x-layouts.app>