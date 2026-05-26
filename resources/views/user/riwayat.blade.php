@extends('layouts.user')

@section('title', 'Riwayat Peminjaman')

@section('content')

    @php
        // Konfigurasi warna badge berdasarkan status asli di database
        $statusStyles = [
            'menunggu'  => ['label' => 'Menunggu',  'class' => 'bg-amber-100 text-amber-800 border-amber-200'],
            'disetujui' => ['label' => 'Disetujui', 'class' => 'bg-emerald-100 text-emerald-800 border-emerald-200'],
            'ditolak'   => ['label' => 'Ditolak',   'class' => 'bg-red-100 text-red-800 border-red-200'],
        ];
    @endphp

    {{-- Header --}}
    <div class="mb-8">
        <h2 class="text-3xl font-headline font-extrabold text-[#002045] mb-2">Riwayat Peminjaman</h2>
        <p class="text-slate-500 text-sm">Pantau status pengajuan peminjaman ruangan Anda secara real-time.</p>
    </div>

    {{-- Filter Area (Statis untuk saat ini) --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div class="flex items-center gap-2 p-1 bg-slate-200/50 rounded-lg w-fit overflow-x-auto max-w-full">
            <button class="px-6 py-2 rounded-md text-sm font-bold bg-white text-[#002045] shadow-sm whitespace-nowrap">Semua</button>
        </div>
    </div>

    {{-- Daftar Riwayat Dinamis (Tersambung ke Database) --}}
    <div class="grid grid-cols-1 gap-6 mb-10">

        @forelse ($bookings as $item)
            @php 
                $status = $statusStyles[$item->status] ?? $statusStyles['menunggu']; 
                
                // Pewarnaan kelas berdasarkan jenis kegiatan
                $jenis_class = 'text-blue-700 bg-blue-50 border-blue-200';
                if(strtolower($item->activity_type) == 'sidang') $jenis_class = 'text-purple-700 bg-purple-50 border-purple-200';
                if(strtolower($item->activity_type) == 'organisasi mahasiswa (ormawa)') $jenis_class = 'text-orange-700 bg-orange-50 border-orange-200';
            @endphp
            
            <div class="bg-white rounded-xl p-6 flex flex-col md:flex-row gap-6 items-start md:items-center border border-slate-200 hover:shadow-md transition-all group">
                
                {{-- Foto Ruangan --}}
                <div class="w-full md:w-48 h-32 rounded-lg overflow-hidden bg-slate-100 flex-shrink-0 border border-slate-100">
                    <img alt="{{ $item->room->name ?? 'Ruangan' }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" 
                         src="{{ ($item->room && $item->room->image_path) ? asset('storage/' . $item->room->image_path) : 'https://images.unsplash.com/photo-1593642632559-0c6d3fc62b89?auto=format&fit=crop&w=400&q=80' }}">
                </div>
                
                {{-- Info Utama --}}
                <div class="flex-1 space-y-2">
                    <div class="flex items-center gap-2">
                        <span class="text-[10px] font-bold uppercase tracking-widest text-slate-500 bg-slate-100 px-2 py-1 rounded">{{ $item->req_id }}</span>
                        <span class="text-[10px] font-bold uppercase tracking-widest border px-2 py-1 rounded {{ $jenis_class }}">
                            {{ $item->activity_type }}
                        </span>
                    </div>
                    <h3 class="text-xl font-headline font-bold text-[#002045]">{{ $item->room->name ?? 'Data Ruangan Dihapus' }}</h3>
                    <div class="flex flex-wrap gap-5 text-sm text-slate-500 pt-1">
                        <div class="flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-base">calendar_today</span>
                            <span>{{ \Carbon\Carbon::parse($item->date)->translatedFormat('d M Y') }}</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-base">schedule</span>
                            <span>{{ substr($item->start_time, 0, 5) }} - {{ substr($item->end_time, 0, 5) }}</span>
                        </div>
                    </div>
                </div>
                
                {{-- Status & Tombol Detail --}}
                <div class="flex flex-row gap-3 w-full md:w-auto md:border-l md:border-slate-100 md:pl-6">
                    <div class="my-auto">
                        <span class="text-xs font-bold px-3 py-1 rounded-full border {{ $status['class'] }}">{{ $status['label'] }}</span>
                    </div>
                    {{-- Tombol ini sekarang mengirim ID Asli ke rute riwayat-detail --}}
                    <a href="/user/riwayat-detail/{{ $item->id }}" class="bg-white border-2 border-[#002045] text-[#002045] text-center px-6 py-2.5 rounded-lg text-sm font-bold hover:bg-blue-50 transition-colors w-full md:w-auto">
                        Lihat Detail
                    </a>
                </div>
            </div>

        @empty
            {{-- Tampilan Jika Belum Ada Data --}}
            <div class="bg-white rounded-xl p-10 text-center border border-slate-200">
                <div class="w-16 h-16 bg-slate-100 text-slate-400 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="material-symbols-outlined text-3xl">inbox</span>
                </div>
                <h3 class="text-lg font-bold text-[#002045] mb-1">Belum Ada Riwayat</h3>
                <p class="text-sm text-slate-500">Anda belum pernah mengajukan peminjaman ruangan.</p>
            </div>
        @endforelse

    </div>

    {{-- Pagination Dinamis --}}
    <div class="flex items-center justify-between border-t border-slate-200 pt-6">
        <p class="text-sm text-slate-500 font-medium">Menampilkan {{ count($bookings) }} pengajuan</p>
        <div class="flex items-center gap-2">
            <button class="p-2 rounded-lg hover:bg-slate-200 text-slate-400 transition-colors disabled:opacity-50" disabled>
                <span class="material-symbols-outlined">chevron_left</span>
            </button>
            <button class="w-8 h-8 flex items-center justify-center rounded-lg bg-[#002045] text-white text-sm font-bold shadow-sm">1</button>
            <button class="p-2 rounded-lg hover:bg-slate-200 text-slate-400 transition-colors disabled:opacity-50" disabled>
                <span class="material-symbols-outlined">chevron_right</span>
            </button>
        </div>
    </div>

@endsection