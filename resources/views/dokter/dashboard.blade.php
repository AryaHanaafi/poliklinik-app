<x-layouts.app title="Dashboard Dokter">

<style>
    @keyframes float {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-12px) rotate(2deg); }
    }
    @keyframes pulse-ring {
        0% { box-shadow: 0 0 0 0 rgba(45, 68, 153, 0.4); }
        70% { box-shadow: 0 0 0 10px rgba(45, 68, 153, 0); }
        100% { box-shadow: 0 0 0 0 rgba(45, 68, 153, 0); }
    }
    @keyframes slideIn {
        from { opacity: 0; transform: translateX(-10px); }
        to { opacity: 1; transform: translateX(0); }
    }
    .float-icon { animation: float 4s ease-in-out infinite; }
    .pulse-badge { animation: pulse-ring 2s infinite; }
    .slide-in { animation: slideIn 0.4s ease-out forwards; }

    .glass-card {
        background: rgba(255,255,255,0.92);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255,255,255,0.6);
    }
    .card-lift {
        transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .card-lift:hover {
        transform: translateY(-6px);
        box-shadow: 0 24px 48px -8px rgba(30,45,107,0.18);
    }
    .badge-pill {
        display: inline-flex; align-items: center; gap: 4px;
        font-size: 11px; font-weight: 700; padding: 3px 10px;
        border-radius: 999px; letter-spacing: 0.03em;
    }
    .antrian-badge {
        display: inline-flex; align-items: center; justify-content: center;
        width: 32px; height: 32px; border-radius: 10px; font-weight: 800;
        font-size: 14px;
        background: linear-gradient(135deg, #1e2d6b, #2d4499);
        color: white; flex-shrink: 0;
    }
    .row-hover:hover { background: #f8f9ff; }
</style>

{{-- ===== HERO BANNER ===== --}}
<div class="relative overflow-hidden rounded-[2rem] p-10 mb-8 text-white"
     style="background: linear-gradient(135deg, #1e2d6b 0%, #2d4499 55%, #3a55c0 100%);">

    <div class="absolute -top-16 -right-16 w-72 h-72 rounded-full opacity-10"
         style="background: radial-gradient(circle, #ffffff, transparent 70%);"></div>
    <div class="absolute bottom-0 left-1/4 w-48 h-48 rounded-full opacity-10 translate-y-1/3"
         style="background: radial-gradient(circle, #6b7ee0, transparent 70%);"></div>

    <div class="relative z-10 flex items-start justify-between gap-6">
        <div>
            <div class="flex items-center gap-3 mb-3">
                <span class="badge-pill bg-white/20 text-white border border-white/30">
                    <i class="fas fa-circle text-[6px] text-emerald-400"></i> Dokter Aktif
                </span>
                <span class="text-white/60 text-sm">{{ now()->translatedFormat('l, d F Y') }}</span>
            </div>
            <h1 class="text-4xl font-extrabold mb-2 tracking-tight">
                Selamat Bertugas! 👨‍⚕️
                <span class="block text-xl font-semibold text-blue-200/90 mt-1">
                    dr. {{ auth()->user()->nama ?? 'Dokter' }}
                    @if(auth()->user()->poli)
                    <span class="text-blue-300/70">— {{ auth()->user()->poli->nama_poli }}</span>
                    @endif
                </span>
            </h1>
            <p class="text-blue-100/80 text-base max-w-md leading-relaxed">
                Berikut adalah ringkasan tugas dan jadwal pemeriksaan Anda hari ini.
            </p>
        </div>
        <div class="hidden lg:flex float-icon mr-4">
            <div class="w-24 h-24 rounded-[2rem] bg-white/10 border border-white/20 flex items-center justify-center">
                <i class="fas fa-stethoscope text-5xl text-white/60"></i>
            </div>
        </div>
    </div>
</div>

{{-- ===== STATS GRID ===== --}}
<div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-8">

    {{-- Pasien Menunggu --}}
    <div class="glass-card rounded-2xl p-6 card-lift group relative overflow-hidden">
        <div class="absolute top-0 right-0 w-20 h-20 rounded-full opacity-5 -translate-y-6 translate-x-6"
             style="background: #1e2d6b;"></div>
        <div class="flex items-start justify-between mb-5">
            <div class="w-14 h-14 rounded-xl flex items-center justify-center text-2xl group-hover:scale-110 transition-transform"
                 style="background: linear-gradient(135deg, #fff3e0, #ffe0b2); color: #e65100;">
                <i class="fas fa-clock"></i>
            </div>
            @if($pasien_hari_ini > 0)
            <div class="pulse-badge w-3 h-3 rounded-full bg-orange-400 mt-1 mr-1"></div>
            @endif
        </div>
        <div class="text-4xl font-black mb-1" style="color: #1e2d6b;">{{ $pasien_hari_ini }}</div>
        <div class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-3">Pasien Menunggu</div>
        <a href="{{ route('periksa-pasien.index') }}"
           class="flex items-center gap-1.5 text-xs font-semibold rounded-lg px-3 py-2 transition-all hover:opacity-80"
           style="background: #f0f4ff; color: #2d4499;">
            <i class="fas fa-list-check"></i> Lihat Antrean
        </a>
    </div>

    {{-- Total Diperiksa --}}
    <div class="glass-card rounded-2xl p-6 card-lift group relative overflow-hidden">
        <div class="absolute top-0 right-0 w-20 h-20 rounded-full opacity-5 -translate-y-6 translate-x-6"
             style="background: #2d4499;"></div>
        <div class="flex items-start justify-between mb-5">
            <div class="w-14 h-14 rounded-xl flex items-center justify-center text-2xl group-hover:scale-110 transition-transform"
                 style="background: linear-gradient(135deg, #e8f5e9, #c8e6c9); color: #2e7d32;">
                <i class="fas fa-check-double"></i>
            </div>
        </div>
        <div class="text-4xl font-black mb-1" style="color: #1e2d6b;">{{ $total_diperiksa }}</div>
        <div class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-3">Total Diperiksa</div>
        <a href="{{ route('riwayat-pasien.index') }}"
           class="flex items-center gap-1.5 text-xs font-semibold rounded-lg px-3 py-2 transition-all hover:opacity-80"
           style="background: #f0f4ff; color: #2d4499;">
            <i class="fas fa-clock-rotate-left"></i> Lihat Riwayat
        </a>
    </div>

    {{-- Jadwal Aktif --}}
    <div class="glass-card rounded-2xl p-6 card-lift group relative overflow-hidden">
        <div class="absolute top-0 right-0 w-20 h-20 rounded-full opacity-5 -translate-y-6 translate-x-6"
             style="background: #3a55c0;"></div>
        <div class="flex items-start justify-between mb-5">
            <div class="w-14 h-14 rounded-xl flex items-center justify-center text-2xl group-hover:scale-110 transition-transform"
                 style="background: linear-gradient(135deg, #e8edf8, #c7d2f0); color: #2d4499;">
                <i class="fas fa-calendar-check"></i>
            </div>
        </div>
        <div class="text-4xl font-black mb-1" style="color: #1e2d6b;">{{ $total_jadwal }}</div>
        <div class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-3">Jadwal Praktek</div>
        <a href="{{ route('jadwal-periksa.index') }}"
           class="flex items-center gap-1.5 text-xs font-semibold rounded-lg px-3 py-2 transition-all hover:opacity-80"
           style="background: #f0f4ff; color: #2d4499;">
            <i class="fas fa-calendar-alt"></i> Kelola Jadwal
        </a>
    </div>

</div>

{{-- ===== ANTREAN TERBARU ===== --}}
<div class="glass-card rounded-2xl overflow-hidden mb-6">
    <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-lg flex items-center justify-center"
                 style="background: linear-gradient(135deg, #1e2d6b, #2d4499); color: white;">
                <i class="fas fa-list-ol text-sm"></i>
            </div>
            <div>
                <h3 class="font-bold text-slate-800 text-sm">Antrean Menunggu Pemeriksaan</h3>
                <p class="text-xs text-slate-400">Pasien belum mendapat penanganan</p>
            </div>
        </div>
        <a href="{{ route('periksa-pasien.index') }}"
           class="text-xs font-semibold px-3 py-1.5 rounded-lg transition-all hover:opacity-80"
           style="background: #f0f4ff; color: #2d4499;">Lihat Semua →</a>
    </div>

    @if($antrean_terbaru->count() > 0)
    <div class="divide-y divide-slate-50">
        @foreach($antrean_terbaru as $index => $antrian)
        <div class="flex items-center gap-4 px-6 py-4 row-hover transition-colors slide-in"
             style="animation-delay: {{ $index * 0.07 }}s;">
            <div class="antrian-badge">{{ $antrian->no_antrian }}</div>
            <div class="flex-1 min-w-0">
                <div class="font-semibold text-slate-800 text-sm truncate">
                    {{ $antrian->pasien?->nama ?? 'Tidak diketahui' }}
                </div>
                <div class="text-xs text-slate-400 flex items-center gap-2 mt-0.5">
                    <i class="fas fa-calendar-day"></i>
                    {{ $antrian->jadwalPeriksa?->hari ?? '-' }}
                    · {{ $antrian->jadwalPeriksa?->jam_mulai ?? '-' }}
                    @if($antrian->keluhan)
                    · <span class="italic truncate max-w-[150px]">"{{ $antrian->keluhan }}"</span>
                    @endif
                </div>
            </div>
            <a href="{{ route('periksa-pasien.create', $antrian->id) }}"
               class="flex-shrink-0 flex items-center gap-1.5 text-xs font-bold px-4 py-2 rounded-xl text-white transition-all hover:opacity-90 hover:-translate-y-0.5"
               style="background: linear-gradient(135deg, #1e2d6b, #2d4499);">
                <i class="fas fa-stethoscope"></i> Periksa
            </a>
        </div>
        @endforeach
    </div>
    @else
    <div class="flex flex-col items-center justify-center py-14 text-slate-400">
        <div class="w-16 h-16 rounded-full flex items-center justify-center mb-4"
             style="background: #f0f4ff;">
            <i class="fas fa-check-circle text-3xl" style="color: #2d4499;"></i>
        </div>
        <p class="font-semibold text-slate-600 mb-1">Semua Pasien Sudah Diperiksa</p>
        <p class="text-sm">Tidak ada antrean yang menunggu saat ini.</p>
    </div>
    @endif
</div>

{{-- ===== QUICK ACCESS ===== --}}
<div class="glass-card rounded-2xl p-6 relative overflow-hidden">
    <div class="absolute left-0 top-0 bottom-0 w-1 rounded-l-2xl"
         style="background: linear-gradient(180deg, #1e2d6b, #4561c2);"></div>
    <h3 class="font-bold text-slate-800 mb-4 ml-3 flex items-center gap-2 text-sm">
        <i class="fas fa-bolt" style="color: #2d4499;"></i> Aksi Cepat
    </h3>
    <div class="flex flex-wrap gap-3 ml-3">
        <a href="{{ route('jadwal-periksa.index') }}"
           class="flex items-center gap-2 px-4 py-2.5 rounded-xl border text-sm font-semibold transition-all hover:-translate-y-0.5 bg-[#f0f4ff] border-[#c7d2f0] text-[#2d4499] hover:bg-[#1e2d6b] hover:text-white">
            <i class="fas fa-calendar-plus"></i> Atur Jadwal
        </a>
        <a href="{{ route('periksa-pasien.index') }}"
           class="flex items-center gap-2 px-4 py-2.5 rounded-xl border text-sm font-semibold transition-all hover:-translate-y-0.5 bg-[#f0f4ff] border-[#c7d2f0] text-[#2d4499] hover:bg-[#1e2d6b] hover:text-white">
            <i class="fas fa-notes-medical"></i> Periksa Pasien
        </a>
        <a href="{{ route('riwayat-pasien.index') }}"
           class="flex items-center gap-2 px-4 py-2.5 rounded-xl border text-sm font-semibold transition-all hover:-translate-y-0.5 bg-[#f0f4ff] border-[#c7d2f0] text-[#2d4499] hover:bg-[#1e2d6b] hover:text-white">
            <i class="fas fa-history"></i> Riwayat Pasien
        </a>
    </div>
</div>

</x-layouts.app>