@extends('layouts.admin')

@section('title', 'Detail Permohonan')

@section('content')

    <nav class="mb-8 flex items-center gap-2 text-sm text-slate-500">
        <a class="hover:text-[#002045] font-medium transition-colors flex items-center gap-1" href="/admin/permohonan">
            <span class="material-symbols-outlined text-base">arrow_back</span> Kembali ke Daftar Permohonan
        </a>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

        {{-- Kiri: Info Peminjaman --}}
        <div class="lg:col-span-7">
            <div class="bg-white rounded-xl p-8 shadow-sm border border-slate-200">
                <div class="flex justify-between items-start mb-10">
                    <div>
                        <h2 class="text-2xl font-extrabold text-[#002045] font-headline tracking-tight mb-1">Informasi Peminjaman</h2>
                        <p class="text-sm text-slate-500">Dikirim pada {{ \Carbon\Carbon::parse($booking->created_at)->translatedFormat('d M Y') }} • ID #{{ $booking->req_id }}</p>
                    </div>
                    @if($booking->status === 'menunggu')
                        <span class="px-4 py-1.5 rounded-full bg-amber-100 text-amber-700 font-bold text-xs tracking-wider uppercase">Menunggu</span>
                    @elseif($booking->status === 'disetujui')
                        <span class="px-4 py-1.5 rounded-full bg-emerald-100 text-emerald-700 font-bold text-xs tracking-wider uppercase">Disetujui</span>
                    @else
                        <span class="px-4 py-1.5 rounded-full bg-red-100 text-red-700 font-bold text-xs tracking-wider uppercase">Ditolak</span>
                    @endif
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-y-8 gap-x-12">
                    
                    @if($booking->status === 'ditolak')
                    <div class="md:col-span-2 bg-red-50 p-4 rounded-lg border border-red-100">
                        <p class="text-[10px] uppercase tracking-widest text-red-600 font-bold mb-1">Alasan Penolakan</p>
                        <p class="text-sm text-red-800 font-medium">{{ $booking->rejection_reason }}</p>
                    </div>
                    @endif

                    <div>
                        <p class="text-[10px] uppercase tracking-widest text-slate-500 font-bold mb-2">Nama Peminjam</p>
                        <div class="flex items-center gap-3">
                            <span class="font-bold text-slate-900">{{ $booking->user->name ?? 'User' }}</span>
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-blue-50 text-blue-800 border border-blue-100">{{ ucfirst($booking->user->role ?? 'Mahasiswa') }}</span>
                        </div>
                    </div>
                    
                    <div>
                        <p class="text-[10px] uppercase tracking-widest text-slate-500 font-bold mb-2">Ruangan</p>
                        <p class="font-bold text-slate-900">{{ $booking->room->name ?? 'Ruangan' }}</p>
                    </div>
                    
                    <div>
                        <p class="text-[10px] uppercase tracking-widest text-slate-500 font-bold mb-2">Tanggal</p>
                        <p class="font-bold text-slate-900">{{ \Carbon\Carbon::parse($booking->date)->translatedFormat('d M Y') }}</p>
                    </div>
                    
                    <div>
                        <p class="text-[10px] uppercase tracking-widest text-slate-500 font-bold mb-2">Waktu</p>
                        <p class="font-bold text-slate-900">{{ substr($booking->start_time, 0, 5) }} — {{ substr($booking->end_time, 0, 5) }} WIB</p>
                    </div>

                    <div>
                        <p class="text-[10px] uppercase tracking-widest text-slate-500 font-bold mb-2">Jenis Kegiatan</p>
                        <span class="px-3 py-1 bg-indigo-50 text-indigo-600 text-xs font-bold rounded-lg border border-indigo-100">{{ $booking->activity_type }}</span>
                    </div>

                    <div>
                        <p class="text-[10px] uppercase tracking-widest text-slate-500 font-bold mb-2">Jumlah Peserta</p>
                        <p class="font-bold text-slate-900">{{ $booking->participants }} Orang</p>
                    </div>

                    <div class="md:col-span-2">
                        <p class="text-[10px] uppercase tracking-widest text-slate-500 font-bold mb-2">Nama Kegiatan & Keperluan</p>
                        <p class="text-slate-700 leading-relaxed bg-slate-50 p-4 rounded-lg border border-slate-100">
                            <strong>{{ $booking->activity_name }}</strong><br><br>
                            Keterangan bawaan sistem: Pengajuan ruangan untuk kegiatan akademik atau organisasi.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Kanan: Surat Permohonan --}}
        <div class="lg:col-span-5">
            <div class="bg-white border border-slate-200 rounded-xl p-8 sticky top-24 shadow-sm">
                <div class="flex items-center gap-3 mb-6">
                    <span class="material-symbols-outlined text-[#002045] text-3xl">description</span>
                    <h3 class="text-lg font-bold text-[#002045] font-headline">Surat Permohonan</h3>
                </div>

                @if($booking->document_path)
                    <div class="aspect-[3/4] bg-slate-50 rounded-lg overflow-hidden mb-6 border border-slate-200 flex flex-col items-center justify-center p-6 text-center">
                        <div class="w-16 h-16 bg-white shadow-sm rounded-full flex items-center justify-center mb-4 text-red-600">
                            <span class="material-symbols-outlined text-4xl">picture_as_pdf</span>
                        </div>
                        <p class="font-bold text-[#002045] mb-1 w-full truncate">{{ basename($booking->document_path) }}</p>
                    </div>

                    <div class="space-y-3">
                        <a href="{{ asset('storage/' . $booking->document_path) }}" target="_blank" class="w-full py-3 px-4 rounded-lg border-2 border-[#002045] text-[#002045] font-bold flex items-center justify-center gap-2 hover:bg-[#002045]/5 transition-colors">
                            <span class="material-symbols-outlined text-xl">download</span> Unduh Surat
                        </a>
                    </div>
                @else
                    <div class="aspect-[3/4] bg-slate-50 rounded-lg overflow-hidden mb-6 border border-slate-200 flex flex-col items-center justify-center p-6 text-center">
                        <div class="w-16 h-16 bg-white shadow-sm rounded-full flex items-center justify-center mb-4 text-slate-400">
                            <span class="material-symbols-outlined text-4xl">description</span>
                        </div>
                        <p class="font-bold text-slate-400 mb-1">Tidak ada file yang dilampirkan</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Action Bar (Hanya Muncul Jika Status Menunggu) --}}
    @if($booking->status === 'menunggu')
    <div class="fixed bottom-0 right-0 left-64 bg-white/95 backdrop-blur-md px-10 py-4 z-40 border-t border-slate-200 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.05)]">
        <div class="max-w-[1600px] mx-auto flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="hidden md:block">
                <p class="text-xs font-bold uppercase tracking-widest text-slate-500">Status Tindakan</p>
                <p class="text-sm font-medium text-slate-900">Tinjauan admin diperlukan</p>
            </div>
            <div class="flex items-center gap-4 w-full md:w-auto">
                {{-- Tombol Tolak memicu Modal --}}
                <button type="button" onclick="openRejectModal()" class="flex-1 md:flex-none px-8 py-3 rounded-lg border border-red-500 text-red-600 font-extrabold hover:bg-red-50 transition-colors">
                  Tolak
                 </button>
                
                {{-- Tombol Setuju langsung mengeksekusi Form --}}
                <form action="/admin/proses-permohonan/{{ $booking->id }}" method="POST" class="m-0 p-0 flex-1 md:flex-none">
                    @csrf
                    <input type="hidden" name="action" value="setujui">
                    <button type="submit" class="w-full px-10 py-3 rounded-lg bg-emerald-600 text-white font-extrabold shadow-md hover:bg-emerald-700 transition-all">
                        Setujui Permohonan
                    </button>
                </form>
            </div>
        </div>
    </div>
    @endif

    {{-- Modal Alasan Penolakan --}}
    <div id="rejectModal" class="fixed inset-0 z-50 items-center justify-center hidden bg-[#002045]/40 backdrop-blur-sm">
        <div class="bg-white rounded-2xl p-6 md:p-8 w-full max-w-lg shadow-2xl m-4 transform transition-all">
            <div class="flex items-center justify-between mb-6 border-b border-slate-100 pb-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-red-50 text-red-600 rounded-full flex items-center justify-center">
                        <span class="material-symbols-outlined">cancel</span>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-[#002045] font-headline">Tolak Permohonan</h3>
                        <p class="text-[11px] text-slate-500">ID: #{{ $booking->req_id }}</p>
                    </div>
                </div>
                <button onclick="closeRejectModal()" class="p-2 rounded-full hover:bg-slate-100 text-slate-400 transition-colors">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>

            <form action="/admin/proses-permohonan/{{ $booking->id }}" method="POST" class="space-y-6">
                @csrf
                <input type="hidden" name="action" value="tolak">
                <div>
                    <label class="block text-[11px] font-bold uppercase tracking-widest text-slate-500 mb-2">
                        Alasan Penolakan <span class="text-red-500">*</span>
                    </label>
                    <textarea rows="4" 
                              name="alasan_penolakan"
                              required
                              class="w-full bg-slate-50 border border-slate-200 rounded-xl p-4 text-sm focus:ring-2 focus:ring-red-500/20 focus:border-red-500 outline-none resize-none transition-all placeholder:text-slate-400" 
                              placeholder="Contoh: Jadwal bentrok dengan kegiatan universitas, atau dokumen kurang lengkap..."></textarea>
                </div>

                <div class="flex gap-3 justify-end pt-2">
                    <button type="button" onclick="closeRejectModal()" class="px-6 py-2.5 rounded-lg border border-slate-200 text-slate-600 font-bold text-sm hover:bg-slate-50 transition-colors">
                        Kembali
                    </button>
                    <button type="submit" class="px-8 py-2.5 rounded-lg bg-red-600 text-white font-bold text-sm shadow-md hover:bg-red-700 transition-colors">
                        Kirim Penolakan
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    function openRejectModal() {
        const modal = document.getElementById('rejectModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeRejectModal() {
        const modal = document.getElementById('rejectModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    document.getElementById('rejectModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeRejectModal();
        }
    });
</script>
@endpush