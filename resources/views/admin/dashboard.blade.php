<x-layouts.app title="Dashboard Admin">

<style>
    @keyframes float {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-14px) rotate(3deg); }
    }
    @keyframes shimmer {
        0% { background-position: -200% 0; }
        100% { background-position: 200% 0; }
    }
    @keyframes countUp {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .float-icon { animation: float 4s ease-in-out infinite; }
    .stat-num { animation: countUp 0.6s ease-out forwards; }

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
    .gradient-border {
        background: linear-gradient(135deg, #fff, #f0f4ff);
        border: 1.5px solid transparent;
        background-clip: padding-box;
        position: relative;
    }
    .gradient-border::before {
        content: '';
        position: absolute;
        inset: -1.5px;
        border-radius: inherit;
        background: linear-gradient(135deg, #2d4499, #6b7ee0, #1e2d6b);
        z-index: -1;
    }
    .badge-pill {
        display: inline-flex; align-items: center; gap: 4px;
        font-size: 11px; font-weight: 700; padding: 3px 10px;
        border-radius: 999px; letter-spacing: 0.03em;
    }
    .table-row-hover:hover { background: #f0f4ff; }
    .progress-bar {
        height: 4px; border-radius: 2px; overflow: hidden; background: #e8edf8;
    }
    .progress-fill {
        height: 100%; background: linear-gradient(90deg, #1e2d6b, #4561c2);
        border-radius: 2px; transition: width 0.8s ease;
    }
</style>

{{-- ===== HERO BANNER ===== --}}
<div class="relative overflow-hidden rounded-[2rem] p-10 mb-8 text-white"
     style="background: linear-gradient(135deg, #1e2d6b 0%, #2d4499 50%, #3a55c0 100%);">

    {{-- Dekorasi Bulat --}}
    <div class="absolute -top-16 -right-16 w-72 h-72 rounded-full opacity-10"
         style="background: radial-gradient(circle, #ffffff 0%, transparent 70%);"></div>
    <div class="absolute bottom-0 left-1/3 w-56 h-56 rounded-full opacity-10 translate-y-1/2"
         style="background: radial-gradient(circle, #6b7ee0 0%, transparent 70%);"></div>
    <div class="absolute top-0 left-0 w-full h-full opacity-[0.04]"
         style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>

    <div class="relative z-10 flex items-center justify-between gap-6">
        <div>
            <div class="flex items-center gap-3 mb-3">
                <span class="badge-pill bg-white/20 text-white border border-white/30">
                    <i class="fas fa-circle text-[6px] text-emerald-400"></i> Sistem Aktif
                </span>
                <span class="text-white/60 text-sm">{{ now()->translatedFormat('l, d F Y') }}</span>
            </div>
            <h1 class="text-4xl font-extrabold mb-2 tracking-tight leading-tight">
                Dashboard Admin
                <span class="block text-xl font-normal text-blue-200/80 mt-1">Poliklinik Management System</span>
            </h1>
            <p class="text-blue-100/80 text-base max-w-lg leading-relaxed">
                Pantau dan kelola seluruh operasional poliklinik dari satu tempat secara real-time.
            </p>
        </div>
        <div class="hidden lg:flex items-center gap-4 float-icon mr-4">
            <div class="w-24 h-24 rounded-[2rem] bg-white/10 flex items-center justify-center border border-white/20 backdrop-blur-sm">
                <i class="fas fa-hospital text-5xl text-white/60"></i>
            </div>
        </div>
    </div>
</div>

{{-- ===== STATS GRID ===== --}}
<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5 mb-8">

    {{-- Card Dokter --}}
    <div class="glass-card rounded-2xl p-6 card-lift group relative overflow-hidden">
        <div class="absolute top-0 right-0 w-24 h-24 rounded-full opacity-5 -translate-y-8 translate-x-8"
             style="background: #1e2d6b;"></div>
        <div class="flex items-start justify-between mb-4">
            <div class="w-14 h-14 rounded-xl flex items-center justify-center text-2xl transition-all duration-300 group-hover:scale-110"
                 style="background: linear-gradient(135deg, #1e2d6b15, #2d449920); color: #2d4499;">
                <i class="fas fa-user-md"></i>
            </div>
            <span class="badge-pill bg-indigo-50 text-indigo-600 border border-indigo-100">
                <i class="fas fa-arrow-up text-[9px]"></i> Aktif
            </span>
        </div>
        <div class="stat-num">
            <div class="text-4xl font-black mb-1" style="color: #1e2d6b;">{{ $total_dokter }}</div>
            <div class="text-xs font-bold uppercase tracking-wider text-slate-400">Total Dokter</div>
        </div>
        <div class="progress-bar mt-4">
            <div class="progress-fill" style="width: {{ min(($total_dokter / max($total_dokter + 5, 1)) * 100, 100) }}%"></div>
        </div>
        <a href="{{ route('dokter.index') }}" class="mt-3 flex items-center gap-1 text-xs font-semibold transition-colors"
           style="color: #2d4499;">Lihat Detail <i class="fas fa-arrow-right"></i></a>
    </div>

    {{-- Card Pasien --}}
    <div class="glass-card rounded-2xl p-6 card-lift group relative overflow-hidden">
        <div class="absolute top-0 right-0 w-24 h-24 rounded-full opacity-5 -translate-y-8 translate-x-8"
             style="background: #2d4499;"></div>
        <div class="flex items-start justify-between mb-4">
            <div class="w-14 h-14 rounded-xl flex items-center justify-center text-2xl transition-all duration-300 group-hover:scale-110"
                 style="background: linear-gradient(135deg, #2d449915, #4561c220); color: #2d4499;">
                <i class="fas fa-users"></i>
            </div>
            <span class="badge-pill bg-indigo-50 text-indigo-600 border border-indigo-100">
                <i class="fas fa-arrow-up text-[9px]"></i> Terdaftar
            </span>
        </div>
        <div class="stat-num" style="animation-delay: 0.1s;">
            <div class="text-4xl font-black mb-1" style="color: #1e2d6b;">{{ $total_pasien }}</div>
            <div class="text-xs font-bold uppercase tracking-wider text-slate-400">Total Pasien</div>
        </div>
        <div class="progress-bar mt-4">
            <div class="progress-fill" style="width: {{ min(($total_pasien / max($total_pasien + 10, 1)) * 100, 100) }}%"></div>
        </div>
        <a href="{{ route('pasien.index') }}" class="mt-3 flex items-center gap-1 text-xs font-semibold transition-colors"
           style="color: #2d4499;">Lihat Detail <i class="fas fa-arrow-right"></i></a>
    </div>

    {{-- Card Poli --}}
    <div class="glass-card rounded-2xl p-6 card-lift group relative overflow-hidden">
        <div class="absolute top-0 right-0 w-24 h-24 rounded-full opacity-5 -translate-y-8 translate-x-8"
             style="background: #3a55c0;"></div>
        <div class="flex items-start justify-between mb-4">
            <div class="w-14 h-14 rounded-xl flex items-center justify-center text-2xl transition-all duration-300 group-hover:scale-110"
                 style="background: linear-gradient(135deg, #3a55c015, #6b7ee020); color: #3a55c0;">
                <i class="fas fa-clinic-medical"></i>
            </div>
            <span class="badge-pill bg-blue-50 text-blue-600 border border-blue-100">
                <i class="fas fa-check text-[9px]"></i> Ready
            </span>
        </div>
        <div class="stat-num" style="animation-delay: 0.2s;">
            <div class="text-4xl font-black mb-1" style="color: #1e2d6b;">{{ $total_poli }}</div>
            <div class="text-xs font-bold uppercase tracking-wider text-slate-400">Total Poli</div>
        </div>
        <div class="progress-bar mt-4">
            <div class="progress-fill" style="width: {{ min(($total_poli / max($total_poli + 3, 1)) * 100, 100) }}%"></div>
        </div>
        <a href="{{ route('polis.index') }}" class="mt-3 flex items-center gap-1 text-xs font-semibold transition-colors"
           style="color: #2d4499;">Lihat Detail <i class="fas fa-arrow-right"></i></a>
    </div>

    {{-- Card Obat --}}
    <div class="glass-card rounded-2xl p-6 card-lift group relative overflow-hidden">
        <div class="absolute top-0 right-0 w-24 h-24 rounded-full opacity-5 -translate-y-8 translate-x-8"
             style="background: #1a2d7a;"></div>
        <div class="flex items-start justify-between mb-4">
            <div class="w-14 h-14 rounded-xl flex items-center justify-center text-2xl transition-all duration-300 group-hover:scale-110"
                 style="background: linear-gradient(135deg, #1a2d7a15, #2d449920); color: #1a2d7a;">
                <i class="fas fa-pills"></i>
            </div>
            <span class="badge-pill bg-amber-50 text-amber-600 border border-amber-100">
                <i class="fas fa-box text-[9px]"></i> Stok
            </span>
        </div>
        <div class="stat-num" style="animation-delay: 0.3s;">
            <div class="text-4xl font-black mb-1" style="color: #1e2d6b;">{{ $total_obat }}</div>
            <div class="text-xs font-bold uppercase tracking-wider text-slate-400">Total Obat</div>
        </div>
        <div class="progress-bar mt-4">
            <div class="progress-fill" style="width: {{ min(($total_obat / max($total_obat + 5, 1)) * 100, 100) }}%"></div>
        </div>
        <a href="{{ route('obat.index') }}" class="mt-3 flex items-center gap-1 text-xs font-semibold transition-colors"
           style="color: #2d4499;">Lihat Detail <i class="fas fa-arrow-right"></i></a>
    </div>

</div>

{{-- ===== ANTREAN TODAY BANNER ===== --}}
<div class="rounded-2xl p-5 mb-8 flex items-center gap-4 border"
     style="background: linear-gradient(135deg, #f0f4ff, #e8edf8); border-color: #c7d2f0;">
    <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0"
         style="background: linear-gradient(135deg, #1e2d6b, #2d4499); color: white;">
        <i class="fas fa-clock text-lg"></i>
    </div>
    <div class="flex-1">
        <div class="text-sm font-semibold text-slate-500 mb-0.5">Antrean Aktif Hari Ini</div>
        <div class="text-2xl font-black" style="color: #1e2d6b;">{{ $antrean_hari_ini }} <span class="text-base font-semibold text-slate-400">pasien menunggu</span></div>
    </div>
    <a href="{{ route('pasien.index') }}" class="px-5 py-2.5 rounded-xl text-white text-sm font-bold transition-all hover:opacity-90 flex items-center gap-2 flex-shrink-0"
       style="background: linear-gradient(135deg, #1e2d6b, #2d4499);">
        <i class="fas fa-eye"></i> Lihat Semua
    </a>
</div>

{{-- ===== 2 KOLOM: Pasien Terbaru + Dokter Terbaru ===== --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">

    {{-- Pasien Terbaru --}}
    <div class="glass-card rounded-2xl overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg flex items-center justify-center"
                     style="background: linear-gradient(135deg, #1e2d6b, #2d4499); color: white;">
                    <i class="fas fa-users text-sm"></i>
                </div>
                <div>
                    <h3 class="font-bold text-slate-800 text-sm">Pasien Terbaru</h3>
                    <p class="text-xs text-slate-400">5 pendaftaran terakhir</p>
                </div>
            </div>
            <a href="{{ route('pasien.index') }}"
               class="text-xs font-semibold px-3 py-1.5 rounded-lg transition-all hover:opacity-80"
               style="background: #f0f4ff; color: #2d4499;">Lihat Semua →</a>
        </div>
        <div class="divide-y divide-slate-50">
            @forelse($pasien_terbaru as $pasien)
            <div class="flex items-center gap-4 px-6 py-3.5 table-row-hover transition-colors">
                <div class="w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold text-white flex-shrink-0"
                     style="background: linear-gradient(135deg, #2d4499, #4561c2);">
                    {{ strtoupper(substr($pasien->nama, 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <div class="font-semibold text-slate-800 text-sm truncate">{{ $pasien->nama }}</div>
                    <div class="text-xs text-slate-400">{{ $pasien->no_hp ?? '-' }}</div>
                </div>
                <div class="text-xs text-slate-400">{{ $pasien->created_at->diffForHumans() }}</div>
            </div>
            @empty
            <div class="px-6 py-8 text-center text-slate-400 text-sm">
                <i class="fas fa-inbox text-2xl mb-2 block opacity-40"></i> Belum ada data pasien
            </div>
            @endforelse
        </div>
    </div>

    {{-- Dokter Terbaru --}}
    <div class="glass-card rounded-2xl overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg flex items-center justify-center"
                     style="background: linear-gradient(135deg, #1e2d6b, #2d4499); color: white;">
                    <i class="fas fa-user-md text-sm"></i>
                </div>
                <div>
                    <h3 class="font-bold text-slate-800 text-sm">Dokter Terdaftar</h3>
                    <p class="text-xs text-slate-400">5 dokter terakhir</p>
                </div>
            </div>
            <a href="{{ route('dokter.index') }}"
               class="text-xs font-semibold px-3 py-1.5 rounded-lg transition-all hover:opacity-80"
               style="background: #f0f4ff; color: #2d4499;">Lihat Semua →</a>
        </div>
        <div class="divide-y divide-slate-50">
            @forelse($dokter_terbaru as $dokter)
            <div class="flex items-center gap-4 px-6 py-3.5 table-row-hover transition-colors">
                <div class="w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold text-white flex-shrink-0"
                     style="background: linear-gradient(135deg, #1e2d6b, #2d4499);">
                    {{ strtoupper(substr($dokter->nama, 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <div class="font-semibold text-slate-800 text-sm truncate">{{ $dokter->nama }}</div>
                    <div class="text-xs text-slate-400">{{ $dokter->poli?->nama_poli ?? 'Belum ada poli' }}</div>
                </div>
                <span class="badge-pill bg-indigo-50 text-indigo-600 border border-indigo-100">
                    <i class="fas fa-stethoscope text-[9px]"></i> Dokter
                </span>
            </div>
            @empty
            <div class="px-6 py-8 text-center text-slate-400 text-sm">
                <i class="fas fa-inbox text-2xl mb-2 block opacity-40"></i> Belum ada data dokter
            </div>
            @endforelse
        </div>
    </div>

</div>

{{-- ===== QUICK ACCESS ===== --}}
<div class="glass-card rounded-2xl p-6 relative overflow-hidden">
    <div class="absolute left-0 top-0 bottom-0 w-1 rounded-l-2xl"
         style="background: linear-gradient(180deg, #1e2d6b, #4561c2);"></div>
    <h3 class="font-bold text-slate-800 mb-5 ml-3 flex items-center gap-2">
        <i class="fas fa-bolt text-sm" style="color: #2d4499;"></i> Aksi Cepat
    </h3>
    <div class="flex flex-wrap gap-3 ml-3">
        <a href="{{ route('obat.index') }}"
           class="flex items-center gap-2 px-5 py-3 rounded-xl border text-sm font-semibold transition-all duration-200 hover:-translate-y-0.5"
           style="background: #f0f4ff; border-color: #c7d2f0; color: #2d4499;"
           onmouseover="this.style.background='#1e2d6b';this.style.color='white';"
           onmouseout="this.style.background='#f0f4ff';this.style.color='#2d4499';">
            <i class="fas fa-boxes"></i> Kelola Obat
        </a>
        <a href="{{ route('dokter.index') }}"
           class="flex items-center gap-2 px-5 py-3 rounded-xl border text-sm font-semibold transition-all duration-200 hover:-translate-y-0.5"
           style="background: #f0f4ff; border-color: #c7d2f0; color: #2d4499;"
           onmouseover="this.style.background='#1e2d6b';this.style.color='white';"
           onmouseout="this.style.background='#f0f4ff';this.style.color='#2d4499';">
            <i class="fas fa-user-md"></i> Kelola Dokter
        </a>
        <a href="{{ route('polis.index') }}"
           class="flex items-center gap-2 px-5 py-3 rounded-xl border text-sm font-semibold transition-all duration-200 hover:-translate-y-0.5"
           style="background: #f0f4ff; border-color: #c7d2f0; color: #2d4499;"
           onmouseover="this.style.background='#1e2d6b';this.style.color='white';"
           onmouseout="this.style.background='#f0f4ff';this.style.color='#2d4499';">
            <i class="fas fa-hospital"></i> Kelola Poli
        </a>
        <a href="{{ route('pasien.index') }}"
           class="flex items-center gap-2 px-5 py-3 rounded-xl border text-sm font-semibold transition-all duration-200 hover:-translate-y-0.5"
           style="background: #f0f4ff; border-color: #c7d2f0; color: #2d4499;"
           onmouseover="this.style.background='#1e2d6b';this.style.color='white';"
           onmouseout="this.style.background='#f0f4ff';this.style.color='#2d4499';">
            <i class="fas fa-bed-pulse"></i> Kelola Pasien
        </a>
    </div>
</div>

</x-layouts.app>