@extends('layouts.admin')

@section('title', 'Manajemen Pengguna')

@section('content')

    {{-- Header --}}
    <div class="flex justify-between items-center mb-8">
        <div>
            <h2 class="text-3xl font-extrabold text-[#002045] font-headline tracking-tight">Manajemen Pengguna</h2>
            <p class="text-slate-500 text-sm mt-1">Kelola semua akun pengguna sistem SIMPRU.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="/admin/roles"
               class="flex items-center gap-2 px-5 py-2.5 bg-white border border-slate-200 text-[#002045] rounded-lg font-bold text-sm hover:bg-slate-50 shadow-sm transition-colors">
                <span class="material-symbols-outlined text-sm">shield</span>
                Kelola Role
            </a>
            <button onclick="openModal('addUserModal')"
                    class="bg-primary-gradient text-white px-5 py-2.5 rounded-lg font-bold text-sm flex items-center gap-2 hover:opacity-95 shadow-md">
                <span class="material-symbols-outlined text-sm">person_add</span>
                Tambah Pengguna
            </button>
        </div>
    </div>

    {{-- Kartu Statistik --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5 mb-8">
        <div class="bg-white rounded-xl p-6 border border-slate-200 shadow-sm hover:shadow-md transition-shadow group">
            <div class="flex items-start justify-between mb-5">
                <div class="p-2.5 bg-blue-50 text-[#002045] rounded-lg group-hover:bg-[#002045] group-hover:text-white transition-colors">
                    <span class="material-symbols-outlined">group</span>
                </div>
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Total</span>
            </div>
            <p class="text-4xl font-black text-[#002045] font-headline">{{ $totalUsersCount }}</p>
            <p class="text-xs text-slate-500 font-medium mt-2">Total Pengguna Terdaftar</p>
        </div>
        <div class="bg-white rounded-xl p-6 border border-slate-200 shadow-sm hover:shadow-md transition-shadow group">
            <div class="flex items-start justify-between mb-5">
                <div class="p-2.5 bg-emerald-50 text-emerald-600 rounded-lg group-hover:bg-emerald-500 group-hover:text-white transition-colors">
                    <span class="material-symbols-outlined">school</span>
                </div>
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Mahasiswa</span>
            </div>
            <p class="text-4xl font-black text-emerald-600 font-headline">{{ $mahasiswaCount }}</p>
            <p class="text-xs text-slate-500 font-medium mt-2">Akun Mahasiswa Aktif</p>
        </div>
        <div class="bg-white rounded-xl p-6 border border-slate-200 shadow-sm hover:shadow-md transition-shadow group">
            <div class="flex items-start justify-between mb-5">
                <div class="p-2.5 bg-purple-50 text-purple-600 rounded-lg group-hover:bg-purple-500 group-hover:text-white transition-colors">
                    <span class="material-symbols-outlined">person_pin</span>
                </div>
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Dosen</span>
            </div>
            <p class="text-4xl font-black text-purple-600 font-headline">{{ $dosenCount }}</p>
            <p class="text-xs text-slate-500 font-medium mt-2">Akun Dosen & Staf</p>
        </div>
        <div class="bg-white rounded-xl p-6 border border-slate-200 shadow-sm hover:shadow-md transition-shadow group">
            <div class="flex items-start justify-between mb-5">
                <div class="p-2.5 bg-red-50 text-red-500 rounded-lg group-hover:bg-red-500 group-hover:text-white transition-colors">
                    <span class="material-symbols-outlined">block</span>
                </div>
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Nonaktif</span>
            </div>
            <p class="text-4xl font-black text-red-500 font-headline">{{ $inactiveCount }}</p>
            <p class="text-xs text-slate-500 font-medium mt-2">Akun Dinonaktifkan</p>
        </div>
    </div>

    {{-- Filter & Pencarian --}}
    <form action="/admin/users" method="GET" class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 mb-6 flex flex-wrap items-center gap-4">
        <div class="relative flex-1 min-w-[200px]">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm">search</span>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, email, atau NIM..."
                   class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-[#002045]/20 outline-none">
        </div>
        <select name="role" onchange="this.form.submit()" class="bg-slate-50 border border-slate-200 rounded-lg py-2.5 px-4 text-sm font-medium focus:ring-2 focus:ring-[#002045]/20 outline-none min-w-[140px]">
            <option value="">Semua Role</option>
            <option value="mahasiswa" {{ request('role') === 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
            <option value="dosen" {{ request('role') === 'dosen' ? 'selected' : '' }}>Dosen</option>
            <option value="staf" {{ request('role') === 'staf' ? 'selected' : '' }}>Staf Akademik</option>
            <option value="organisasi" {{ request('role') === 'organisasi' ? 'selected' : '' }}>Organisasi</option>
            <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
        </select>
        <select name="status" onchange="this.form.submit()" class="bg-slate-50 border border-slate-200 rounded-lg py-2.5 px-4 text-sm font-medium focus:ring-2 focus:ring-[#002045]/20 outline-none min-w-[130px]">
            <option value="">Semua Status</option>
            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
        </select>
    </form>

    {{-- Tabel Pengguna --}}
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200">
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest">Pengguna</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-widests">NIM / NIDN</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-widests">Role</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-widests">Bergabung</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-widests text-center">Status</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-widests text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">

                    @php
                        $colorMap = ['blue'=>'bg-blue-100 text-blue-800','purple'=>'bg-purple-100 text-purple-800','orange'=>'bg-orange-100 text-orange-800','teal'=>'bg-teal-100 text-teal-800','red'=>'bg-red-100 text-red-800','indigo'=>'bg-indigo-100 text-indigo-800'];
                        $roleColorMap = ['mahasiswa'=>'bg-emerald-50 text-emerald-700 border-emerald-200','dosen'=>'bg-purple-50 text-purple-700 border-purple-200','staf'=>'bg-blue-50 text-blue-700 border-blue-200','organisasi'=>'bg-orange-50 text-orange-700 border-orange-200','admin'=>'bg-red-50 text-red-700 border-red-200'];
                        $colors = ['blue', 'purple', 'orange', 'teal', 'indigo'];
                    @endphp

                    @forelse ($users as $user)
                    @php
                        $words = explode(' ', $user->name);
                        $init = strtoupper(substr($words[0], 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''));
                        $chosenColor = $colors[$user->id % count($colors)];
                        $role_slug = strtolower($user->role);
                    @endphp
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full {{ $colorMap[$chosenColor] }} flex items-center justify-center text-xs font-bold shrink-0">
                                    {{ $init }}
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-slate-800">{{ $user->name }}</p>
                                    <p class="text-xs text-slate-400">{{ $user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm font-medium text-slate-600">{{ $user->identity_number }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2.5 py-1 text-[10px] font-bold rounded-full border {{ $roleColorMap[$role_slug] ?? 'bg-slate-50 text-slate-700' }} uppercase tracking-wider">
                                {{ $user->role }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-500">{{ $user->created_at->format('M Y') }}</td>
                        <td class="px-6 py-4 text-center">
                            @if ($user->is_active)
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-emerald-50 text-emerald-700 border border-emerald-200 text-[10px] font-bold rounded-full uppercase tracking-wider">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Aktif
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-red-50 text-red-600 border border-red-200 text-[10px] font-bold rounded-full uppercase tracking-wider">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Nonaktif
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-1.5">
                                {{-- Edit --}}
                                <button onclick="openEditUserModal('{{ $user->id }}', '{{ $user->name }}', '{{ $user->email }}', '{{ $user->identity_number }}')"
                                        class="p-1.5 bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white rounded-lg transition-all" title="Edit">
                                    <span class="material-symbols-outlined text-sm">edit</span>
                                </button>
                                {{-- Change Role --}}
                                <button onclick="openChangeRoleModal('{{ $user->id }}', '{{ $user->name }}', '{{ $init }}', '{{ $role_slug }}')"
                                        class="p-1.5 bg-purple-50 text-purple-600 hover:bg-purple-600 hover:text-white rounded-lg transition-all" title="Ubah Role">
                                    <span class="material-symbols-outlined text-sm">manage_accounts</span>
                                </button>
                                {{-- Toggle Status --}}
                                <button onclick="openToggleStatusModal('{{ $user->id }}', {{ $user->is_active ? 'true' : 'false' }})"
                                        class="p-1.5 {{ $user->is_active ? 'bg-amber-50 text-amber-600 hover:bg-amber-600' : 'bg-emerald-50 text-emerald-600 hover:bg-emerald-600' }} hover:text-white rounded-lg transition-all" title="{{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                    <span class="material-symbols-outlined text-sm">{{ $user->is_active ? 'block' : 'check_circle' }}</span>
                                </button>
                                {{-- Delete --}}
                                <button onclick="openDeleteUserModal('{{ $user->id }}')"
                                        class="p-1.5 bg-red-50 text-red-500 hover:bg-red-500 hover:text-white rounded-lg transition-all" title="Hapus">
                                    <span class="material-symbols-outlined text-sm">delete</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="px-6 py-8 text-center text-slate-500 text-sm">Tidak ditemukan pengguna yang sesuai.</td></tr>
                    @endforelse

                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="px-6 py-4 bg-slate-50 border-t border-slate-200">
            {{ $users->links() }}
        </div>
    </div>

@endsection

@push('scripts')

{{-- Modal Tambah Pengguna --}}
<div id="addUserModal" class="fixed inset-0 z-50 items-center justify-center hidden bg-[#002045]/40 backdrop-blur-sm">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg mx-4 overflow-hidden flex flex-col max-h-[90vh]">
        <div class="px-6 py-5 border-b border-slate-200 flex items-center justify-between">
            <h3 class="text-lg font-bold text-[#002045] font-headline">Tambah Pengguna Baru</h3>
            <button onclick="closeModal('addUserModal')" class="p-2 rounded-full hover:bg-slate-100 text-slate-400">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <form action="/admin/users/store" method="POST" class="p-6 overflow-y-auto space-y-4 bg-slate-50/50">
            @csrf
            <div>
                <label class="block text-[11px] font-bold uppercase tracking-widests text-slate-500 mb-2">Nama Lengkap</label>
                <input type="text" name="name" placeholder="Masukkan nama lengkap" class="w-full bg-white border border-slate-200 rounded-lg p-3.5 text-sm focus:ring-2 focus:ring-[#002045]/20 outline-none" required>
            </div>
            <div>
                <label class="block text-[11px] font-bold uppercase tracking-widests text-slate-500 mb-2">Alamat Email</label>
                <input type="email" name="email" placeholder="nama@masoem.ac.id" class="w-full bg-white border border-slate-200 rounded-lg p-3.5 text-sm focus:ring-2 focus:ring-[#002045]/20 outline-none" required>
            </div>
            <div>
                <label class="block text-[11px] font-bold uppercase tracking-widests text-slate-500 mb-2">NIM / NIDN</label>
                <input type="text" name="identity_number" placeholder="Masukkan NIM atau NIDN" class="w-full bg-white border border-slate-200 rounded-lg p-3.5 text-sm focus:ring-2 focus:ring-[#002045]/20 outline-none" required>
            </div>
           <div>
                <label class="block text-[11px] font-bold uppercase tracking-widests text-slate-500 mb-2">Role</label>
                <select name="role" class="w-full bg-white border border-slate-200 rounded-lg p-3.5 text-sm focus:ring-2 focus:ring-[#002045]/20 outline-none" required>
                    <option value="">Pilih role pengguna</option>
                    {{-- PASTIKAN VALUE-NYA HURUF KECIL SEMUA SEPERTI INI --}}
                    <option value="mahasiswa">Mahasiswa</option>
                    <option value="dosen">Dosen</option>
                    <option value="staf">Staf Akademik</option>
                    <option value="organisasi">Organisasi</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <div>
                <label class="block text-[11px] font-bold uppercase tracking-widests text-slate-500 mb-2">Kata Sandi Awal</label>
                <input type="password" name="password" placeholder="Minimal 8 karakter" class="w-full bg-white border border-slate-200 rounded-lg p-3.5 text-sm focus:ring-2 focus:ring-[#002045]/20 outline-none" required>
            </div>
            <div class="pt-4 flex justify-end gap-3">
                <button type="button" onclick="closeModal('addUserModal')" class="px-5 py-2.5 rounded-lg border border-slate-200 text-slate-600 font-bold text-sm hover:bg-slate-50">Batal</button>
                <button type="submit" class="px-8 py-2.5 rounded-lg bg-primary-gradient text-white font-bold text-sm shadow-md hover:opacity-95">Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Edit Pengguna --}}
<div id="editUserModal" class="fixed inset-0 z-50 items-center justify-center hidden bg-[#002045]/40 backdrop-blur-sm">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg mx-4 overflow-hidden flex flex-col max-h-[90vh]">
        <div class="px-6 py-5 border-b border-slate-200 flex items-center justify-between">
            <h3 class="text-lg font-bold text-[#002045] font-headline">Edit Pengguna</h3>
            <button onclick="closeModal('editUserModal')" class="p-2 rounded-full hover:bg-slate-100 text-slate-400">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <form id="editUserForm" action="" method="POST" class="p-6 overflow-y-auto space-y-4 bg-slate-50/50">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-[11px] font-bold uppercase tracking-widests text-slate-500 mb-2">Nama Lengkap</label>
                <input type="text" id="edit_name" name="name" class="w-full bg-white border border-slate-200 rounded-lg p-3.5 text-sm focus:ring-2 focus:ring-[#002045]/20 outline-none" required>
            </div>
            <div>
                <label class="block text-[11px] font-bold uppercase tracking-widests text-slate-500 mb-2">Alamat Email</label>
                <input type="email" id="edit_email" name="email" class="w-full bg-white border border-slate-200 rounded-lg p-3.5 text-sm focus:ring-2 focus:ring-[#002045]/20 outline-none" required>
            </div>
            <div>
                <label class="block text-[11px] font-bold uppercase tracking-widests text-slate-500 mb-2">NIM / NIDN</label>
                <input type="text" id="edit_identity" class="w-full bg-slate-100 border border-slate-200 rounded-lg p-3.5 text-sm outline-none cursor-not-allowed" readonly>
            </div>
            <div>
                <label class="block text-[11px] font-bold uppercase tracking-widests text-slate-500 mb-2">Reset Kata Sandi (opsional)</label>
                <input type="password" name="password" placeholder="Kosongkan jika tidak diubah" class="w-full bg-white border border-slate-200 rounded-lg p-3.5 text-sm focus:ring-2 focus:ring-[#002045]/20 outline-none">
            </div>
            <div class="pt-4 flex justify-end gap-3">
                <button type="button" onclick="closeModal('editUserModal')" class="px-5 py-2.5 rounded-lg border border-slate-200 text-slate-600 font-bold text-sm hover:bg-slate-50">Batal</button>
                <button type="submit" class="px-8 py-2.5 rounded-lg bg-[#002045] text-white font-bold text-sm shadow-md hover:opacity-95">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Ubah Role --}}
<div id="changeRoleModal" class="fixed inset-0 z-50 items-center justify-center hidden bg-[#002045]/40 backdrop-blur-sm">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-sm mx-4 overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-200 flex items-center justify-between">
            <h3 class="text-lg font-bold text-[#002045] font-headline">Ubah Role Pengguna</h3>
            <button onclick="closeModal('changeRoleModal')" class="p-2 rounded-full hover:bg-slate-100 text-slate-400">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <form id="changeRoleForm" action="" method="POST" class="p-6 space-y-3 bg-slate-50/50">
            @csrf
            @method('PUT')
            <div class="flex items-center gap-3 mb-4 p-3 bg-white border border-slate-200 rounded-lg">
                <div id="role_avatar" class="w-9 h-9 rounded-full bg-blue-100 text-blue-800 flex items-center justify-center text-xs font-bold"></div>
                <div>
                    <p id="role_user_name" class="text-sm font-bold text-slate-800"></p>
                    <p class="text-xs text-slate-400">Pilih salah satu tingkatan berikut:</p>
                </div>
            </div>
            <label class="block text-[11px] font-bold uppercase tracking-widests text-slate-500 mb-2">Pilih Role Baru</label>
            
            @php
            $rolesList = [
                ['value'=>'mahasiswa','label'=>'Mahasiswa','desc'=>'Dapat mengajukan peminjaman ruangan','icon'=>'school','color'=>'emerald'],
                ['value'=>'dosen','label'=>'Dosen','desc'=>'Akses prioritas peminjaman ruangan','icon'=>'person_pin','color'=>'purple'],
                ['value'=>'staf','label'=>'Staf Akademik','desc'=>'Akses peminjaman untuk kegiatan kampus','icon'=>'badge','color'=>'blue'],
                ['value'=>'organisasi','label'=>'Organisasi','desc'=>'Akses untuk kegiatan kemahasiswaan','icon'=>'groups','color'=>'orange'],
                ['value'=>'admin','label'=>'Admin','desc'=>'Akses penuh manajemen sistem','icon'=>'admin_panel_settings','color'=>'red'],
            ];
            @endphp
            <div class="space-y-2">
                @foreach ($rolesList as $rl)
                <label class="flex items-center gap-3 p-3 bg-white border border-slate-200 rounded-lg cursor-pointer hover:border-[#002045]/30 hover:bg-blue-50/30 transition-all">
                    <input type="radio" id="role_radio_{{ $rl['value'] }}" name="role_change" value="{{ $rl['label'] }}" class="accent-[#002045]">
                    <div class="flex-1">
                        <p class="text-sm font-bold text-slate-800">{{ $rl['label'] }}</p>
                        <p class="text-[10px] text-slate-500">{{ $rl['desc'] }}</p>
                    </div>
                </label>
                @endforeach
            </div>
            <div class="pt-4 flex justify-end gap-3">
                <button type="button" onclick="closeModal('changeRoleModal')" class="px-5 py-2.5 rounded-lg border border-slate-200 text-slate-600 font-bold text-sm hover:bg-slate-50">Batal</button>
                <button type="submit" class="px-8 py-2.5 rounded-lg bg-purple-600 text-white font-bold text-sm shadow-md hover:opacity-95">Simpan Role</button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Nonaktifkan / Aktifkan --}}
<div id="deactivateModal" class="fixed inset-0 z-50 items-center justify-center hidden bg-[#002045]/40 backdrop-blur-sm">
    <div class="bg-white rounded-2xl p-8 w-full max-w-sm text-center shadow-2xl mx-4">
        <form id="deactivateForm" action="" method="POST">
            @csrf
            @method('PUT')
            <div class="w-16 h-16 bg-amber-50 text-amber-600 rounded-full flex items-center justify-center mx-auto mb-5 border-4 border-amber-100">
                <span class="material-symbols-outlined text-3xl">swap_horiz</span>
            </div>
            <h3 id="deactivateTitle" class="text-xl font-bold text-[#002045] font-headline mb-2">Ubah Status Pengguna?</h3>
            <p id="deactivateDesc" class="text-sm text-slate-500 mb-8 leading-relaxed">Aksi ini akan mengganti status keaktifan user dalam sistem.</p>
            <div class="flex flex-col gap-3">
                <button type="submit" class="w-full py-3 rounded-lg bg-amber-500 text-white font-bold text-sm hover:bg-amber-600">Ya, Ubah Status</button>
                <button type="button" onclick="closeModal('deactivateModal')" class="w-full py-3 rounded-lg text-sm font-bold text-slate-600 bg-white border border-slate-200 hover:bg-slate-50">Batal</button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Hapus --}}
