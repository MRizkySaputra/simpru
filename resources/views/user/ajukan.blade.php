@extends('layouts.user')

@section('title', 'Ajukan Peminjaman')

@section('container_class', 'p-8 max-w-[1600px] mx-auto')

@section('content')

    {{-- Header --}}
    <div class="mb-6">
        <h2 class="text-3xl font-extrabold text-[#002045] font-headline tracking-tight">Ajukan Peminjaman</h2>
        <p class="text-slate-500 text-sm mt-1">Pilih ruangan dan waktu yang tersedia, lalu lanjutkan pengajuan.</p>
    </div>

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

            {{-- Pilih Ruangan --}}
            <div class="flex-1 min-w-[160px]">
                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2">Ruangan</label>
                <select class="w-full bg-slate-50 border border-slate-200 rounded-lg py-2.5 px-4 text-sm font-medium focus:ring-2 focus:ring-[#002045]/20 outline-none">
                    <option value="">Semua Ruangan</option>
                    <option value="A-101">Auditorium Utama</option>
                    <option value="A-102">Ruang Teater</option>
                    <option value="B-201">Lab Komputer 01</option>
                    <option value="B-202">Lab Komputer 02</option>
                    <option value="B-301">R. Seminar B</option>
                    <option value="C-101">R. Rapat Senat</option>
                </select>
            </div>

            {{-- Pilih Tanggal --}}
            <div class="flex-1 min-w-[160px]">
                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2">Tanggal</label>
                <input class="w-full bg-slate-50 border border-slate-200 rounded-lg py-2.5 px-4 text-sm font-medium focus:ring-2 focus:ring-[#002045]/20 outline-none"
                       type="date" value="2026-10-24">
            </div>

            {{-- Min Kapasitas --}}
            <div class="w-40">
                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2">Min. Kapasitas</label>
                <div class="flex items-center bg-slate-50 border border-slate-200 rounded-lg py-2.5 px-4">
                    <span class="material-symbols-outlined text-sm text-slate-400 mr-2">group</span>
                    <input class="w-full bg-transparent border-none p-0 focus:ring-0 text-sm font-medium outline-none" placeholder="10" type="number">
                </div>
            </div>

            {{-- Tombol Filter --}}
            <button class="bg-primary-gradient text-white px-6 py-2.5 rounded-lg font-bold text-sm shadow-md hover:opacity-95 flex items-center gap-2">
                <span class="material-symbols-outlined text-sm">search</span> Cari Jadwal
            </button>

            {{-- Navigasi Hari --}}
            <div class="flex items-center gap-2">
                <button class="p-2.5 bg-slate-100 hover:bg-slate-200 rounded-lg transition-colors text-slate-600">
                    <span class="material-symbols-outlined text-xl">chevron_left</span>
                </button>
                <div class="px-4 py-2 bg-[#002045] text-white rounded-lg text-sm font-bold min-w-[130px] text-center">
                    Sabtu, 24 Okt 2026
                </div>
                <button class="p-2.5 bg-slate-100 hover:bg-slate-200 rounded-lg transition-colors text-slate-600">
                    <span class="material-symbols-outlined text-xl">chevron_right</span>
                </button>
            </div>

        </div>
    </div>

    {{-- Legenda --}}
    <div class="flex items-center gap-6 mb-4 px-1">
        <div class="flex items-center gap-2">
            <div class="w-3 h-3 rounded-full bg-slate-300"></div>
            <span class="text-xs font-semibold text-slate-500">Kosong — bisa dipilih</span>
        </div>
        <div class="flex items-center gap-2">
            <div class="w-3 h-3 rounded-full bg-amber-400"></div>
            <span class="text-xs font-semibold text-slate-500">Pending</span>
        </div>
        <div class="flex items-center gap-2">
            <div class="w-3 h-3 rounded-full bg-emerald-500"></div>
            <span class="text-xs font-semibold text-slate-500">Terisi</span>
        </div>
        <div class="flex items-center gap-2">
            <div class="w-3 h-3 rounded-full bg-blue-500"></div>
            <span class="text-xs font-semibold text-slate-500">Pilihan Anda</span>
        </div>
    </div>

    {{-- Kalender Grid Harian --}}
    @php
        $rooms = [
            ['code' => 'A-101', 'name' => 'Auditorium Utama', 'building' => 'Gedung A', 'capacity' => 250],
            ['code' => 'A-102', 'name' => 'Ruang Teater', 'building' => 'Gedung A', 'capacity' => 50],
            ['code' => 'B-201', 'name' => 'Lab Komputer 01', 'building' => 'Gedung B', 'capacity' => 40],
            ['code' => 'B-202', 'name' => 'Lab Komputer 02', 'building' => 'Gedung B', 'capacity' => 40],
            ['code' => 'B-301', 'name' => 'R. Seminar B', 'building' => 'Gedung B', 'capacity' => 80],
            ['code' => 'C-101', 'name' => 'R. Rapat Senat', 'building' => 'Gedung C', 'capacity' => 30],
        ];

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
                [10, 12, 'approved', 'Budi Santoso', 'Kelas Reguler'],
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
            'available' => ['bg' => 'bg-slate-100', 'hover' => 'hover:bg-blue-100', 'text' => '', 'border' => 'border-slate-200'],
            'pending'   => ['bg' => 'bg-amber-50',  'hover' => '',  'text' => 'text-amber-800', 'border' => 'border-amber-200'],
            'approved'  => ['bg' => 'bg-emerald-50','hover' => '',  'text' => 'text-emerald-800','border' => 'border-emerald-200'],
            'selected'  => ['bg' => 'bg-blue-600',  'hover' => '',  'text' => 'text-white', 'border' => 'border-blue-700'],
        ];

        $statusDot = [
            'available' => 'bg-slate-300',
            'pending'   => 'bg-amber-400',
            'approved'  => 'bg-emerald-500',
            'selected'  => 'bg-blue-300',
        ];

        $statusLabel = [
            'available' => 'Kosong',
            'pending'   => 'Pending',
            'approved'  => 'Terisi',
            'selected'  => 'Dipilih',
        ];

        // Slot yang dipilih user (contoh statis)
        $selectedSlot = ['room' => 'B-202', 'hour' => 10];
    @endphp

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden mb-6">
        <div class="overflow-x-auto">
            <div style="min-width: {{ 80 + (count($rooms) * 160) }}px">

                {{-- Header Ruangan --}}
                <div class="flex border-b border-slate-200 bg-slate-50 sticky top-0 z-10">
                    <div class="w-20 shrink-0 px-3 py-4 border-r border-slate-200">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Jam</span>
                    </div>
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
                <div class="max-h-[560px] overflow-y-auto">
                    @foreach ($hours as $hour)
                        <div class="flex border-b border-slate-100 last:border-b-0">

                            {{-- Label Jam --}}
                            <div class="w-20 shrink-0 px-3 border-r border-slate-200 flex items-center justify-end">
                                <span class="text-[11px] font-bold text-slate-400">
                                    {{ str_pad($hour, 2, '0', STR_PAD_LEFT) }}:00
                                </span>
                            </div>

                            {{-- Slot per Ruangan --}}
                            @foreach ($rooms as $room)
                                @php
                                    $isSelected = ($selectedSlot['room'] === $room['code'] && $selectedSlot['hour'] === $hour);
                                    $slotStatus = 'available';
                                    $slotData = null;

                                    foreach ($bookings[$room['code']] ?? [] as $booking) {
                                        if ($hour >= $booking[0] && $hour < $booking[1]) {
                                            $slotStatus = $booking[2];
                                            $slotData = $booking;
                                            break;
                                        }
                                    }

                                    if ($isSelected) $slotStatus = 'selected';
                                    $cfg = $statusConfig[$slotStatus];
                                    $canClick = ($slotStatus === 'available' || $slotStatus === 'selected');
                                @endphp

                                <div class="flex-1 min-w-[160px] h-14 border-r border-slate-100 last:border-r-0 p-1">

                                    @if ($slotStatus === 'available')
                                        <button class="w-full h-full rounded-lg {{ $cfg['bg'] }} {{ $cfg['hover'] }} border border-dashed {{ $cfg['border'] }} transition-all flex items-center justify-center group cursor-pointer">
                                            <span class="material-symbols-outlined text-slate-300 text-sm opacity-0 group-hover:opacity-100 transition-opacity">add_circle</span>
                                        </button>

                                    @elseif ($slotStatus === 'selected')
                                        <div class="w-full h-full rounded-lg {{ $cfg['bg'] }} border {{ $cfg['border'] }} px-2 py-1 cursor-pointer flex items-center gap-2">
                                            <span class="material-symbols-outlined text-white text-sm">check_circle</span>
                                            <div>
                                                <p class="text-[9px] font-bold text-white uppercase tracking-wider">Dipilih</p>
                                                <p class="text-[10px] text-blue-200">{{ str_pad($hour, 2, '0', STR_PAD_LEFT) }}:00 - {{ str_pad($hour + 1, 2, '0', STR_PAD_LEFT) }}:00</p>
                                            </div>
                                        </div>

                                    @else
                                        <div class="w-full h-full rounded-lg {{ $cfg['bg'] }} border {{ $cfg['border'] }} px-2 py-1 relative overflow-hidden cursor-not-allowed">
                                            <div class="absolute left-0 top-0 bottom-0 w-1 rounded-l-lg {{ $statusDot[$slotStatus] }}"></div>
                                            <div class="pl-2">
                                                <div class="flex items-center gap-1 mb-0.5">
                                                    <span class="w-1.5 h-1.5 rounded-full {{ $statusDot[$slotStatus] }} shrink-0"></span>
                                                    <span class="text-[9px] font-bold uppercase tracking-wider {{ $cfg['text'] }}">
                                                        {{ $statusLabel[$slotStatus] }}
                                                    </span>
                                                </div>
                                                @if ($slotData)
                                                    <p class="text-[10px] font-bold text-slate-600 truncate leading-tight">{{ $slotData[3] }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    @endif

                                </div>
                            @endforeach

                        </div>
                    @endforeach
                </div>

            </div>
        </div>

        {{-- Footer --}}
        <div class="px-6 py-4 bg-slate-50 border-t border-slate-200 flex items-center justify-between">
            <p class="text-xs text-slate-500 font-medium">
                Menampilkan <span class="font-bold text-slate-700">{{ count($rooms) }}</span> ruangan •
                Sabtu, 24 Oktober 2026
            </p>
            <p class="text-xs text-slate-400 italic">Klik slot abu-abu untuk memilih waktu peminjaman</p>
        </div>

    </div>

    {{-- Info Slot Terpilih + Tombol Lanjut --}}
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
            <div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widests mb-2">Slot Terpilih</p>
                <div class="flex items-center gap-6">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 bg-blue-50 rounded-lg flex items-center justify-center">
                            <span class="material-symbols-outlined text-blue-600 text-sm">meeting_room</span>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-[#002045]">Lab Komputer 02</p>
                            <p class="text-xs text-slate-500">Gedung B • Kapasitas 40 orang</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 bg-blue-50 rounded-lg flex items-center justify-center">
                            <span class="material-symbols-outlined text-blue-600 text-sm">schedule</span>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-[#002045]">10:00 - 11:00 WIB</p>
                            <p class="text-xs text-slate-500">Sabtu, 24 Oktober 2026</p>
                        </div>
                    </div>
                </div>
            </div>
            <a href="/user/ajukan-detail"
               class="bg-primary-gradient text-white px-8 py-3.5 rounded-xl font-bold text-sm shadow-lg hover:opacity-95 active:scale-[0.98] transition-all flex items-center gap-2 shrink-0">
                Lanjut Isi Formulir
                <span class="material-symbols-outlined text-lg">arrow_forward</span>
            </a>
        </div>
    </div>

@endsection
