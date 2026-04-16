<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Manajemen Ruangan - SiPinjam Ruang</title>

    @vite(['resources/css/app.css', 'resources/css/admin.css', 'resources/js/app.js'])
</head>
<body class="admin-body antialiased bg-[#f7fafc]">

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
                <a class="flex items-center gap-3 px-4 py-3 font-bold rounded-lg mx-2 transition-transform scale-100 bg-white text-[#002045] shadow-sm" href="#">
                    <span class="material-symbols-outlined">meeting_room</span>
                    <span class="font-headline text-sm font-medium">Manajemen Ruangan</span>
                </a>
                <a class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:text-[#002045] transition-transform hover:scale-105 group" href="/admin/permohonan">
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

    <main class="ml-64 min-h-screen">
        
        <header class="flex justify-between items-center w-full px-8 py-4 sticky top-0 z-30 bg-white/80 backdrop-blur-md shadow-sm border-b border-slate-100">
            <div class="flex items-center gap-6">
                <h2 class="text-lg font-extrabold text-[#002045] font-headline hidden md:block">Manajemen Ruangan</h2>
                <div class="relative w-80">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm">search</span>
                    <input class="w-full bg-slate-100 border-none rounded-lg pl-10 py-2 text-sm focus:bg-white focus:ring-2 focus:ring-[#002045] transition-all outline-none" placeholder="Cari nama atau kode ruangan..." type="text">
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <button class="flex items-center justify-center p-2 text-slate-600 hover:text-[#002045] transition-colors relative">
                    <span class="material-symbols-outlined">notifications</span>
                    <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                </button>
                <button onclick="openModal('addRoomModal')" class="bg-primary-gradient text-white px-5 py-2 rounded-lg font-semibold text-sm flex items-center gap-2 hover:opacity-95 transition-all shadow-md">
                    <span class="material-symbols-outlined text-sm">add</span> Tambah Ruangan
                </button>
            </div>
        </header>

        <div class="p-8 max-w-[1600px] mx-auto">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-2 bg-blue-50 text-blue-900 rounded-lg">
                            <span class="material-symbols-outlined">meeting_room</span>
                        </div>
                        <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Kapasitas Total</span>
                    </div>
                    <div class="flex items-baseline gap-2">
                        <h3 class="text-3xl font-extrabold text-slate-900 font-headline">48</h3>
                        <p class="text-sm font-medium text-slate-500">Total Ruangan</p>
                    </div>
                    <div class="mt-4 pt-4 border-t border-slate-200">
                        <p class="text-[11px] text-slate-500 font-medium">Terdaftar di 5 Gedung Utama</p>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-2 bg-green-50 text-green-600 rounded-lg">
                            <span class="material-symbols-outlined">check_circle</span>
                        </div>
                        <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Ketersediaan</span>
                    </div>
                    <div class="flex items-baseline gap-2">
                        <h3 class="text-3xl font-extrabold text-green-600 font-headline">32</h3>
                        <p class="text-sm font-medium text-slate-500">Ruangan Tersedia</p>
                    </div>
                    <div class="mt-4 pt-4 border-t border-slate-200 flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-green-500"></span>
                        <p class="text-[11px] text-green-600 font-bold uppercase tracking-tight">Sistem Siap Digunakan</p>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-2 bg-amber-50 text-amber-600 rounded-lg">
                            <span class="material-symbols-outlined">event_busy</span>
                        </div>
                        <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Reservasi Aktif</span>
                    </div>
                    <div class="flex items-baseline gap-2">
                        <h3 class="text-3xl font-extrabold text-amber-600 font-headline">16</h3>
                        <p class="text-sm font-medium text-slate-500">Ruangan Dipakai</p>
                    </div>
                    <div class="mt-4 pt-4 border-t border-slate-200 flex justify-between items-center">
                        <p class="text-[11px] text-slate-500 font-medium">Booked hari ini</p>
                        <a class="text-[11px] font-bold text-blue-900 hover:underline" href="/admin/dashboard">Lihat Jadwal</a>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-slate-200">
                <div class="p-6 bg-white flex justify-between items-center border-b border-slate-200">
                    <h4 class="font-headline font-bold text-[#002045] text-lg">Daftar Ruangan Terdaftar</h4>
                    <div class="flex gap-2">
                        <button class="p-2 bg-slate-50 rounded-lg hover:bg-slate-100 transition-colors text-slate-600 border border-slate-200 flex items-center gap-2 text-sm font-semibold">
                            <span class="material-symbols-outlined text-base">filter_list</span> Filter
                        </button>
                    </div>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-slate-50">
                                <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-slate-500 border-b border-slate-200">ID</th>
                                <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-slate-500 border-b border-slate-200">Informasi Ruangan</th>
                                <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-slate-500 border-b border-slate-200">Kapasitas</th>
                                <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-slate-500 border-b border-slate-200">Fasilitas Utama</th>
                                <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-slate-500 border-b border-slate-200">Status Operasional</th>
                                <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-slate-500 border-b border-slate-200 text-right">Kelola</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200">
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-5 text-sm font-medium text-slate-600">R-001</td>
                                <td class="px-6 py-5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center">
                                            <span class="material-symbols-outlined text-blue-900 text-xl">meeting_room</span>
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="text-sm font-bold text-slate-900">Auditorium Utama A.1</span>
                                            <span class="text-[11px] text-slate-500">Gedung Rektorat &bull; Lantai 2</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex items-center gap-2">
                                        <span class="material-symbols-outlined text-lg text-slate-600">groups</span>
                                        <span class="text-sm font-semibold text-slate-900">250 Peserta</span>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex flex-wrap gap-1.5 max-w-[200px]">
                                        <span class="px-2 py-0.5 bg-slate-100 text-[10px] font-bold rounded-full text-slate-600">AC Central</span>
                                        <span class="px-2 py-0.5 bg-slate-100 text-[10px] font-bold rounded-full text-slate-600">Proyektor 4K</span>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex items-center">
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input checked type="checkbox" class="sr-only peer"/>
                                            <div class="w-11 h-6 bg-slate-200 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-600"></div>
                                        </label>
                                        <span class="ml-3 text-[11px] font-extrabold text-green-600 uppercase tracking-tight">Aktif</span>
                                    </div>
                                </td>
                                <td class="p-5 text-right">
                                    <div class="flex justify-end gap-2">
                                        <button onclick="openModal('editRoomModal')" class="p-2 hover:bg-blue-50 text-slate-400 hover:text-blue-700 rounded-lg transition-colors border border-slate-200" title="Edit"><span class="material-symbols-outlined text-sm">edit</span></button>
                                        <button onclick="openModal('deleteRoomModal')" class="p-2 hover:bg-red-50 text-slate-400 hover:text-red-600 rounded-lg transition-colors border border-slate-200" title="Hapus"><span class="material-symbols-outlined text-sm">delete</span></button>
                                    </div>
                                </td>
                            </tr>
                            
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-5 text-sm font-medium text-slate-600">R-002</td>
                                <td class="px-6 py-5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center">
                                            <span class="material-symbols-outlined text-blue-900 text-xl">computer</span>
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="text-sm font-bold text-slate-900">Lab Komputer Dasar</span>
                                            <span class="text-[11px] text-slate-500">Gedung FT &bull; Lantai 1</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex items-center gap-2">
                                        <span class="material-symbols-outlined text-lg text-slate-600">groups</span>
                                        <span class="text-sm font-semibold text-slate-900">40 Peserta</span>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex flex-wrap gap-1.5 max-w-[200px]">
                                        <span class="px-2 py-0.5 bg-slate-100 text-[10px] font-bold rounded-full text-slate-600">High-speed PC</span>
                                        <span class="px-2 py-0.5 bg-slate-100 text-[10px] font-bold rounded-full text-slate-600">LAN Gigabit</span>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex items-center">
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input checked type="checkbox" class="sr-only peer"/>
                                            <div class="w-11 h-6 bg-slate-200 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-600"></div>
                                        </label>
                                        <span class="ml-3 text-[11px] font-extrabold text-green-600 uppercase tracking-tight">Aktif</span>
                                    </div>
                                </td>
                                <td class="p-5 text-right">
                                    <div class="flex justify-end gap-2">
                                        <button onclick="openModal('editRoomModal')" class="p-2 hover:bg-blue-50 text-slate-400 hover:text-blue-700 rounded-lg transition-colors border border-slate-200" title="Edit"><span class="material-symbols-outlined text-sm">edit</span></button>
                                        <button onclick="openModal('deleteRoomModal')" class="p-2 hover:bg-red-50 text-slate-400 hover:text-red-600 rounded-lg transition-colors border border-slate-200" title="Hapus"><span class="material-symbols-outlined text-sm">delete</span></button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="p-6 bg-slate-50 border-t border-slate-200 flex justify-between items-center">
                    <span class="text-xs text-slate-500 font-medium">Menampilkan <span class="font-bold text-slate-900">1-2</span> dari <span class="font-bold text-slate-900">48</span> entri ruangan</span>
                    <div class="flex items-center gap-1">
                        <button class="p-2 rounded-lg text-slate-600 hover:bg-slate-200 transition-colors disabled:opacity-50" disabled>
                            <span class="material-symbols-outlined text-sm">chevron_left</span>
                        </button>
                        <button class="w-8 h-8 flex items-center justify-center rounded-lg bg-blue-900 text-white text-xs font-bold shadow-sm">1</button>
                        <button class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-slate-200 text-slate-600 text-xs font-bold transition-colors">2</button>
                        <span class="px-2 text-slate-600 font-bold">...</span>
                        <button class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-slate-200 text-slate-600 text-xs font-bold transition-colors">16</button>
                        <button class="p-2 rounded-lg text-slate-600 hover:bg-slate-200 transition-colors">
                            <span class="material-symbols-outlined text-sm">chevron_right</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <div id="addRoomModal" class="fixed inset-0 z-50 items-center justify-center hidden bg-[#002045]/40 backdrop-blur-sm transition-opacity">
        <div class="relative w-full max-w-2xl bg-white rounded-xl shadow-2xl overflow-hidden pointer-events-auto flex flex-col max-h-[90vh] m-4">
            
            <div class="p-6 border-b border-slate-200 flex justify-between items-center bg-white">
                <h3 class="text-xl font-extrabold text-[#002045] font-headline">Tambah Ruangan Baru</h3>
                <button type="button" onclick="document.getElementById('addRoomModal').classList.add('hidden'); document.getElementById('addRoomModal').classList.remove('flex');" class="p-2 hover:bg-slate-100 rounded-full transition-colors text-slate-500">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            
            <div class="p-8 overflow-y-auto bg-slate-50/50">
                <form action="#" method="POST" class="space-y-6">
                    @csrf
                    
                    <div class="grid grid-cols-2 gap-5">
                        <div class="col-span-2">
                            <label class="block text-[11px] font-bold uppercase tracking-widest text-slate-500 mb-2">Nama Ruangan</label>
                            <input name="nama_ruangan" class="w-full bg-white border border-slate-200 rounded-lg p-3.5 text-sm focus:ring-2 focus:ring-[#002045]/20 focus:border-[#002045] transition-all outline-none" placeholder="Contoh: A2 - Auditorium Serbaguna" type="text" required>
                            <p class="text-[10px] text-slate-400 mt-1.5 italic">*Kode ruangan (seperti A203) akan digenerate otomatis berdasarkan pilihan gedung & lantai.</p>
                        </div>
                        
                        <div class="col-span-1">
                            <label class="block text-[11px] font-bold uppercase tracking-widest text-slate-500 mb-2">Lantai</label>
                            <select name="lantai" class="w-full bg-white border border-slate-200 rounded-lg p-3.5 text-sm focus:ring-2 focus:ring-[#002045]/20 focus:border-[#002045] transition-all outline-none">
                                <option value="1">Lantai 1</option>
                                <option value="2">Lantai 2</option>
                                <option value="3">Lantai 3</option>
                            </select>
                        </div>
                        
                        <div class="col-span-1">
                            <label class="block text-[11px] font-bold uppercase tracking-widest text-slate-500 mb-2">Kapasitas (Orang)</label>
                            <input name="kapasitas" class="w-full bg-white border border-slate-200 rounded-lg p-3.5 text-sm focus:ring-2 focus:ring-[#002045]/20 focus:border-[#002045] transition-all outline-none" placeholder="1" type="number" min="1" required>
                        </div>
                        
                        <div class="col-span-2">
                            <label class="block text-[11px] font-bold uppercase tracking-widest text-slate-500 mb-2">Gedung</label>
                            <select name="gedung" class="w-full bg-white border border-slate-200 rounded-lg p-3.5 text-sm focus:ring-2 focus:ring-[#002045]/20 focus:border-[#002045] transition-all outline-none">
                                <option value="A">Gedung A (Rektorat)</option>
                                <option value="B">Gedung B (Fakultas Teknik)</option>
                                <option value="C">Gedung C (Perpustakaan)</option>
                            </select>
                        </div>
                    </div>

                    <div class="p-5 bg-white rounded-lg border border-slate-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-bold text-[#002045]">Status Ruangan</p>
                                <p class="text-xs text-slate-500 mt-0.5">Aktifkan untuk membuat ruangan dapat dipesan langsung.</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="status" class="sr-only peer" checked>
                                <div class="w-12 h-7 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[4px] after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-500"></div>
                            </label>
                        </div>
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold uppercase tracking-widest text-slate-500 mb-2">Foto Ruangan (Opsional)</label>
                        <div class="border-2 border-dashed border-slate-300 rounded-xl p-8 flex flex-col items-center justify-center text-center bg-white hover:bg-slate-50 hover:border-[#002045]/50 transition-all cursor-pointer">
                            <span class="material-symbols-outlined text-4xl text-slate-400 mb-3">cloud_upload</span>
                            <p class="text-sm font-semibold text-[#002045]">Klik atau seret gambar ke sini</p>
                            <p class="text-xs text-slate-400 mt-1">Mendukung file PNG, JPG (Maks. 5MB)</p>
                        </div>
                    </div>
                </form>
            </div>
            
            <div class="p-6 bg-white border-t border-slate-200 flex justify-end gap-3">
                <button type="button" onclick="document.getElementById('addRoomModal').classList.add('hidden'); document.getElementById('addRoomModal').classList.remove('flex');" class="px-6 py-2.5 rounded-lg text-sm font-bold text-slate-600 border border-slate-200 hover:bg-slate-50 transition-colors">
                    Batal
                </button>
                <button type="button" class="bg-primary-gradient text-white px-8 py-2.5 rounded-lg font-bold text-sm hover:opacity-95 shadow-md transition-all">
                    Simpan Ruangan
                </button>
            </div>
        </div>
    </div>

    <div id="editRoomModal" class="fixed inset-0 z-50 items-center justify-center hidden bg-[#002045]/40 backdrop-blur-sm transition-opacity">
        <div class="relative w-full max-w-lg bg-white rounded-xl shadow-2xl overflow-hidden flex flex-col m-4">
            <div class="px-8 py-6 border-b border-slate-200 flex items-center justify-between">
                <div>
                    <h3 class="text-xl font-bold text-[#002045] font-headline">Edit Ruangan</h3>
                    <p class="text-xs text-slate-500 mt-1 font-medium">Memperbarui informasi fasilitas akademik</p>
                </div>
                <button type="button" onclick="closeModal('editRoomModal')" class="p-2 rounded-full hover:bg-slate-100 text-slate-400 transition-colors">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            <div class="px-8 py-8 space-y-6 bg-slate-50/50">
                <form>
                    @csrf
                    @method('PUT') 
                    
                    <div class="space-y-2 mb-4">
                        <label class="text-[11px] uppercase tracking-wider font-bold text-slate-500 block">Nama Ruangan</label>
                        <input class="w-full bg-white border border-slate-200 rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-[#002045]/20 focus:border-[#002045] outline-none" type="text" value="Auditorium Utama A.1"/>
                    </div>
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div class="space-y-2">
                            <label class="text-[11px] uppercase tracking-wider font-bold text-slate-500 block">Gedung</label>
                            <select class="w-full bg-white border border-slate-200 rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-[#002045]/20 focus:border-[#002045] outline-none appearance-none">
                                <option selected>Gedung Rektorat</option>
                                <option>Gedung Teknik</option>
                            </select>
                        </div>
                        <div class="space-y-2">
                            <label class="text-[11px] uppercase tracking-wider font-bold text-slate-500 block">Lantai</label>
                            <select class="w-full bg-white border border-slate-200 rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-[#002045]/20 focus:border-[#002045] outline-none appearance-none">
                                <option>Lantai 1</option>
                                <option selected>Lantai 2</option>
                            </select>
                        </div>
                    </div>
                    <div class="space-y-2 mb-6">
                        <label class="text-[11px] uppercase tracking-wider font-bold text-slate-500 block">Kapasitas Maksimal</label>
                        <div class="relative">
                            <input class="w-full bg-white border border-slate-200 rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-[#002045]/20 focus:border-[#002045] outline-none" type="number" value="250"/>
                            <span class="absolute right-4 top-1/2 -translate-y-1/2 text-xs font-bold text-slate-400">Kursi</span>
                        </div>
                    </div>
                    <div class="flex items-center justify-between p-4 bg-white border border-slate-200 rounded-lg">
                        <div>
                            <p class="text-sm font-bold text-[#002045]">Status Operasional</p>
                            <p class="text-xs text-slate-500">Tentukan jika ruangan dapat dipesan</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input checked type="checkbox" class="sr-only peer"/>
                            <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-500"></div>
                        </label>
                    </div>
                </form>
            </div>
            <div class="px-8 py-6 bg-white border-t border-slate-200 flex justify-end gap-3">
                <button type="button" onclick="closeModal('editRoomModal')" class="px-6 py-2.5 rounded-lg border border-slate-200 text-slate-600 font-semibold text-sm hover:bg-slate-50 transition-all">Batal</button>
                <button type="button" class="px-8 py-2.5 rounded-lg bg-[#002045] text-white font-semibold text-sm shadow-md hover:bg-[#1a365d] transition-all">Simpan Perubahan</button>
            </div>
        </div>
    </div>

    <div id="deleteRoomModal" class="fixed inset-0 z-50 items-center justify-center hidden bg-[#002045]/40 backdrop-blur-sm transition-opacity">
        <div class="bg-white rounded-2xl p-8 w-full max-w-sm text-center shadow-2xl m-4 border border-slate-100">
            <div class="w-16 h-16 bg-red-50 text-red-600 rounded-full flex items-center justify-center mx-auto mb-5 border-4 border-red-100">
                <span class="material-symbols-outlined text-3xl">warning</span>
            </div>
            <h3 class="text-xl font-bold text-[#002045] font-headline mb-2">Hapus Ruangan?</h3>
            <p class="text-sm text-slate-500 mb-8 leading-relaxed">
                Apakah Anda yakin ingin menghapus <span class="font-bold text-slate-800">Auditorium Utama A.1</span>? Tindakan ini tidak dapat dibatalkan.
            </p>
            <div class="flex flex-col gap-3">
                <button type="button" class="w-full py-3 rounded-lg bg-red-600 text-white font-bold text-sm shadow-md hover:bg-red-700 transition-all">
                    Ya, Hapus Ruangan
                </button>
                <button type="button" onclick="closeModal('deleteRoomModal')" class="w-full py-3 rounded-lg text-sm font-bold text-slate-600 bg-white border border-slate-200 hover:bg-slate-50 transition-colors">
                    Batal
                </button>
            </div>
        </div>
    </div>

    <script>
        function openModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    </script>

</body>
</html>