<div id="deleteUserModal" class="fixed inset-0 z-50 items-center justify-center hidden bg-[#002045]/40 backdrop-blur-sm">
    <div class="bg-white rounded-2xl p-8 w-full max-w-sm text-center shadow-2xl mx-4">
        <form id="deleteUserForm" action="" method="POST">
            @csrf
            @method('DELETE')
            <div class="w-16 h-16 bg-red-50 text-red-600 rounded-full flex items-center justify-center mx-auto mb-5 border-4 border-red-100">
                <span class="material-symbols-outlined text-3xl">warning</span>
            </div>
            <h3 class="text-xl font-bold text-[#002045] font-headline mb-2">Hapus Pengguna?</h3>
            <p class="text-sm text-slate-500 mb-8 leading-relaxed">Semua data pengguna termasuk riwayat peminjaman akan terhapus permanen.</p>
            <div class="flex flex-col gap-3">
                <button type="submit" class="w-full py-3 rounded-lg bg-red-600 text-white font-bold text-sm hover:bg-red-700">Ya, Hapus Permanen</button>
                <button type="button" onclick="closeModal('deleteUserModal')" class="w-full py-3 rounded-lg text-sm font-bold text-slate-600 bg-white border border-slate-200 hover:bg-slate-50">Batal</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal(id) { const m = document.getElementById(id); m.classList.remove('hidden'); m.classList.add('flex'); }
    function closeModal(id) { const m = document.getElementById(id); m.classList.add('hidden'); m.classList.remove('flex'); }

    function openEditUserModal(id, name, email, identity) {
        document.getElementById('editUserForm').action = `/admin/users/${id}`;
        document.getElementById('edit_name').value = name;
        document.getElementById('edit_email').value = email;
        document.getElementById('edit_identity').value = identity;
        openModal('editUserModal');
    }

    function openChangeRoleModal(id, name, init, roleSlug) {
        document.getElementById('changeRoleForm').action = `/admin/users/${id}/role`;
        document.getElementById('role_avatar').textContent = init;
        document.getElementById('role_user_name').textContent = name;
        
        // Uncheck all radio first
        ['mahasiswa', 'dosen', 'staf', 'organisasi', 'admin'].forEach(r => {
            const rad = document.getElementById(`role_radio_${r}`);
            if(rad) rad.checked = false;
        });

        // Check matching radio
        const targetRadio = document.getElementById(`role_radio_${roleSlug}`);
        if(targetRadio) targetRadio.checked = true;

        openModal('changeRoleModal');
    }

    function openToggleStatusModal(id, isActive) {
        document.getElementById('deactivateForm').action = `/admin/users/${id}/toggle-status`;
        document.getElementById('deactivateTitle').textContent = isActive ? 'Nonaktifkan Pengguna?' : 'Aktifkan Pengguna?';
        document.getElementById('deactivateDesc').textContent = isActive 
            ? 'Pengguna tidak akan bisa login hingga diaktifkan kembali.' 
            : 'Pengguna akan mendapatkan hak akses login kembali ke sistem.';
        openModal('deactivateModal');
    }

    function openDeleteUserModal(id) {
        document.getElementById('deleteUserForm').action = `/admin/users/${id}`;
        openModal('deleteUserModal');
    }
</script>
@endpush