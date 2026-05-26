@extends('layouts.user')

@section('title', 'Dashboard')

@section('content')

    {{-- Selamat Datang --}}
    <div class="flex flex-col md:flex-row justify-between items-end gap-6 bg-white p-8 rounded-2xl shadow-sm border border-slate-200 mb-8">
        <div class="space-y-2">
            {{-- Mengambil nama user langsung dari Auth --}}
            <h2 class="text-3xl font-extrabold tracking-tight text-[#002045] font-headline">Halo, {{ Auth::user()->name }} 👋</h2>
            <p class="text-slate-500 font-medium">Selamat datang di portal SIMPRU. Ada kegiatan apa hari ini?</p>
        </div>
        <a href="/user/ajukan"
           class="bg-primary-gradient text-white px-8 py-3.5 rounded-xl font-bold flex items-center gap-2 shadow-lg shadow-[#002045]/20 hover:opacity-95 active:scale-[0.98] transition-all">
            <span class="material-symbols-outlined">add_circle</span>
            Ajukan Peminjaman
        </a>
    </div>

    {{-- Kartu Statistik Dinamis --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <div class="bg-white p-6 rounded-xl border-l-4 border-blue-500 shadow-sm hover:shadow-md transition-shadow group">
            <div class="flex items-start justify-between mb-4">
                <div class="p-2 bg-blue-50 text-blue-600 rounded-lg group-hover:bg-blue-500 group-hover:text-white transition-colors">
                    <span class="material-symbols-outlined">event_available</span>
                </div>
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Aktif</span>
            </div>
            <p class="text-3xl font-black text-[#002045] font-headline">{{ str_pad($approvedCount, 2, '0', STR_PAD_LEFT) }}</p>
            <p class="text-sm font-medium text-slate-500 mt-1">Peminjaman Disetujui</p>
        </div>

        <div class="bg-white p-6 rounded-xl border-l-4 border-amber-400 shadow-sm hover:shadow-md transition-shadow group">
            <div class="flex items-start justify-between mb-4">
                <div class="p-2 bg-amber-50 text-amber-600 rounded-lg group-hover:bg-amber-400 group-hover:text-white transition-colors">
                    <span class="material-symbols-outlined">pending_actions</span>
                </div>
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Menunggu</span>
            </div>
            <p class="text-3xl font-black text-[#002045] font-headline">{{ str_pad($pendingCount, 2, '0', STR_PAD_LEFT) }}</p>
            <p class="text-sm font-medium text-slate-500 mt-1">Menunggu Konfirmasi</p>
        </div>

        <div class="bg-white p-6 rounded-xl border-l-4 border-red-500 shadow-sm hover:shadow-md transition-shadow group">
            <div class="flex items-start justify-between mb-4">
                <div class="p-2 bg-red-50 text-red-500 rounded-lg group-hover:bg-red-500 group-hover:text-white transition-colors">
                    <span class="material-symbols-outlined">cancel</span>
                </div>
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Riwayat</span>
            </div>
            <p class="text-3xl font-black text-[#002045] font-headline">{{ str_pad($rejectedCount, 2, '0', STR_PAD_LEFT) }}</p>
            <p class="text-sm font-medium text-slate-500 mt-1">Permohonan Ditolak</p>
        </div>
    </div>

    {{-- Tabel Riwayat Terbaru Dinamis --}}
    <div class="space-y-4 mb-10">
        <div class="flex items-center justify-between">
            <h3 class="text-xl font-bold text-[#002045] font-headline flex items-center gap-2">
                <span class="material-symbols-outlined">history</span> Riwayat Peminjaman
            </h3>
            <a class="text-sm font-bold text-[#002045] hover:text-blue-600 transition-colors flex items-center gap-1" href="/user/riwayat">
                Lihat Semua <span class="material-symbols-outlined text-sm">arrow_forward</span>
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-slate-200">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200">
                            <th class="px-6 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest">Ruangan</th>
                            <th class="px-6 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest">Tanggal</th>
                            <th class="px-6 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest">Waktu</th>
                            <th class="px-6 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest">Keperluan</th>
                            <th class="px-6 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($recentBookings as $booking)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="h-8 w-8 bg-blue-50 border border-blue-100 text-blue-700 rounded-lg flex items-center justify-center">
                                            <span class="material-symbols-outlined text-sm">meeting_room</span>
                                        </div>
                                        <span class="text-sm font-bold text-[#002045]">{{ $booking->room->name ?? 'Ruangan' }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600 font-medium">{{ \Carbon\Carbon::parse($booking->date)->translatedFormat('d M Y') }}</td>
                                <td class="px-6 py-4 text-sm text-slate-600 font-medium">{{ substr($booking->start_time, 0, 5) }} - {{ substr($booking->end_time, 0, 5) }}</td>
                                <td class="px-6 py-4 text-sm text-slate-600">{{ $booking->activity_name }}</td>
                                <td class="px-6 py-4 text-center">
                                    @if($booking->status === 'disetujui')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold bg-green-50 text-green-700 border border-green-200 uppercase tracking-wider">Disetujui</span>
                                    @elseif($booking->status === 'ditolak')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold bg-red-50 text-red-600 border border-red-200 uppercase tracking-wider">Ditolak</span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold bg-amber-100 text-amber-700 border border-amber-200 uppercase tracking-wider">Menunggu</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-sm text-slate-500">Belum ada riwayat peminjaman terbaru.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Rekomendasi Ruangan Dinamis --}}
    <div class="space-y-4">
        <h3 class="text-xl font-bold text-[#002045] font-headline flex items-center gap-2">
            <span class="material-symbols-outlined">explore</span> Rekomendasi Ruangan
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($recommendedRooms as $index => $room)
                <div class="group relative overflow-hidden rounded-2xl aspect-[16/9] bg-slate-900 shadow-md">
                    <img alt="{{ $room->name }}"
                         class="absolute inset-0 w-full h-full object-cover opacity-70 group-hover:scale-110 transition-transform duration-700"
                         src="{{ $room->image_path ? asset('storage/' . $room->image_path) : 'https://images.unsplash.com/photo-1517502884422-41eaead166d4?auto=format&fit=crop&w=800&q=80' }}" />
                    <div class="absolute inset-0 bg-gradient-to-t from-[#002045] via-transparent to-transparent"></div>
                    <div class="absolute bottom-0 left-0 p-6 space-y-2 w-full">
                        <span class="{{ $index == 0 ? 'bg-blue-600' : 'bg-emerald-500' }} text-white text-[10px] font-bold px-2.5 py-1 rounded uppercase tracking-widest">
                            {{ $index == 0 ? 'Populer' : 'Rekomendasi' }}
                        </span>
                        <h4 class="text-xl font-bold text-white font-headline">{{ $room->name }}</h4>
                        <p class="text-slate-200 text-sm">Gedung {{ $room->building_id ?? 'Pusat' }} - Kapasitas {{ $room->capacity }} orang.</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

@endsection