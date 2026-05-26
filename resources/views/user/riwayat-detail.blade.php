@extends('layouts.user')

@section('title', 'Detail Peminjaman')

@section('content')

{{-- Tombol Kembali --}}
<nav class="mb-8 flex items-center gap-2 text-sm text-slate-500">
    <a class="hover:text-[#002045] font-medium transition-colors flex items-center gap-1" href="/user/riwayat">
        <span class="material-symbols-outlined text-base">arrow_back</span> Kembali ke Riwayat
    </a>
</nav>

<div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
    {{-- Kiri: Informasi Peminjaman --}}
    <div class="lg:col-span-7">
        <div class="bg-white rounded-xl p-8 shadow-sm border border-slate-200">
            <div class="flex justify-between items-start mb-8">
                <div>
                    <h2 class="text-2xl font-extrabold text-[#002045] font-headline tracking-tight mb-1">
                        Informasi Peminjaman
                    </h2>
                    <p class="text-sm text-slate-500">
                        Dibuat pada {{ \Carbon\Carbon::parse($booking->created_at)->translatedFormat('d M Y') }} • ID #{{ $booking->req_id }}
                    </p>
                </div>

                {{-- Badge Status Dinamis dari Database --}}
                @if($booking->status === 'disetujui')
                    <span class="px-4 py-1.5 rounded-full bg-emerald-100 text-emerald-700 font-bold text-xs tracking-wider uppercase">Disetujui</span>
                @elseif($booking->status === 'ditolak')
                    <span class="px-4 py-1.5 rounded-full bg-red-100 text-red-700 font-bold text-xs tracking-wider uppercase">Ditolak</span>
                @else
                    <span class="px-4 py-1.5 rounded-full bg-amber-100 text-amber-700 font-bold text-xs tracking-wider uppercase">Diproses</span>
                @endif
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-y-8 gap-x-12">
                
                {{-- Alasan Penolakan (Hanya muncul jika status ditolak di DB) --}}
                @if($booking->status === 'ditolak' && $booking->rejection_reason)
                <div class="md:col-span-2">
                    <div class="bg-red-50 border border-red-100 rounded-xl p-5 flex gap-4 items-start shadow-sm">
                        <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center shrink-0 shadow-sm text-red-500">
                            <span class="material-symbols-outlined text-xl">block</span>
                        </div>
                        <div>
                            <p class="text-[10px] uppercase tracking-widest text-red-500 font-bold mb-1">Alasan Penolakan Admin</p>
                            <p class="text-sm font-medium text-red-800 leading-relaxed">
                                {{ $booking->rejection_reason }}
                            </p>
                        </div>
                    </div>
                </div>
                @endif

                <div>
                    <p class="text-[10px] uppercase tracking-widest text-slate-500 font-bold mb-2">Ruangan</p>
                    <p class="font-bold text-slate-900">{{ $booking->room->name ?? 'Data Ruangan Dihapus' }}</p>
                    <p class="text-xs text-slate-500 mt-1">Gedung {{ $booking->room->building_id ?? 'A' }}</p>
                </div>

                <div>
                    <p class="text-[10px] uppercase tracking-widest text-slate-500 font-bold mb-2">Tanggal & Waktu</p>
                    <p class="font-bold text-slate-900">{{ \Carbon\Carbon::parse($booking->date)->translatedFormat('d M Y') }}</p>
                    <p class="text-xs text-slate-500 mt-1">{{ substr($booking->start_time, 0, 5) }} - {{ substr($booking->end_time, 0, 5) }} WIB</p>
                </div>

                <div>
                    <p class="text-[10px] uppercase tracking-widest text-slate-500 font-bold mb-2">Jenis Kegiatan</p>
                    <p class="font-bold text-slate-900">{{ $booking->activity_type }}</p>
                </div>

                <div>
                    <p class="text-[10px] uppercase tracking-widest text-slate-500 font-bold mb-2">Nama Kegiatan</p>
                    <p class="font-bold text-[#002045] text-lg">{{ $booking->activity_name }}</p>
                </div>

                <div>
                    <p class="text-[10px] uppercase tracking-widest text-slate-500 font-bold mb-2">Estimasi Peserta</p>
                    <p class="font-bold text-slate-900">{{ $booking->participants }} Orang</p>
                </div>

                <div>
                    <p class="text-[10px] uppercase tracking-widest text-slate-500 font-bold mb-2">Penanggung Jawab</p>
                    <p class="font-bold text-slate-900">{{ Auth::user()->name }}</p>
                </div>

                <div class="md:col-span-2 border-t border-slate-100 pt-6 mt-[-1rem]">
                    <p class="text-[10px] uppercase tracking-widest text-slate-500 font-bold mb-2">Fasilitas Ruangan</p>
                    <div class="flex flex-wrap gap-2 mt-2">
                        <span class="px-3 py-1 bg-blue-50 text-blue-700 text-xs font-semibold rounded-full border border-blue-100">Standar Ruangan</span>
                        <span class="px-3 py-1 bg-blue-50 text-blue-700 text-xs font-semibold rounded-full border border-blue-100">AC Central</span>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- Kanan: Surat Permohonan Dinamis --}}
    <div class="lg:col-span-5">
        <div class="bg-white border border-slate-200 rounded-xl p-8 sticky top-24 shadow-sm">
            <div class="flex items-center gap-3 mb-6">
                <span class="material-symbols-outlined text-[#002045] text-3xl">description</span>
                <h3 class="text-lg font-bold text-[#002045] font-headline">Dokumen Lampiran</h3>
            </div>

            @if($booking->document_path)
                <div class="aspect-[3/4] bg-slate-50 rounded-lg overflow-hidden mb-6 border border-slate-200 flex flex-col items-center justify-center p-6 text-center">
                    <div class="w-16 h-16 bg-white shadow-sm rounded-full flex items-center justify-center mb-4 text-red-600">
                        <span class="material-symbols-outlined text-4xl">picture_as_pdf</span>
                    </div>
                    {{-- Menampilkan nama file asli secara dinamis --}}
                    <p class="font-bold text-[#002045] mb-1 truncate w-full px-4">{{ basename($booking->document_path) }}</p>
                    <p class="text-xs text-emerald-600 font-bold mt-1">Berhasil Diunggah</p>
                </div>

                <div class="space-y-3">
                    {{-- Link download file langsung dari storage --}}
                    <a href="{{ asset('storage/' . $booking->document_path) }}" target="_blank" class="w-full py-3 px-4 rounded-lg border-2 border-[#002045] text-[#002045] font-bold flex items-center justify-center gap-2 hover:bg-[#002045]/5 transition-colors">
                        <span class="material-symbols-outlined text-xl">download</span> Unduh Dokumen
                    </a>
                </div>
            @else
                <div class="aspect-[3/4] bg-slate-50 rounded-lg overflow-hidden mb-6 border border-slate-200 flex flex-col items-center justify-center p-6 text-center">
                    <div class="w-16 h-16 bg-white shadow-sm rounded-full flex items-center justify-center mb-4 text-slate-400">
                        <span class="material-symbols-outlined text-4xl">description</span>
                    </div>
                    <p class="font-bold text-slate-500 mb-1">Tidak ada dokumen</p>
                </div>
            @endif

            {{-- Tombol Cetak Bukti --}}
            <div class="mt-3">
                @if($booking->status === 'disetujui')
                    <button class="w-full py-3 px-4 rounded-lg bg-primary-gradient text-white font-bold flex items-center justify-center gap-2 hover:opacity-90">
                        <span class="material-symbols-outlined text-xl">print</span> Cetak Bukti
                    </button>
                @else
                    <button class="w-full py-3 px-4 rounded-lg bg-slate-200 text-slate-400 font-bold flex items-center justify-center gap-2 cursor-not-allowed" disabled>
                        <span class="material-symbols-outlined text-xl">print</span> Cetak Bukti (Belum Disetujui)
                    </button>
                @endif
            </div>

        </div>
    </div>
