@extends('layouts.admin')

@section('title', 'Notifikasi Admin')

@section('content')
    <div class="max-w-5xl mx-auto">
        
        {{-- Header Halaman --}}
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10">
            <div>
                <nav class="flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-slate-400 mb-3">
                    <span>Admin</span>
                    <span class="material-symbols-outlined text-[10px]">chevron_right</span>
                    <span class="text-[#002045]">Notifikasi</span>
                </nav>
                <h2 class="text-3xl font-extrabold text-[#002045] font-headline tracking-tight">Notifikasi Sistem</h2>
            </div>
            <button class="flex items-center gap-2 px-6 py-2.5 bg-blue-50 text-[#002045] rounded-lg font-bold text-sm hover:bg-blue-100 transition-colors border border-blue-100">
                <span class="material-symbols-outlined text-sm">done_all</span>
                Tandai Semua Dibaca
            </button>
        </div>

        {{-- Daftar Notifikasi Dinamis --}}
        <div class="space-y-4">
            
            @forelse($notifications as $notif)
                {{-- Penentuan Warna & Icon Berdasarkan Tipe --}}
                @php
                    $bgClass = $notif->is_read ? 'bg-slate-50/50 grayscale hover:grayscale-0' : 'bg-white border-l-4 border-l-[#002045]';
                    
                    if($notif->type === 'urgent') {
                        $iconBg = 'bg-red-50 text-red-600';
                        $icon = 'priority_high';
                        $badgeClass = 'bg-red-50 text-red-600 border-red-100';
                    } elseif($notif->type === 'maintenance') {
                        $iconBg = 'bg-orange-50 text-orange-600';
                        $icon = 'cleaning_services';
                        $badgeClass = 'bg-orange-50 text-orange-600 border-orange-100';
                    } elseif($notif->type === 'report') {
                        $iconBg = 'bg-slate-200 text-slate-500';
                        $icon = 'file_download';
                        $badgeClass = 'bg-slate-200 text-slate-600 border-slate-200';
                    } else {
                        // Default / Info System
                        $iconBg = 'bg-blue-50 text-[#002045]';
                        $icon = 'info';
                        $badgeClass = 'bg-blue-50 text-[#002045] border-blue-100';
                    }
                @endphp

                <div class="group relative flex items-start gap-6 p-6 rounded-xl shadow-sm border border-slate-200 transition-all hover:translate-x-1 hover:shadow-md {{ $bgClass }}">
                    <div class="mt-1 flex-shrink-0">
                        <div class="w-10 h-10 rounded-lg flex items-center justify-center {{ $iconBg }}">
                            <span class="material-symbols-outlined">{{ $icon }}</span>
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex justify-between items-start mb-1">
                            <h3 class="font-headline font-bold text-slate-800 text-lg leading-tight">{{ $notif->title }}</h3>
                            
                            @if(!$notif->is_read)
                                <span class="flex-shrink-0 ml-4 w-2.5 h-2.5 rounded-full bg-red-500 ring-4 ring-red-50" title="Belum dibaca"></span>
                            @endif
                        </div>
                        <p class="text-slate-500 text-sm mb-3">{{ $notif->message }}</p>
                        <div class="flex items-center gap-4">
                            <span class="flex items-center gap-1 text-[11px] font-bold uppercase tracking-wider text-slate-400">
                                <span class="material-symbols-outlined text-xs">schedule</span>
                                {{ $notif->created_at->diffForHumans() }}
                            </span>
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-widest border {{ $badgeClass }}">
                                {{ $notif->type }}
                            </span>
                        </div>
                    </div>
                    
                    @if($notif->action_link && $notif->action_text)
                        <div class="absolute right-6 bottom-6 opacity-0 group-hover:opacity-100 transition-opacity">
                            <a href="{{ $notif->action_link }}" class="text-[#002045] hover:underline text-sm font-bold">{{ $notif->action_text }}</a>
                        </div>
                    @endif
                </div>
            @empty
                <div class="p-8 text-center bg-white rounded-xl border border-slate-200 text-slate-500">
                    <span class="material-symbols-outlined text-4xl mb-2 text-slate-300">notifications_off</span>
                    <p class="font-medium mt-2">Belum ada notifikasi sistem saat ini.</p>
                </div>
            @endforelse

        </div>

        {{-- Footer & Pagination Dinamis --}}
        <div class="mt-8 pt-6 border-t border-slate-200 flex flex-col sm:flex-row justify-between items-center gap-4">
            <p class="text-sm text-slate-500 font-medium">Menampilkan total <span class="font-bold text-slate-800">{{ $total ?? 0 }}</span> notifikasi.</p>
        </div>

    </div>
@endsection