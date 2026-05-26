@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')

    {{-- Selamat Datang --}}
    <div class="flex flex-col md:flex-row justify-between items-end gap-6 bg-white p-8 rounded-2xl shadow-sm border border-slate-200 mb-8">
        <div class="space-y-2">
            <h2 class="text-3xl font-extrabold tracking-tight text-[#002045] font-headline">Selamat Datang, Admin 👋</h2>
            <p class="text-slate-500 font-medium">Berikut ringkasan aktivitas sistem SIMPRU hari ini.</p>
        </div>
        <div class="flex gap-3">
            <a href="/admin/jadwal"
               class="flex items-center gap-2 px-5 py-2.5 bg-white border border-slate-200 text-[#002045] rounded-lg font-bold text-sm hover:bg-slate-50 shadow-sm transition-colors">
                <span class="material-symbols-outlined text-sm">calendar_month</span>
                Lihat Jadwal
            </a>
            <a href="/admin/permohonan"
               class="flex items-center gap-2 px-5 py-2.5 bg-primary-gradient text-white rounded-lg font-bold text-sm shadow-md hover:opacity-95 transition-all">
                <span class="material-symbols-outlined text-sm">inbox</span>
                Tinjau Permohonan
            </a>
        </div>
    </div>

    {{-- Kartu Statistik Utama (Dari Database) --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5 mb-8">

        {{-- Total Ruangan --}}
        <div class="bg-white rounded-xl p-6 border border-slate-200 shadow-sm hover:shadow-md transition-shadow group">
            <div class="flex items-start justify-between mb-5">
                <div class="p-2.5 bg-blue-50 text-[#002045] rounded-lg group-hover:bg-[#002045] group-hover:text-white transition-colors">
                    <span class="material-symbols-outlined">meeting_room</span>
                </div>
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Total Ruangan</span>
            </div>
            <p class="text-4xl font-black text-[#002045] font-headline">{{ $stats['total_ruangan'] }}</p>
            <div class="flex items-center gap-2 mt-3 pt-3 border-t border-slate-100">
                <span class="flex items-center gap-1 text-xs font-bold text-emerald-600">
                    <span class="material-symbols-outlined text-sm">check_circle</span>
                </span>
                <span class="text-xs text-slate-400 font-medium">Aktif terdaftar di sistem</span>
            </div>
        </div>

        {{-- Permohonan Menunggu --}}
        <div class="bg-white rounded-xl p-6 border border-slate-200 shadow-sm hover:shadow-md transition-shadow group">
            <div class="flex items-start justify-between mb-5">
                <div class="p-2.5 bg-amber-50 text-amber-600 rounded-lg group-hover:bg-amber-500 group-hover:text-white transition-colors">
                    <span class="material-symbols-outlined">pending_actions</span>
                </div>
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Permohonan</span>
            </div>
            <p class="text-4xl font-black text-amber-600 font-headline">{{ $stats['total_permohonan'] }}</p>
            <div class="flex items-center gap-2 mt-3 pt-3 border-t border-slate-100">
                <span class="flex items-center gap-1 text-xs font-bold text-red-500">
                    <span class="material-symbols-outlined text-sm">priority_high</span> {{ $stats['permohonan_menunggu'] }}
                </span>
                <span class="text-xs text-slate-400 font-medium">menunggu tinjauan</span>
            </div>
        </div>

        {{-- Disetujui --}}
        <div class="bg-white rounded-xl p-6 border border-slate-200 shadow-sm hover:shadow-md transition-shadow group">
            <div class="flex items-start justify-between mb-5">
                <div class="p-2.5 bg-emerald-50 text-emerald-600 rounded-lg group-hover:bg-emerald-500 group-hover:text-white transition-colors">
                    <span class="material-symbols-outlined">check_circle</span>
                </div>
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widests">Disetujui</span>
            </div>
            <p class="text-4xl font-black text-emerald-600 font-headline">{{ $stats['total_disetujui'] }}</p>
            <div class="flex items-center gap-2 mt-3 pt-3 border-t border-slate-100">
                <span class="flex items-center gap-1 text-xs font-bold text-emerald-600">
                    <span class="material-symbols-outlined text-sm">trending_up</span> {{ $stats['persentase_disetujui'] }}
                </span>
                <span class="text-xs text-slate-400 font-medium">bulan ini</span>
            </div>
        </div>

        {{-- Ditolak --}}
        <div class="bg-white rounded-xl p-6 border border-slate-200 shadow-sm hover:shadow-md transition-shadow group">
            <div class="flex items-start justify-between mb-5">
                <div class="p-2.5 bg-red-50 text-red-500 rounded-lg group-hover:bg-red-500 group-hover:text-white transition-colors">
                    <span class="material-symbols-outlined">cancel</span>
                </div>
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widests">Ditolak</span>
            </div>
            <p class="text-4xl font-black text-red-500 font-headline">{{ str_pad($stats['total_ditolak'], 2, '0', STR_PAD_LEFT) }}</p>
            <div class="flex items-center gap-2 mt-3 pt-3 border-t border-slate-100">
                <span class="flex items-center gap-1 text-xs font-bold text-slate-500">
                    <span class="material-symbols-outlined text-sm">trending_down</span> {{ $stats['persentase_ditolak'] }}
                </span>
                <span class="text-xs text-slate-400 font-medium">bulan ini</span>
            </div>
        </div>

    </div>

    {{-- Row: Permohonan Menunggu + Aktivitas Terkini --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 mb-6">

        {{-- Permohonan Menunggu (Dari Database) --}}
        <div class="lg:col-span-7 bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-200 flex items-center justify-between">
                <div>
                    <h3 class="font-headline text-base font-bold text-[#002045]">Permohonan Menunggu Tinjauan</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Memerlukan tindakan segera dari Admin</p>
                </div>
                <a href="/admin/permohonan" class="text-xs font-bold text-[#002045] hover:underline flex items-center gap-1">
                    Lihat Semua <span class="material-symbols-outlined text-sm">arrow_forward</span>
                </a>
            </div>
            <div class="divide-y divide-slate-100">
                
                @forelse ($menungguList as $item)
                    @php
                        // Buat inisial dari nama
                        $words = explode(' ', $item->user->name ?? 'User');
                        $initials = strtoupper(substr($words[0], 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''));
                        
                        // Rotasi warna berdasarkan ID
                        $colors = ['bg-blue-100 text-blue-800', 'bg-purple-100 text-purple-800', 'bg-orange-100 text-orange-800', 'bg-emerald-100 text-emerald-800'];
                        $colorClass = $colors[$item->id % 4];
                    @endphp

                    <div class="flex items-center gap-4 px-6 py-4 hover:bg-slate-50/50 transition-colors">
                        <div class="w-9 h-9 rounded-full {{ $colorClass }} flex items-center justify-center text-xs font-bold shrink-0">
                            {{ $initials }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2">
                                <p class="text-sm font-bold text-[#002045] truncate">{{ $item->user->name ?? 'Mahasiswa' }}</p>
                                {{-- Jika H-1, tandai Urgent --}}
                                @if(\Carbon\Carbon::parse($item->date)->diffInDays(now()) <= 1)
                                    <span class="px-1.5 py-0.5 bg-red-100 text-red-600 text-[9px] font-bold rounded uppercase tracking-wider shrink-0">Urgent</span>
                                @endif
                            </div>
                            <p class="text-xs text-slate-500 truncate">{{ $item->room->name ?? 'Ruangan' }} • {{ \Carbon\Carbon::parse($item->date)->translatedFormat('d M Y') }}, {{ substr($item->start_time, 0, 5) }}</p>
                        </div>
                        <div class="flex items-center gap-1.5 shrink-0">
                            <a href="/admin/detail-permohonan/{{ $item->id }}" class="p-1.5 bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white rounded-lg transition-all" title="Lihat Detail">
                                <span class="material-symbols-outlined text-sm">visibility</span>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center text-slate-400">
                        <span class="material-symbols-outlined text-4xl mb-2">done_all</span>
                        <p class="text-sm font-medium">Bagus! Tidak ada permohonan yang menunggu tinjauan.</p>
                    </div>
                @endforelse

            </div>
        </div>

        {{-- Aktivitas Terkini (Statis Sementara) --}}
        <div class="lg:col-span-5 flex flex-col gap-6">
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden flex-1">
                <div class="px-6 py-5 border-b border-slate-200">
                    <h3 class="font-headline text-base font-bold text-[#002045]">Aktivitas Sistem Terkini</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Log perubahan status hari ini</p>
                </div>
                <div class="p-6 flex items-center justify-center h-full text-slate-400 text-center">
                    <div>
                        <span class="material-symbols-outlined text-4xl mb-2 opacity-50">history</span>
                        <p class="text-sm">Log aktivitas sedang disiapkan.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Row: Jadwal Hari Ini --}}
    <div class="grid grid-cols-1 gap-6">
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-200 flex items-center justify-between">
                <div>
                    <h3 class="font-headline text-base font-bold text-[#002045]">Jadwal Peminjaman Hari Ini</h3>
                    <p class="text-xs text-slate-400 mt-0.5">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
                </div>
            </div>
            <div class="divide-y divide-slate-100">
                
                @forelse ($todaySchedule as $sched)
                    @php
                        $isApproved = $sched->status === 'disetujui';
                    @endphp
                    <div class="flex items-center gap-4 px-6 py-3.5 hover:bg-slate-50/50 transition-colors">
                        <div class="text-right shrink-0 w-24">
                            <p class="text-[11px] font-bold text-[#002045]">{{ substr($sched->start_time, 0, 5) }}</p>
                            <p class="text-[10px] text-slate-400">{{ substr($sched->end_time, 0, 5) }}</p>
                        </div>
                        <div class="w-px h-8 bg-slate-200 shrink-0"></div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-bold text-slate-800 truncate">{{ $sched->activity_name }}</p>
                            <p class="text-xs text-slate-500">{{ $sched->room->name ?? 'Ruangan' }} • {{ $sched->user->name ?? 'User' }}</p>
                        </div>
                        <span class="px-2.5 py-1 text-[10px] font-bold rounded-full {{ $isApproved ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }} uppercase tracking-wider shrink-0 flex items-center gap-1">
                            <span class="w-1.5 h-1.5 rounded-full {{ $isApproved ? 'bg-emerald-500' : 'bg-amber-400' }}"></span>
                            {{ ucfirst($sched->status) }}
                        </span>
                    </div>
                @empty
                    <div class="p-6 text-center text-slate-400 text-sm">
                        Tidak ada jadwal peminjaman ruangan untuk hari ini.
                    </div>
                @endforelse

            </div>
        </div>
    </div>

@endsection