</div>

{{-- Info Box Dinamis Menyesuaikan Status --}}
@if($booking->status === 'disetujui')
    <div class="mt-8 p-6 bg-blue-50 rounded-2xl border border-blue-100">
        <div class="flex gap-4">
            <span class="material-symbols-outlined text-blue-700 mt-0.5">lightbulb</span>
            <p class="text-sm font-medium leading-relaxed text-blue-800">
                <strong>Informasi Penting:</strong> Harap tunjukkan bukti persetujuan ini beserta Kartu Tanda Mahasiswa (KTM) kepada petugas keamanan saat tiba di lokasi untuk mendapatkan akses masuk ruangan.
            </p>
        </div>
    </div>
@elseif($booking->status === 'ditolak')
    <div class="mt-8 p-6 bg-red-50 rounded-2xl border border-red-100">
        <div class="flex gap-4">
            <span class="material-symbols-outlined text-red-600 mt-0.5">info</span>
            <p class="text-sm font-medium leading-relaxed text-red-800">
                Permohonan Anda tidak dapat disetujui. Silakan periksa alasan penolakan di atas atau ajukan ulang untuk tanggal yang berbeda melalui halaman <a href="/user/ajukan" class="font-bold underline hover:text-red-900">Jadwal & Pengajuan</a>.
            </p>
        </div>
    </div>
@else
    <div class="mt-8 p-6 bg-amber-50 rounded-2xl border border-amber-100 flex gap-4">
        <span class="material-symbols-outlined text-amber-600 mt-0.5">pending_actions</span>
        <p class="text-sm font-medium leading-relaxed text-amber-800">
            Permohonan Anda sedang dalam antrean untuk ditinjau oleh Admin SIMPRU. Harap tunggu dan periksa halaman ini secara berkala.
        </p>
    </div>
@endif

@endsection