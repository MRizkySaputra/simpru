@extends('layouts.admin')

@section('title', 'Permohonan Masuk')

@section('content')

    {{-- Header --}}
    <div class="mb-8">
        <h2 class="text-3xl font-headline font-extrabold text-[#002045] mb-2">Permohonan Masuk</h2>
        <p class="text-slate-500 text-sm">Daftar permohonan peminjaman ruangan yang memerlukan tindakan.</p>
    </div>

    {{-- Filter Tab Dinamis --}}
    <div class="flex items-center gap-2 mb-8 p-1 bg-slate-200/50 rounded-lg w-fit">
        <a href="/admin/permohonan" class="px-6 py-2 rounded-md text-sm {{ !$status ? 'font-bold bg-white text-[#002045] shadow-sm' : 'font-medium text-slate-500 hover:text-[#002045] hover:bg-white/50' }} transition-colors">Semua</a>
        <a href="/admin/permohonan?status=menunggu" class="px-6 py-2 rounded-md text-sm {{ $status === 'menunggu' ? 'font-bold bg-white text-[#002045] shadow-sm' : 'font-medium text-slate-500 hover:text-[#002045] hover:bg-white/50' }} transition-colors">Menunggu</a>
        <a href="/admin/permohonan?status=disetujui" class="px-6 py-2 rounded-md text-sm {{ $status === 'disetujui' ? 'font-bold bg-white text-[#002045] shadow-sm' : 'font-medium text-slate-500 hover:text-[#002045] hover:bg-white/50' }} transition-colors">Disetujui</a>
        <a href="/admin/permohonan?status=ditolak" class="px-6 py-2 rounded-md text-sm {{ $status === 'ditolak' ? 'font-bold bg-white text-[#002045] shadow-sm' : 'font-medium text-slate-500 hover:text-[#002045] hover:bg-white/50' }} transition-colors">Ditolak</a>
    </div>

    {{-- Tabel Permohonan --}}
    <div class="bg-white rounded-xl overflow-hidden shadow-sm border border-slate-200">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200">
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest">Peminjam & Role</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest">Ruangan</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest">Tanggal & Waktu</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest">Jenis Kegiatan</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest text-center">Status</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">

                    @forelse ($permohonans as $item)
                    @php
                        // Buat Inisial
                        $words = explode(' ', $item->user->name ?? 'User');
                        $initials = strtoupper(substr($words[0], 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''));
                        
                        // Rotasi Warna
                        $bgColors = ['bg-blue-100 text-blue-800', 'bg-purple-100 text-purple-800', 'bg-emerald-100 text-emerald-800'];
                        $avatarBg = $bgColors[$item->id % 3];
                    @endphp
                    <tr class="hover:bg-slate-50/50 transition-colors {{ $loop->even ? 'bg-slate-50/30' : '' }}">
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full {{ $avatarBg }} flex items-center justify-center text-xs font-bold shrink-0">{{ $initials }}</div>
                                <div>
                                    <span class="text-sm font-bold text-[#002045]">{{ $item->user->name ?? 'User' }}</span>
                                    <span class="block w-max mt-1 px-2 py-0.5 bg-slate-100 text-slate-600 text-[9px] font-bold rounded border uppercase tracking-wider">{{ $item->user->role ?? 'Mahasiswa' }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-5 text-sm font-medium text-slate-600">{{ $item->room->name ?? 'Ruangan' }}</td>
                        <td class="px-6 py-5">
                            <p class="text-sm font-semibold text-[#002045]">{{ \Carbon\Carbon::parse($item->date)->translatedFormat('d M Y') }}</p>
                            <p class="text-xs text-slate-400">{{ substr($item->start_time, 0, 5) }} - {{ substr($item->end_time, 0, 5) }} WIB</p>
                        </td>
                        <td class="px-6 py-5">
                            <span class="px-2 py-0.5 bg-indigo-50 text-indigo-600 border-indigo-100 text-[9px] font-bold rounded uppercase tracking-wider border mb-1.5 inline-block">{{ $item->activity_type }}</span>
                            <p class="text-sm text-slate-600 font-medium line-clamp-1">{{ $item->activity_name }}</p>
                        </td>
                        <td class="px-6 py-5 text-center">
                            @if($item->status === 'menunggu')
                                <span class="px-3 py-1 bg-amber-100 text-amber-700 text-[10px] font-bold rounded-full uppercase tracking-wider">Menunggu</span>
                            @elseif($item->status === 'disetujui')
                                <span class="px-3 py-1 bg-emerald-100 text-emerald-700 text-[10px] font-bold rounded-full uppercase tracking-wider">Disetujui</span>
                            @else
                                <span class="px-3 py-1 bg-red-100 text-red-700 text-[10px] font-bold rounded-full uppercase tracking-wider">Ditolak</span>
                            @endif
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex items-center justify-center gap-2">
                                <a href="/admin/detail-permohonan/{{ $item->id }}" class="p-2 bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white rounded transition-all" title="Lihat Detail & Proses">
                                    <span class="material-symbols-outlined text-lg">visibility</span>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-slate-500 text-sm">Belum ada permohonan yang sesuai.</td>
                    </tr>
                    @endforelse

                </tbody>
            </table>
        </div>

        {{-- Pagination Dinamis --}}
        <div class="px-6 py-4 bg-slate-50 flex justify-between items-center border-t border-slate-200">
            <p class="text-xs text-slate-500 font-medium">Menampilkan {{ count($permohonans) }} permohonan</p>
        </div>
    </div>

@endsection