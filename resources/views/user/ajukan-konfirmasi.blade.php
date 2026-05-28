@extends('layouts.user')

@section('title', 'Konfirmasi Peminjaman')

@section('content')

@php
    $nama_gedung = str_starts_with(strtolower($room->building_id), 'gedung') 
                   ? $room->building_id 
                   : 'Gedung ' . $room->building_id;

    $timestamp = strtotime($validated['date']);
    $hari_array = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
    $bulan_array = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    
    $hari = $hari_array[date('w', $timestamp)];
    $tgl = date('j', $timestamp);
    $bln = $bulan_array[date('n', $timestamp) - 1];
    $thn = date('Y', $timestamp);
    $tanggal_format = "$hari, $tgl $bln $thn";

    $booking_id = 'REQ-' . date('Ymd', $timestamp) . '-' . rand(100, 999);
@endphp

{{-- Breadcrumb --}}
<nav class="mb-8 flex items-center gap-2 text-sm text-slate-500">
    <a class="hover:text-[#002045] font-medium transition-colors flex items-center gap-1" href="javascript:history.back()">
        <span class="material-symbols-outlined text-base">arrow_back</span> Kembali ke Detail
    </a>
</nav>

{{-- Stepper --}}
<div class="mb-10 max-w-3xl mx-auto">
    <div class="flex items-center justify-between relative">
        <div class="absolute top-1/2 left-0 w-full h-1 bg-[#002045] -translate-y-1/2 z-0"></div>

        <div class="relative z-10 flex flex-col items-center gap-2">
            <div class="w-10 h-10 rounded-full bg-[#002045] text-white flex items-center justify-center font-bold"><span class="material-symbols-outlined text-[20px]">check</span></div>
            <span class="text-xs font-bold text-[#002045] uppercase tracking-wider">Pilih Ruangan</span>
        </div>
        <div class="relative z-10 flex flex-col items-center gap-2">
            <div class="w-10 h-10 rounded-full bg-[#002045] text-white flex items-center justify-center font-bold"><span class="material-symbols-outlined text-[20px]">check</span></div>
            <span class="text-xs font-bold text-[#002045] uppercase tracking-wider">Isi Detail</span>
        </div>
        <div class="relative z-10 flex flex-col items-center gap-2">
            <div class="w-10 h-10 rounded-full bg-[#002045] text-white flex items-center justify-center font-bold shadow-lg ring-4 ring-white">3</div>
            <span class="text-xs font-bold text-[#002045] uppercase tracking-wider">Konfirmasi</span>
        </div>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="p-8 border-b border-slate-100">
        <h2 class="text-2xl font-extrabold text-[#002045] font-headline">Konfirmasi Peminjaman Ruangan</h2>
        <p class="text-slate-500 text-sm mt-1">Tinjau kembali detail permohonan sebelum mengirimkannya.</p>
    </div>

    <div class="p-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
            <div class="lg:col-span-8 space-y-6">
                <div class="bg-slate-50 p-6 rounded-xl border border-slate-200">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Ruangan</label>
                            <h3 class="text-xl font-bold text-[#002045] font-headline">{{ $room->name }}</h3>
                            <p class="text-xs text-slate-500 mt-1">{{ $nama_gedung }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6 text-sm">
                        <div>
                            <label class="text-[10px] text-slate-400 uppercase font-bold">Tanggal</label>
                            <p class="font-semibold text-slate-800 mt-1">{{ $tanggal_format }}</p>
                        </div>
                        <div>
                            <label class="text-[10px] text-slate-400 uppercase font-bold">Waktu</label>
                            <p class="font-semibold text-slate-800 mt-1">{{ $validated['start_time'] }} - {{ $validated['end_time'] }} WIB</p>
                        </div>
                        <div>
                            <label class="text-[10px] text-slate-400 uppercase font-bold">Jenis Kegiatan</label>
                            <p class="font-semibold text-slate-800 mt-1">{{ $validated['activity_type'] }}</p>
                        </div>
                        <div>
                            <label class="text-[10px] text-slate-400 uppercase font-bold">Nama Kegiatan</label>
                            <p class="font-semibold text-slate-800 mt-1">{{ $validated['activity_name'] }}</p>
                        </div>
                        <div>
                            <label class="text-[10px] text-slate-400 uppercase font-bold">Peserta</label>
                            <p class="text-slate-700 mt-1">{{ $validated['participants'] }} Orang</p>
                        </div>
                        <div>
                            <label class="text-[10px] text-slate-400 uppercase font-bold">Keperluan</label>
                            <p class="font-semibold text-slate-800 mt-1">{{ $validated['purpose'] }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-4 space-y-5">
                <div class="flex items-center gap-3 p-3 bg-slate-50 border border-slate-200 rounded-lg">
                    <div class="w-8 h-8 rounded bg-red-50 flex items-center justify-center text-red-500">
                        <span class="material-symbols-outlined text-sm">picture_as_pdf</span>
                    </div>
                    <div class="flex-1">
                        <p class="text-xs font-semibold text-[#002045]">Dokumen Terlampir.pdf</p>
                    </div>
                    <span class="material-symbols-outlined text-green-500 text-lg">check_circle</span>
                </div>

                {{-- FORM FINAL UNTUK INSERT DATABASE --}}
                <form action="/user/ajukan-proses" method="POST">
                    @csrf
                    <input type="hidden" name="room_id" value="{{ $validated['room_id'] }}">
                    <input type="hidden" name="date" value="{{ $validated['date'] }}">
                    <input type="hidden" name="start_time" value="{{ $validated['start_time'] }}">
                    <input type="hidden" name="end_time" value="{{ $validated['end_time'] }}">
                    <input type="hidden" name="activity_name" value="{{ $validated['activity_name'] }}">
                    <input type="hidden" name="activity_type" value="{{ $validated['activity_type'] }}">
                    <input type="hidden" name="participants" value="{{ $validated['participants'] }}">
                    <input type="hidden" name="purpose" value="{{ $validated['purpose'] }}">
                    <input type="hidden" name="document_path" value="{{ $validated['document_path'] }}">

                    <div class="space-y-3 pt-3 border-t border-slate-200">
                        <button type="submit" class="w-full bg-primary-gradient text-white font-bold py-3.5 rounded-lg flex justify-center items-center gap-2 hover:opacity-95 shadow-md">
                            Kirim Permohonan <span class="material-symbols-outlined">send</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection