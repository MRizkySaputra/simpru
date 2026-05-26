@extends('layouts.user')

@section('title', 'Notifikasi')

@section('content')

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <h3 class="text-3xl font-bold text-[#002045] tracking-tight font-headline">Pusat Notifikasi</h3>
            <p class="text-slate-500 text-sm mt-1">Pantau status persetujuan peminjaman ruangan Anda.</p>
        </div>
        <button class="flex items-center justify-center gap-2 px-6 py-2.5 bg-white border border-slate-200 text-slate-600 rounded-full text-sm font-bold hover:bg-slate-50 shadow-sm self-start sm:self-auto">
            <span class="material-symbols-outlined text-sm">done_all</span> Tandai Semua Dibaca
        </button>
    </div>

    {{-- Kartu Statistik Dinamis --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white p-5 rounded-xl border border-slate-200 border-l-4 border-l-blue-600 shadow-sm">
            <p class="text-[10px] font-bold uppercase tracking-wider text-slate-500">Total</p>
            <p class="text-2xl font-black text-[#002045] mt-1 font-headline">{{ $total }}</p>
        </div>
        <div class="bg-white p-5 rounded-xl border border-slate-200 border-l-4 border-l-yellow-400 shadow-sm">
            <p class="text-[10px] font-bold uppercase tracking-wider text-slate-500">Menunggu</p>
            <p class="text-2xl font-black text-yellow-600 mt-1 font-headline">{{ $pending }}</p>
        </div>
        <div class="bg-white p-5 rounded-xl border border-slate-200 border-l-4 border-l-emerald-500 shadow-sm">
            <p class="text-[10px] font-bold uppercase tracking-wider text-slate-500">Disetujui</p>
            <p class="text-2xl font-black text-emerald-600 mt-1 font-headline">{{ $approved }}</p>
        </div>
        <div class="bg-white p-5 rounded-xl border border-slate-200 border-l-4 border-l-red-500 shadow-sm">
            <p class="text-[10px] font-bold uppercase tracking-wider text-slate-500">Ditolak</p>
            <p class="text-2xl font-black text-red-600 mt-1 font-headline">{{ $rejected }}</p>
        </div>
    </div>

    {{-- Daftar Notifikasi Dinamis --}}
    <div class="space-y-4">
        @forelse($notifications as $notif)
            @php
                $roomName = $notif->room->name ?? 'Ruangan Tidak Diketahui';
                $dateFormatted = \Carbon\Carbon::parse($notif->created_at)->diffForHumans();
                $bookingDate = \Carbon\Carbon::parse($notif->date)->translatedFormat('d M Y');
                $startTime = substr($notif->start_time, 0, 5);
            @endphp

            @if($notif->status === 'disetujui')
                {{-- Notif Disetujui --}}
                <div class="group relative flex items-start gap-6 p-6 bg-white rounded-xl shadow-sm border border-slate-200 border-l-4 border-l-emerald-500 transition-all hover:translate-x-1 hover:shadow-md">
                    <div class="flex gap-4 w-full">
                        <div class="flex-shrink-0 w-12 h-12 rounded-full bg-emerald-50 border border-emerald-100 flex items-center justify-center text-emerald-600">
                            <span class="material-symbols-outlined">check_circle</span>
                        </div>
                        <div class="flex-1">
                            <div class="flex justify-between items-start mb-1.5">
                                <h4 class="font-bold text-[#002045] text-base">Permohonan Disetujui</h4>
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $dateFormatted }}</span>
                            </div>
                            <p class="text-sm text-slate-600 mb-3">
                                Peminjaman <span class="font-bold text-[#002045]">{{ $roomName }}</span> telah disetujui oleh Admin. Jangan lupa cetak bukti peminjaman.
                            </p>
                            <div class="flex flex-wrap items-center gap-5 text-xs text-slate-500 font-medium">
                                <span class="flex items-center gap-1.5"><span class="material-symbols-outlined text-sm">calendar_today</span> {{ $bookingDate }}</span>
                                <span class="flex items-center gap-1.5"><span class="material-symbols-outlined text-sm">schedule</span> {{ $startTime }} WIB</span>
                            </div>
                        </div>
                    </div>
                </div>

            @elseif($notif->status === 'ditolak')
                {{-- Notif Ditolak --}}
                <div class="bg-slate-50 border border-slate-200 rounded-xl p-6 hover:bg-slate-100 transition-colors cursor-pointer border-l-4 border-l-red-500">
                    <div class="flex gap-4">
                        <div class="flex-shrink-0 w-12 h-12 rounded-full bg-red-50 border border-red-100 flex items-center justify-center text-red-500">
                            <span class="material-symbols-outlined">cancel</span>
                        </div>
                        <div class="flex-1">
                            <div class="flex justify-between items-start mb-1.5">
                                <h4 class="font-bold text-slate-700 text-base">Permohonan Ditolak</h4>
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $dateFormatted }}</span>
                            </div>
                            <p class="text-sm text-slate-600 mb-3">
                                Pengajuan <span class="font-bold text-slate-700">{{ $roomName }}</span> tidak dapat diproses saat ini.
                            </p>
                            @if($notif->rejection_reason)
                            <div class="bg-white p-3.5 rounded-lg border border-red-100 border-l-2 border-l-red-500 mb-3">
                                <p class="text-xs text-red-600 font-medium leading-relaxed">
                                    "{{ $notif->rejection_reason }}"
                                </p>
                            </div>
                            @endif
                            <div class="flex flex-wrap items-center gap-5 text-xs text-slate-400 font-medium">
                                <span class="flex items-center gap-1.5"><span class="material-symbols-outlined text-sm">calendar_today</span> {{ $bookingDate }}</span>
                            </div>
                        </div>
                    </div>
                </div>

            @else
                {{-- Notif Menunggu --}}
                <div class="group relative flex items-start gap-6 p-6 bg-white rounded-xl shadow-sm border border-slate-200 border-l-4 border-l-yellow-400 transition-all hover:translate-x-1 hover:shadow-md">
                    <div class="flex gap-4 w-full">
                        <div class="flex-shrink-0 w-12 h-12 rounded-full bg-amber-50 border border-amber-100 flex items-center justify-center text-amber-600">
                            <span class="material-symbols-outlined">schedule</span>
                        </div>
                        <div class="flex-1">
                            <div class="flex justify-between items-start mb-1.5">
                                <h4 class="font-bold text-[#002045] text-base">Menunggu Konfirmasi</h4>
                                <span class="text-[10px] font-bold text-blue-700 bg-blue-100 border border-blue-200 px-2.5 py-0.5 rounded-full uppercase tracking-widest">Baru</span>
                            </div>
                            <p class="text-sm text-slate-600 mb-3">
                                Pengajuan <span class="font-bold text-[#002045]">{{ $roomName }}</span> berhasil dikirim dan sedang dalam tahap verifikasi admin.
                            </p>
                            <div class="flex flex-wrap items-center gap-5 text-xs text-slate-500 font-medium">
                                <span class="flex items-center gap-1.5"><span class="material-symbols-outlined text-sm">calendar_today</span> {{ $bookingDate }}</span>
                                <span class="flex items-center gap-1.5"><span class="material-symbols-outlined text-sm">schedule</span> {{ $startTime }} WIB</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @empty
            <div class="bg-white rounded-xl p-10 text-center border border-slate-200">
                <div class="w-16 h-16 bg-slate-100 text-slate-400 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="material-symbols-outlined text-3xl">notifications_off</span>
                </div>
                <h3 class="text-lg font-bold text-[#002045] mb-1">Belum Ada Notifikasi</h3>
                <p class="text-sm text-slate-500">Semua pemberitahuan terkait peminjaman Anda akan muncul di sini.</p>
            </div>
        @endforelse
    </div>

@endsection