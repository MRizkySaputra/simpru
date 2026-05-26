@extends('layouts.admin')

@section('title', 'Laporan')

@section('content')

    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10">
        <div>
            <h3 class="text-3xl font-extrabold font-headline text-[#002045] tracking-tight">Analitik Peminjaman</h3>
            <p class="text-slate-500 mt-2 text-sm">Pantau penggunaan ruangan dan status permohonan secara real-time.</p>
        </div>
        <div class="flex flex-wrap items-center gap-3">
            <div class="flex gap-2">
                <button class="bg-white border border-slate-200 text-slate-600 px-4 py-2.5 rounded-lg text-sm font-bold flex items-center gap-2 hover:bg-slate-50 shadow-sm transition-colors">
                    <span class="material-symbols-outlined text-sm text-red-500">picture_as_pdf</span> PDF
                </button>
                <button class="bg-white border border-slate-200 text-slate-600 px-4 py-2.5 rounded-lg text-sm font-bold flex items-center gap-2 hover:bg-slate-50 shadow-sm transition-colors">
                    <span class="material-symbols-outlined text-sm text-green-600">table_view</span> Excel
                </button>
            </div>
        </div>
    </div>

    {{-- Chart + Donut --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 mb-10">
        <div class="lg:col-span-8 bg-white p-8 rounded-xl shadow-sm border border-slate-200">
            <h4 class="font-headline text-lg font-bold text-[#002045] mb-8">Volume Peminjaman per Tipe</h4>
            <div class="h-64 flex items-end justify-between gap-4">
                @forelse ($bars ?? [] as $bar)
                    <div class="flex-1 flex flex-col items-center gap-3">
                        <div class="w-full rounded-t-lg relative group transition-all hover:opacity-90"
                             style="height: {{ $bar['height'] }}%; background-color: {{ isset($bar['active']) && $bar['active'] ? '#002045' : 'rgba(0,32,69,0.1)' }}">
                            <div class="absolute -top-8 left-1/2 -translate-x-1/2 bg-[#002045] text-white text-[10px] px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity">
                                {{ $bar['value'] }}
                            </div>
                        </div>
                        <span class="text-[10px] font-bold text-slate-500 uppercase text-center">{{ $bar['label'] }}</span>
                    </div>
                @empty
                    <p class="text-sm text-slate-400">Belum ada data.</p>
                @endforelse
            </div>
        </div>

        <div class="lg:col-span-4 bg-white p-8 rounded-xl shadow-sm border border-slate-200 flex flex-col">
            <h4 class="font-headline text-lg font-bold text-[#002045] mb-6">Distribusi Status</h4>
            @php
                $pDisetujui = $total > 0 ? ($disetujui / $total) * 100 : 0;
                $pMenunggu = $total > 0 ? ($menunggu / $total) * 100 : 0;
            @endphp
            <div class="flex-1 flex flex-col justify-center items-center">
                <div class="relative w-40 h-40 rounded-full overflow-hidden flex items-center justify-center shadow-inner">
                    <div class="absolute inset-0" style="background: conic-gradient(#002045 0% {{ $pDisetujui }}%, #fcd34d {{ $pDisetujui }}% {{ $pDisetujui + $pMenunggu }}%, #f87171 {{ $pDisetujui + $pMenunggu }}% 100%);"></div>
                    <div class="absolute w-28 h-28 bg-white rounded-full flex flex-col items-center justify-center shadow-sm">
                        <span class="text-2xl font-black font-headline text-[#002045]">{{ $total }}</span>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Total</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabel Riwayat Lengkap --}}
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="p-6 border-b border-slate-200 bg-white">
            <h4 class="font-headline text-lg font-bold text-[#002045]">Daftar Riwayat Lengkap</h4>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200">
                        <th class="px-8 py-4 text-[11px] font-bold text-slate-500 uppercase tracking-wider">Peminjam</th>
                        <th class="px-6 py-4 text-[11px] font-bold text-slate-500 uppercase tracking-wider">Ruangan</th>
                        <th class="px-6 py-4 text-[11px] font-bold text-slate-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-4 text-[11px] font-bold text-slate-500 uppercase tracking-wider">Waktu</th>
                        <th class="px-6 py-4 text-[11px] font-bold text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="px-8 py-4 text-[11px] font-bold text-slate-500 uppercase tracking-wider text-right">Detail</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($riwayats as $item)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-800 font-bold text-xs">
                                    {{ strtoupper(substr($item->user->name ?? 'U', 0, 2)) }}
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-slate-800">{{ $item->user->name ?? 'User' }}</p>
                                    <p class="text-[10px] text-slate-500">{{ $item->user->role ?? 'Mahasiswa' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            <p class="text-sm font-medium text-slate-700">{{ $item->room->name ?? 'N/A' }}</p>
                        </td>
                        <td class="px-6 py-5 text-sm font-medium text-slate-700">{{ \Carbon\Carbon::parse($item->date)->translatedFormat('d M Y') }}</td>
                        <td class="px-6 py-5 text-sm font-medium text-slate-700">{{ substr($item->start_time, 0, 5) }} - {{ substr($item->end_time, 0, 5) }}</td>
                        <td class="px-6 py-5">
                            @php 
                                $status = strtolower($item->status);
                                $color = ['disetujui' => 'emerald', 'menunggu' => 'amber', 'ditolak' => 'red'][$status] ?? 'slate'; 
                            @endphp
                            <span class="px-3 py-1 bg-{{$color}}-100 text-[10px] font-bold text-{{$color}}-700 border border-{{$color}}-200 rounded-full flex items-center w-max gap-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-{{$color}}-600"></span> {{ ucfirst($status) }}
                            </span>
                        </td>
                        <td class="px-8 py-5 text-right">
                            <a href="/admin/detail-permohonan/{{ $item->id }}" class="inline-block p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                <span class="material-symbols-outlined text-sm">visibility</span>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="px-8 py-10 text-center text-slate-500 text-sm">Belum ada riwayat.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-8 py-4 border-t border-slate-200">
            {{ $riwayats->links() }}
        </div>
    </div>
@endsection