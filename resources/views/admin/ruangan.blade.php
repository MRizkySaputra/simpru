@extends('layouts.admin')

@section('title', 'Manajemen Ruangan')

@section('content')

    {{-- Header Halaman --}}
    <div class="flex justify-between items-center mb-8">
        <div>
            <h2 class="text-3xl font-extrabold text-[#002045] font-headline tracking-tight">Manajemen Ruangan</h2>
            <p class="text-slate-500 text-sm mt-1">Kelola semua ruangan yang tersedia di lingkungan kampus.</p>
        </div>
        <button onclick="openModal('addRoomModal')"
                class="bg-primary-gradient text-white px-5 py-2.5 rounded-lg font-semibold text-sm flex items-center gap-2 hover:opacity-95 transition-all shadow-md">
            <span class="material-symbols-outlined text-sm">add</span> Tambah Ruangan
        </button>
    </div>

    {{-- Kartu Statistik --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="p-2 bg-blue-50 text-blue-900 rounded-lg"><span class="material-symbols-outlined">meeting_room</span></div>
                <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Kapasitas Total</span>
            </div>
            <div class="flex items-baseline gap-2">
                <h3 class="text-3xl font-extrabold text-slate-900 font-headline">{{ $totalRooms ?? 0 }}</h3>
                <p class="text-sm font-medium text-slate-500">Total Ruangan</p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="p-2 bg-green-50 text-green-600 rounded-lg"><span class="material-symbols-outlined">check_circle</span></div>
                <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Ketersediaan</span>
            </div>
            <div class="flex items-baseline gap-2">
                <h3 class="text-3xl font-extrabold text-green-600 font-headline">{{ $availableRooms ?? 0 }}</h3>
                <p class="text-sm font-medium text-slate-500">Ruangan Tersedia</p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="p-2 bg-amber-50 text-amber-600 rounded-lg"><span class="material-symbols-outlined">event_busy</span></div>
                <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Reservasi Aktif</span>
            </div>
            <div class="flex items-baseline gap-2">
                <h3 class="text-3xl font-extrabold text-amber-600 font-headline">{{ $activeBookingsToday ?? 0 }}</h3>
                <p class="text-sm font-medium text-slate-500">Ruangan Dipakai</p>
            </div>
        </div>
    </div>

    {{-- Tabel Ruangan --}}
    <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-slate-200">
        <div class="p-6 bg-white flex justify-between items-center border-b border-slate-200">
            <h4 class="font-headline font-bold text-[#002045] text-lg">Daftar Ruangan Terdaftar</h4>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50">
                        <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-slate-500 border-b">ID / Kode</th>
                        <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-slate-500 border-b">Informasi Ruangan</th>
                        <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-slate-500 border-b">Kapasitas</th>
                        <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-slate-500 border-b">Fasilitas</th>
                        <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-slate-500 border-b text-right">Kelola</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($rooms as $room)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-5 text-sm font-medium text-slate-600">{{ $room->code }}</td>
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center text-blue-900"><span class="material-symbols-outlined text-xl">meeting_room</span></div>
                                <div>
                                    <span class="text-sm font-bold text-slate-900">{{ $room->name }}</span>
                                    <p class="text-[11px] text-slate-500">Gedung {{ $room->building_id ?? 'A' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-5 text-sm font-semibold text-slate-900">{{ $room->capacity }} Peserta</td>
                        <td class="px-6 py-5">
                            <div class="flex flex-wrap gap-1.5">
                                @foreach(explode(',', $room->facilities ?? 'Standar') as $f)
                                    <span class="px-2 py-0.5 bg-slate-100 text-[10px] font-bold rounded-full text-slate-600">{{ trim($f) }}</span>
                                @endforeach
                            </div>
                        </td>
                        <td class="p-5 text-right">
                            <div class="flex justify-end gap-2">
                                {{-- Tombol Edit --}}
                                <button type="button" 
                                        onclick="openEditModal('{{ $room->id }}', '{{ $room->name }}', '{{ $room->building_id }}', '{{ $room->capacity }}', '{{ $room->facilities }}')" 
                                        class="p-2 hover:bg-blue-50 text-slate-400 hover:text-blue-600 rounded-lg transition-colors border border-slate-200" title="Edit">
                                    <span class="material-symbols-outlined text-sm">edit</span>
                                </button>
                                
                                {{-- Tombol Hapus --}}
                                <form action="/admin/ruangan/{{ $room->id }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus ruangan ini?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 hover:bg-red-50 text-slate-400 hover:text-red-600 rounded-lg transition-colors border border-slate-200" title="Hapus">
                                        <span class="material-symbols-outlined text-sm">delete</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="px-6 py-8 text-center text-slate-500 text-sm">Belum ada ruangan terdaftar.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Modal Tambah Ruangan --}}
    <div id="addRoomModal" class="fixed inset-0 z-50 items-center justify-center hidden bg-[#002045]/40 backdrop-blur-sm">
        <div class="relative w-full max-w-2xl bg-white rounded-xl shadow-2xl overflow-hidden flex flex-col max-h-[90vh] m-4">
            <div class="p-6 border-b border-slate-200 flex justify-between items-center">
                <h3 class="text-xl font-extrabold text-[#002045] font-headline">Tambah Ruangan Baru</h3>
                <button onclick="closeModal('addRoomModal')" class="p-2 hover:bg-slate-100 rounded-full text-slate-500">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            <div class="p-8 overflow-y-auto bg-slate-50/50">
                <form action="/admin/ruangan/store" method="POST" class="space-y-5">
                    @csrf
                    <div>
                        <label class="block text-[11px] font-bold uppercase tracking-widest text-slate-500 mb-2">Nama Ruangan</label>
                        <input name="name" class="w-full bg-white border border-slate-200 rounded-lg p-3.5 text-sm focus:ring-2 focus:ring-[#002045]/20 outline-none" placeholder="Contoh: Auditorium Serbaguna" type="text" required>
                    </div>
                    <div class="grid grid-cols-2 gap-5">
                        <div>
                            <label class="block text-[11px] font-bold uppercase tracking-widest text-slate-500 mb-2">Gedung</label>
                            <select name="building_id" class="w-full bg-white border border-slate-200 rounded-lg p-3.5 text-sm focus:ring-2 focus:ring-[#002045]/20 outline-none">
                                <option value="A">Gedung A</option>
                                <option value="B">Gedung B</option>
                                <option value="C">Gedung C</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold uppercase tracking-widest text-slate-500 mb-2">Kapasitas</label>
                            <input name="capacity" class="w-full bg-white border border-slate-200 rounded-lg p-3.5 text-sm focus:ring-2 focus:ring-[#002045]/20 outline-none" placeholder="Contoh: 40" type="number" required>
                        </div>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold uppercase tracking-widest text-slate-500 mb-2">Fasilitas Utama</label>
                        <input name="facilities" class="w-full bg-white border border-slate-200 rounded-lg p-3.5 text-sm focus:ring-2 focus:ring-[#002045]/20 outline-none" placeholder="AC, Proyektor, PC" type="text">
                    </div>
                    <div class="pt-4 flex justify-end">
                        <button type="submit" class="bg-primary-gradient text-white px-8 py-3 rounded-lg font-bold text-sm shadow-md hover:opacity-95">Simpan Ruangan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Edit Ruangan --}}
    <div id="editRoomModal" class="fixed inset-0 z-50 items-center justify-center hidden bg-[#002045]/40 backdrop-blur-sm">
        <div class="relative w-full max-w-2xl bg-white rounded-xl shadow-2xl overflow-hidden flex flex-col max-h-[90vh] m-4">
            <div class="p-6 border-b border-slate-200 flex justify-between items-center">
                <h3 class="text-xl font-extrabold text-[#002045] font-headline">Edit Ruangan</h3>
                <button onclick="closeModal('editRoomModal')" class="p-2 hover:bg-slate-100 rounded-full text-slate-500">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            <div class="p-8 overflow-y-auto bg-slate-50/50">
                <form id="editRoomForm" action="" method="POST" class="space-y-5">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="block text-[11px] font-bold uppercase tracking-widest text-slate-500 mb-2">Nama Ruangan</label>
                        <input id="edit_name" name="name" class="w-full bg-white border border-slate-200 rounded-lg p-3.5 text-sm focus:ring-2 focus:ring-[#002045]/20 outline-none" type="text" required>
                    </div>
                    <div class="grid grid-cols-2 gap-5">
                        <div>
                            <label class="block text-[11px] font-bold uppercase tracking-widest text-slate-500 mb-2">Gedung</label>
                            <select id="edit_building" name="building_id" class="w-full bg-white border border-slate-200 rounded-lg p-3.5 text-sm focus:ring-2 focus:ring-[#002045]/20 outline-none">
                                <option value="A">Gedung A</option>
                                <option value="B">Gedung B</option>
                                <option value="C">Gedung C</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold uppercase tracking-widest text-slate-500 mb-2">Kapasitas</label>
                            <input id="edit_capacity" name="capacity" class="w-full bg-white border border-slate-200 rounded-lg p-3.5 text-sm focus:ring-2 focus:ring-[#002045]/20 outline-none" type="number" required>
                        </div>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold uppercase tracking-widest text-slate-500 mb-2">Fasilitas Utama</label>
                        <input id="edit_facilities" name="facilities" class="w-full bg-white border border-slate-200 rounded-lg p-3.5 text-sm focus:ring-2 focus:ring-[#002045]/20 outline-none" type="text">
                    </div>
                    <div class="pt-4 flex justify-end gap-3">
                        <button type="button" onclick="closeModal('editRoomModal')" class="bg-white border border-slate-200 text-slate-600 px-8 py-3 rounded-lg font-bold text-sm hover:bg-slate-50">Batal</button>
                        <button type="submit" class="bg-[#002045] text-white px-8 py-3 rounded-lg font-bold text-sm shadow-md hover:opacity-95">Update Ruangan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    function openModal(id) { document.getElementById(id).classList.replace('hidden', 'flex'); }
    function closeModal(id) { document.getElementById(id).classList.replace('flex', 'hidden'); }

    // Fungsi untuk memanggil modal edit dan mengisi form
    function openEditModal(id, name, building, capacity, facilities) {
        // Ubah action form ke rute update yang sesuai
        document.getElementById('editRoomForm').action = `/admin/ruangan/${id}`;
        
        // Isi data ke dalam input
        document.getElementById('edit_name').value = name;
        document.getElementById('edit_building').value = building;
        document.getElementById('edit_capacity').value = capacity;
        document.getElementById('edit_facilities').value = facilities;
        
        // Buka modal
        openModal('editRoomModal');
    }
</script>
@endpush