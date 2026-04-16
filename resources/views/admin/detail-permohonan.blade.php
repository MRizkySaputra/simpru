<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Detail Permohonan - SiPinjam Ruang</title>

    @vite(['resources/css/app.css', 'resources/css/admin.css', 'resources/js/app.js'])
</head>
<body class="admin-body antialiased">

    <aside class="fixed left-0 top-0 h-full z-40 flex flex-col bg-slate-100 w-64 border-r-0 shadow-sm">
        <div class="px-6 py-8 flex flex-col h-full">
            
            <div class="mb-10 flex items-center gap-3">
                <div class="w-10 h-10 bg-primary-gradient rounded flex items-center justify-center text-white shadow-md">
                    <span class="material-symbols-outlined">account_balance</span>
                </div>
                <div>
                    <h1 class="text-xl font-black text-[#002045] font-headline leading-tight">SiPinjam Ruang</h1>
                    <p class="text-xs text-slate-500 font-medium">System Management</p>
                </div>
            </div>

            <nav class="flex-1 space-y-1">
                <a class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:text-[#002045] transition-transform hover:scale-105 group" href="/admin/dashboard">
                    <span class="material-symbols-outlined">analytics</span>
                    <span class="font-headline text-sm font-medium">Dashboard</span>
                </a>
                <a class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:text-[#002045] transition-transform hover:scale-105 group" href="/admin/ruangan">
                    <span class="material-symbols-outlined">meeting_room</span>
                    <span class="font-headline text-sm font-medium">Manajemen Ruangan</span>
                </a>
                <a class="flex items-center gap-3 px-4 py-3 font-bold rounded-lg mx-2 transition-transform scale-100 bg-white text-[#002045] shadow-sm" href="/admin/permohonan">
                    <span class="material-symbols-outlined">inbox</span>
                    <span class="font-headline text-sm font-medium">Permohonan Masuk</span>
                </a>
                <a class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:text-[#002045] transition-transform hover:scale-105 group" href="/admin/laporan">
                    <span class="material-symbols-outlined">assessment</span>
                    <span class="font-headline text-sm font-medium">Laporan</span>
                </a>
            </nav>

            <div class="mt-auto pt-6 border-t border-slate-200/50">
                <div class="flex items-center gap-3 px-2">
                    <img alt="Admin Avatar" class="w-10 h-10 rounded-full object-cover" src="https://ui-avatars.com/api/?name=Administrator&background=002045&color=fff"/>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-[#002045] truncate">Administrator</p>
                        <p class="text-xs text-slate-500 truncate">admin@masoem.ac.id</p>
                    </div>
                </div>
            </div>
        </div>
    </aside>

    <main class="ml-64 pb-24 min-h-screen bg-[#f7fafc]">
        
        <header class="flex justify-between items-center w-full px-8 py-4 sticky top-0 z-30 bg-white shadow-sm border-b border-slate-100">
            <div class="flex items-center gap-4 flex-1">
                <h2 class="text-xl font-extrabold text-[#002045] font-headline mr-4 hidden md:block">Detail Permohonan</h2>
            </div>
            
            <div class="flex items-center gap-6">
                <button class="relative text-slate-600 hover:text-[#002045] transition-colors">
                    <span class="material-symbols-outlined">notifications</span>
                    <span class="absolute top-0 right-0 w-2 h-2 bg-red-600 rounded-full ring-2 ring-white"></span>
                </button>
            </div>
        </header>

        <div class="max-w-[1600px] mx-auto px-8 py-8">
            
            <nav class="flex items-center gap-2 mb-8 text-sm font-medium text-slate-500">
                <a class="hover:text-[#002045] transition-colors" href="{{ url('/admin/permohonan') }}">Permohonan Masuk</a>
                <span class="material-symbols-outlined text-sm">chevron_right</span>
                <span class="text-[#002045] font-bold">Detail #REQ-20261012-042</span>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                
                <div class="lg:col-span-7 space-y-6">
                    <div class="bg-white rounded-xl p-8 shadow-sm border border-slate-200">
                        <div class="flex justify-between items-start mb-10">
                            <div>
                                <h2 class="text-2xl font-extrabold text-[#002045] font-headline tracking-tight mb-1">Informasi Peminjaman</h2>
                                <p class="text-sm text-slate-500">ID Permohonan: #REQ-20261012-042</p>
                            </div>
                            <div class="px-4 py-1.5 rounded-full bg-amber-100 text-amber-700 font-bold text-xs tracking-wider uppercase">
                                Menunggu
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-y-8 gap-x-12">
                            <div>
                                <p class="text-[10px] uppercase tracking-widest text-slate-500 font-bold mb-2">Nama Peminjam</p>
                                <div class="flex items-center gap-3">
                                    <span class="font-bold text-slate-900">Aditya Saputra</span>
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-blue-50 text-blue-800 border border-blue-100">Mahasiswa</span>
                                </div>
                            </div>
                            <div>
                                <p class="text-[10px] uppercase tracking-widest text-slate-500 font-bold mb-2">Ruangan</p>
                                <p class="font-bold text-slate-900">Lab Komputer 03</p>
                            </div>
                            <div>
                                <p class="text-[10px] uppercase tracking-widest text-slate-500 font-bold mb-2">Tanggal</p>
                                <p class="font-bold text-slate-900">24 Okt 2026</p>
                            </div>
                            <div>
                                <p class="text-[10px] uppercase tracking-widest text-slate-500 font-bold mb-2">Waktu</p>
                                <p class="font-bold text-slate-900">09:00 — 12:00 WIB</p>
                            </div>
                            <div class="md:col-span-2">
                                <p class="text-[10px] uppercase tracking-widest text-slate-500 font-bold mb-2">Nama Kegiatan</p>
                                <p class="font-bold text-[#002045] text-lg">Praktikum Algoritma Lanjut</p>
                            </div>
                            <div>
                                <p class="text-[10px] uppercase tracking-widest text-slate-500 font-bold mb-2">Jumlah Peserta</p>
                                <p class="font-bold text-slate-900">40 Orang</p>
                            </div>
                            <div>
                                <p class="text-[10px] uppercase tracking-widest text-slate-500 font-bold mb-2">Dikirim Pada</p>
                                <p class="font-bold text-slate-900">20 Okt 2026, 14:22</p>
                            </div>
                            <div class="md:col-span-2">
                                <p class="text-[10px] uppercase tracking-widest text-slate-500 font-bold mb-2">Keperluan / Keterangan</p>
                                <p class="text-slate-700 leading-relaxed bg-slate-50 p-4 rounded-lg border border-slate-100">
                                    Kegiatan praktikum mata kuliah rutin untuk program studi Informatika semester 3. Membutuhkan proyektor dan akses internet stabil.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-5">
                    <div class="bg-white border border-slate-200 rounded-xl p-8 sticky top-24 shadow-sm">
                        <div class="flex items-center gap-3 mb-6">
                            <span class="material-symbols-outlined text-[#002045] text-3xl">description</span>
                            <h3 class="text-lg font-bold text-[#002045] font-headline">Surat Permohonan</h3>
                        </div>
                        
                        <div class="group relative aspect-[3/4] bg-slate-50 rounded-lg overflow-hidden mb-6 border border-slate-200 flex flex-col items-center justify-center p-6 text-center transition-all hover:border-[#002045]/30">
                            <div class="w-16 h-16 bg-white shadow-sm rounded-full flex items-center justify-center mb-4 text-[#002045]">
                                <span class="material-symbols-outlined text-4xl">picture_as_pdf</span>
                            </div>
                            <p class="font-bold text-[#002045] mb-1">Surat Peminjaman Lab.pdf</p>
                            <p class="text-xs text-slate-500">354 KB</p>
                            
                            <div class="absolute inset-0 bg-[#002045]/5 opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer"></div>
                        </div>

                        <div class="space-y-3">
                            <button class="w-full py-3 px-4 rounded-lg border-2 border-[#002045] text-[#002045] font-bold flex items-center justify-center gap-2 hover:bg-[#002045]/5 transition-colors">
                                <span class="material-symbols-outlined text-xl">download</span> Unduh Surat
                            </button>
                            <button class="w-full py-3 px-4 rounded-lg text-slate-600 font-bold flex items-center justify-center gap-2 hover:bg-slate-100 border border-transparent transition-colors">
                                <span class="material-symbols-outlined text-xl">visibility</span> Pratinjau
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="fixed bottom-0 right-0 left-64 bg-white/95 backdrop-blur-md px-10 py-4 z-40 border-t border-slate-200 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.05)]">
            <div class="max-w-[1600px] mx-auto flex flex-col md:flex-row items-center justify-between gap-4">
                <div class="hidden md:block">
                    <p class="text-xs font-bold uppercase tracking-widest text-slate-500">Status Tindakan</p>
                    <p class="text-sm font-medium text-slate-900">Tinjauan admin diperlukan</p>
                </div>
                <div class="flex items-center gap-4 w-full md:w-auto">
                    <button class="flex-1 md:flex-none px-8 py-3 rounded-lg border border-red-500 text-red-600 font-extrabold hover:bg-red-50 hover:border-red-600 transition-colors">
                        Tolak
                    </button>
                    <button class="flex-1 md:flex-none px-10 py-3 rounded-lg bg-emerald-600 text-white font-extrabold shadow-md shadow-emerald-600/20 hover:bg-emerald-700 transition-all active:scale-[0.98]">
                        Setujui Permohonan
                    </button>
                </div>
            </div>
        </div>

    </main>
</body>
</html>