@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

    {{-- Filter Bar --}}
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mb-6">
        <div class="flex flex-wrap items-end gap-4">

            {{-- Pilih Gedung --}}
            <div class="flex-1 min-w-[160px]">
                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2">Gedung</label>
                <select class="w-full bg-slate-50 border border-slate-200 rounded-lg py-2.5 px-4 text-sm font-medium focus:ring-2 focus:ring-[#002045]/20 outline-none">
                    <option value="">Semua Gedung</option>
                    <option value="A">Gedung A (Rektorat)</option>
                    <option value="B">Gedung B (Fakultas Teknik)</option>
                    <option value="C">Gedung C (Fakultas Ekonomi)</option>
                </select>
            </div>

            {{-- Pilih Tanggal --}}
            <div class="flex-1 min-w-[160px]">
                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2">Tanggal</label>
                <input class="w-full bg-slate-50 border border-slate-200 rounded-lg py-2.5 px-4 text-sm font-medium focus:ring-2 focus:ring-[#002045]/20 outline-none"
                       type="date" value="2026-10-24">
            </div>

            {{-- Filter Status --}}
            <div class="flex-1 min-w-[160px]">
                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-widests mb-2">Status</label>
                <select class="w-full bg-slate-50 border border-slate-200 rounded-lg py-2.5 px-4 text-sm font-medium focus:ring-2 focus:ring-[#002045]/20 outline-none">
                    <option value="">Semua Status</option>
                    <option value="available">Kosong</option>
                    <option value="pending">Pending</option>
                    <option value="approved">Disetujui</option>
                </select>
            </div>

            {{-- Navigasi Hari --}}
            <div class="flex items-center gap-2 ml-auto">
                <button class="p-2.5 bg-slate-100 hover:bg-slate-200 rounded-lg transition-colors text-slate-600">
                    <span class="material-symbols-outlined text-xl">chevron_left</span>
                </button>
                <div class="px-4 py-2 bg-[#002045] text-white rounded-lg text-sm font-bold min-w-[130px] text-center">
                    Sabtu, 24 Okt 2026
                </div>
                <button class="p-2.5 bg-slate-100 hover:bg-slate-200 rounded-lg transition-colors text-slate-600">
                    <span class="material-symbols-outlined text-xl">chevron_right</span>
                </button>
                <button class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 rounded-lg text-sm font-bold text-slate-600 transition-colors">
                    Hari Ini
                </button>
                <button class="px-4 py-2.5 bg-primary-gradient text-white rounded-lg text-sm font-bold shadow-md hover:opacity-90 flex items-center gap-2">
                    <span class="material-symbols-outlined text-sm">add</span> Booking Baru
                </button>
            </div>

        </div>
    </div>

    {{-- Legenda --}}
    <div class="flex items-center gap-6 mb-4 px-1">
        <div class="flex items-center gap-2">
            <div class="w-3 h-3 rounded-full bg-slate-300"></div>
            <span class="text-xs font-semibold text-slate-500">Kosong</span>
        </div>
        <div class="flex items-center gap-2">
            <div class="w-3 h-3 rounded-full bg-amber-400"></div>
            <span class="text-xs font-semibold text-slate-500">Pending</span>
        </div>
        <div class="flex items-center gap-2">
            <div class="w-3 h-3 rounded-full bg-emerald-500"></div>
            <span class="text-xs font-semibold text-slate-500">Disetujui</span>
        </div>
        <div class="flex items-center gap-2">
            <div class="w-3 h-3 rounded-full bg-red-400"></div>
            <span class="text-xs font-semibold text-slate-500">Ditolak</span>
        </div>
    </div>

    {{-- Kalender Grid Harian --}}
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">

        {{-- Data Ruangan (kolom horizontal) --}}
        @php
            $rooms = [
                ['code' => 'A-101', 'name' => 'Auditorium Utama', 'building' => 'Gedung A', 'capacity' => 250],
                ['code' => 'A-102', 'name' => 'Ruang Teater', 'building' => 'Gedung A', 'capacity' => 50],
                ['code' => 'B-201', 'name' => 'Lab Komputer 01', 'building' => 'Gedung B', 'capacity' => 40],
                ['code' => 'B-202', 'name' => 'Lab Komputer 02', 'building' => 'Gedung B', 'capacity' => 40],
                ['code' => 'B-301', 'name' => 'R. Seminar B', 'building' => 'Gedung B', 'capacity' => 80],
                ['code' => 'C-101', 'name' => 'R. Rapat Senat', 'building' => 'Gedung C', 'capacity' => 30],
            ];

            // status: available, pending, approved, rejected
            // format: [jam_mulai, jam_selesai, status, nama_peminjam, keperluan]
            $bookings = [
                'A-101' => [
                    [8, 11, 'approved', 'Diana Lestari', 'Wisuda Gelombang II'],
                    [13, 15, 'pending', 'BEM FT', 'Seminar Nasional'],
                ],
                'A-102' => [
                    [9, 11, 'approved', 'Aditya Nugraha', 'Praktikum Algoritma'],
                    [14, 16, 'pending', 'Siti Rahayu', 'Workshop Desain'],
                ],
                'B-201' => [
                    [7, 9, 'approved', 'Rina Marlina', 'Praktikum Jaringan'],
                    [10, 12, 'rejected', 'Budi Santoso', 'Ujian Susulan'],
                ],
                'B-202' => [
                    [13, 15, 'approved', 'Ahmad Fauzi', 'Pemrograman Web'],
                ],
                'B-301' => [],
                'C-101' => [
                    [9, 10, 'pending', 'Bambang P.', 'Rapat Koordinasi'],
                ],
            ];

            $hours = range(7, 20);

            $statusConfig = [
                'available' => ['bg' => 'bg-slate-100', 'hover' => 'hover:bg-slate-200', 'text' => '', 'border' => 'border-slate-200'],
                'pending'   => ['bg' => 'bg-amber-50',  'hover' => 'hover:bg-amber-100', 'text' => 'text-amber-800', 'border' => 'border-amber-200'],
                'approved'  => ['bg' => 'bg-emerald-50','hover' => 'hover:bg-emerald-100','text' => 'text-emerald-800','border' => 'border-emerald-200'],
                'rejected'  => ['bg' => 'bg-red-50',    'hover' => 'hover:bg-red-100',   'text' => 'text-red-800',   'border' => 'border-red-200'],
            ];

            $statusDot = [
                'available' => 'bg-slate-300',
                'pending'   => 'bg-amber-400',
                'approved'  => 'bg-emerald-500',
                'rejected'  => 'bg-red-400',
            ];

            $statusLabel = [
                'available' => 'Kosong',
                'pending'   => 'Pending',
                'approved'  => 'Disetujui',
                'rejected'  => 'Ditolak',
            ];
        @endphp

        <div class="overflow-x-auto">
            <div style="min-width: {{ 80 + (count($rooms) * 160) }}px">

                {{-- Header Ruangan --}}
                <div class="flex border-b border-slate-200 bg-slate-50 sticky top-0 z-20">
                    {{-- Kolom Jam --}}
                    <div class="w-20 shrink-0 px-3 py-4 border-r border-slate-200">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Jam</span>
                    </div>
                    {{-- Kolom per Ruangan --}}
                    @foreach ($rooms as $room)
                        <div class="flex-1 min-w-[160px] px-3 py-3 border-r border-slate-200 last:border-r-0">
                            <p class="text-xs font-extrabold text-[#002045] truncate">{{ $room['name'] }}</p>
                            <p class="text-[10px] text-slate-400 font-medium mt-0.5">{{ $room['building'] }} • {{ $room['code'] }}</p>
                            <div class="flex items-center gap-1 mt-1">
                                <span class="material-symbols-outlined text-[12px] text-slate-400">group</span>
                                <span class="text-[10px] text-slate-400 font-medium">{{ $room['capacity'] }} orang</span>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Baris Per Jam --}}
                <div class="max-h-[600px] overflow-y-auto">
                    @foreach ($hours as $hour)
                        <div class="flex border-b border-slate-100 last:border-b-0 hover:bg-slate-50/30 transition-colors">

                            {{-- Label Jam --}}
                            <div class="w-20 shrink-0 px-3 py-0 border-r border-slate-200 flex items-center justify-end">
                                <span class="text-[11px] font-bold text-slate-400">
                                    {{ str_pad($hour, 2, '0', STR_PAD_LEFT) }}:00
                                </span>
                            </div>

                            {{-- Slot per Ruangan --}}
                            @foreach ($rooms as $room)
                                @php
                                    $slotStatus = 'available';
                                    $slotData = null;
                                    foreach ($bookings[$room['code']] ?? [] as $booking) {
                                        if ($hour >= $booking[0] && $hour < $booking[1]) {
                                            $slotStatus = $booking[2];
                                            $slotData = $booking;
                                            break;
                                        }
                                    }
                                    $cfg = $statusConfig[$slotStatus];
                                @endphp

                                <div class="flex-1 min-w-[160px] h-14 border-r border-slate-100 last:border-r-0 p-1 group relative">

                                    @if ($slotStatus === 'available')
                                        {{-- Slot Kosong: Admin bisa klik untuk buat booking --}}
                                        <button class="w-full h-full rounded-lg {{ $cfg['bg'] }} {{ $cfg['hover'] }} border border-dashed {{ $cfg['border'] }} transition-all flex items-center justify-center opacity-0 group-hover:opacity-100">
                                            <span class="material-symbols-outlined text-slate-400 text-sm">add</span>
                                        </button>
                                        <div class="absolute inset-1 rounded-lg {{ $cfg['bg'] }} border border-dashed {{ $cfg['border'] }} group-hover:opacity-0 transition-all"></div>

                                    @else
                                        {{-- Slot Terisi: tampilkan info booking --}}
                                        <div class="w-full h-full rounded-lg {{ $cfg['bg'] }} border {{ $cfg['border'] }} px-2 py-1 cursor-pointer {{ $cfg['hover'] }} transition-all relative overflow-hidden group/slot">

                                            {{-- Indikator warna kiri --}}
                                            <div class="absolute left-0 top-0 bottom-0 w-1 rounded-l-lg {{ $statusDot[$slotStatus] }}"></div>

                                            <div class="pl-2">
                                                <div class="flex items-center gap-1 mb-0.5">
                                                    <span class="w-1.5 h-1.5 rounded-full {{ $statusDot[$slotStatus] }} shrink-0"></span>
                                                    <span class="text-[9px] font-bold uppercase tracking-wider {{ $cfg['text'] }}">
                                                        {{ $statusLabel[$slotStatus] }}
                                                    </span>
                                                </div>
                                                <p class="text-[10px] font-bold text-slate-700 truncate leading-tight">{{ $slotData[3] }}</p>
                                                <p class="text-[9px] text-slate-500 truncate">{{ $slotData[4] }}</p>
                                            </div>

                                            {{-- Tooltip Aksi Admin (muncul saat hover) --}}
                                            @if ($slotStatus === 'pending')
                                                <div class="absolute inset-0 bg-white/95 rounded-lg border {{ $cfg['border'] }} opacity-0 group-hover/slot:opacity-100 transition-all flex items-center justify-center gap-2 z-10">
                                                    <a href="/admin/detail-permohonan"
                                                       class="p-1.5 bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white rounded transition-all"
                                                       title="Lihat Detail">
                                                        <span class="material-symbols-outlined text-sm">visibility</span>
                                                    </a>
                                                    <button class="p-1.5 bg-emerald-50 text-emerald-600 hover:bg-emerald-600 hover:text-white rounded transition-all" title="Setujui">
                                                        <span class="material-symbols-outlined text-sm">check</span>
                                                    </button>
                                                    <button class="p-1.5 bg-red-50 text-red-500 hover:bg-red-500 hover:text-white rounded transition-all" title="Tolak">
                                                        <span class="material-symbols-outlined text-sm">close</span>
                                                    </button>
                                                </div>
                                            @endif

                                        </div>
                                    @endif

                                </div>
                            @endforeach

                        </div>
                    @endforeach
                </div>

            </div>
        </div>

        {{-- Footer Info --}}
        <div class="px-6 py-4 bg-slate-50 border-t border-slate-200 flex items-center justify-between">
            <p class="text-xs text-slate-500 font-medium">
                Menampilkan <span class="font-bold text-slate-700">{{ count($rooms) }}</span> ruangan •
                Sabtu, 24 Oktober 2026
            </p>
            <p class="text-xs text-slate-400 font-medium italic">
                Hover slot <span class="text-amber-600 font-bold">Pending</span> untuk aksi cepat
            </p>
        </div>

    </div>

@endsection
