@extends('layouts.admin')

@section('title', 'Manajemen Role')

@section('content')

    {{-- Header --}}
    <div class="flex justify-between items-center mb-8">
        <div>
            <h2 class="text-3xl font-extrabold text-[#002045] font-headline tracking-tight">Manajemen Role & Hak Akses</h2>
            <p class="text-slate-500 text-sm mt-1">Kelola role pengguna dan konfigurasi hak akses sistem.</p>
        </div>
        <button onclick="openModal('addRoleModal')"
                class="bg-primary-gradient text-white px-5 py-2.5 rounded-lg font-bold text-sm flex items-center gap-2 hover:opacity-95 shadow-md">
            <span class="material-symbols-outlined text-sm">add</span>
            Tambah Role
        </button>
    </div>

    {{-- Konfigurasi Warna --}}
    @php
    $colorConfig = [
        'red'     => ['bg'=>'bg-red-50',    'text'=>'text-red-600',    'border'=>'border-red-100',    'badge'=>'bg-red-100 text-red-700',    'icon_bg'=>'bg-red-100'],
        'purple'  => ['bg'=>'bg-purple-50', 'text'=>'text-purple-600', 'border'=>'border-purple-100', 'badge'=>'bg-purple-100 text-purple-700','icon_bg'=>'bg-purple-100'],
        'blue'    => ['bg'=>'bg-blue-50',   'text'=>'text-blue-600',   'border'=>'border-blue-100',   'badge'=>'bg-blue-100 text-blue-700',   'icon_bg'=>'bg-blue-100'],
        'emerald' => ['bg'=>'bg-emerald-50','text'=>'text-emerald-600','border'=>'border-emerald-100','badge'=>'bg-emerald-100 text-emerald-700','icon_bg'=>'bg-emerald-100'],
        'orange'  => ['bg'=>'bg-orange-50', 'text'=>'text-orange-600', 'border'=>'border-orange-100', 'badge'=>'bg-orange-100 text-orange-700','icon_bg'=>'bg-orange-100'],
    ];
    @endphp

    {{-- Kartu Role Dinamis --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 mb-8">
        @foreach ($roles as $role)
        @php 
            $colorKey = $role->color ?? 'blue'; 
            $c = $colorConfig[$colorKey] ?? $colorConfig['blue']; 
            $permissions = is_array($role->permissions) ? $role->permissions : [];
        @endphp
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm hover:shadow-md transition-all overflow-hidden group">
            {{-- Header Kartu --}}
            <div class="p-6 border-b border-slate-100">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-xl {{ $c['icon_bg'] }} {{ $c['text'] }} flex items-center justify-center">
                            <span class="material-symbols-outlined text-2xl">{{ $role->icon }}</span>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-slate-800 font-headline">{{ $role->name }}</h3>
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $role->users_count }} pengguna</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                        <button onclick='openEditRoleModal({{ $role->id }}, @json($role->name), @json($role->description), @json($permissions))' class="p-1.5 {{ $c['bg'] }} {{ $c['text'] }} rounded-lg hover:opacity-80 transition-all" title="Edit Role">
                            <span class="material-symbols-outlined text-sm">edit</span>
                        </button>
                        @if (strtolower($role->name) !== 'admin')
                        <button onclick="openDeleteRoleModal('{{ $role->id }}')" class="p-1.5 bg-red-50 text-red-500 rounded-lg hover:opacity-80 transition-all" title="Hapus Role">
                            <span class="material-symbols-outlined text-sm">delete</span>
                        </button>
                        @endif
                    </div>
                </div>
                <p class="text-xs text-slate-500 leading-relaxed">{{ $role->description }}</p>
            </div>

            {{-- Daftar Izin --}}
            <div class="p-6">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widests mb-3">Hak Akses</p>
                <div class="flex flex-wrap gap-2">
                    @forelse ($permissions as $perm)
                    <span class="px-2.5 py-1 {{ $c['badge'] }} text-[10px] font-bold rounded-full">
                        {{ $perm }}
                    </span>
                    @empty
                    <span class="text-xs text-slate-400 italic">Belum ada hak akses.</span>
                    @endforelse
                </div>
            </div>

            {{-- Footer --}}
            <div class="px-6 pb-5">
                <button onclick='openEditRoleModal({{ $role->id }}, @json($role->name), @json($role->description), @json($permissions))'
                        class="w-full py-2 border border-slate-200 rounded-lg text-xs font-bold text-slate-600 hover:bg-slate-50 hover:border-slate-300 transition-all flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-sm">tune</span>
                    Atur Hak Akses
                </button>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Tabel Matriks Izin Dinamis --}}
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-200">
            <h3 class="font-headline text-base font-bold text-[#002045]">Matriks Hak Akses</h3>
            <p class="text-xs text-slate-400 mt-0.5">Perbandingan izin antar role secara menyeluruh</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200">
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-widests min-w-[200px]">Fitur / Aksi</th>
                        @foreach ($roles as $role)
                        <th class="px-4 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-widests text-center">{{ $role->name }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach ($allPermissions as $feature)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-3.5 text-sm font-medium text-slate-700">{{ $feature }}</td>
                        @foreach ($roles as $role)
                        @php 
                            $colorKey = $role->color ?? 'blue'; 
                            $c = $colorConfig[$colorKey] ?? $colorConfig['blue'];
                            $hasAccess = in_array($feature, is_array($role->permissions) ? $role->permissions : []);
                        @endphp
                        <td class="px-4 py-3.5 text-center">
                            @if ($hasAccess)
                                <span class="inline-flex items-center justify-center w-6 h-6 {{ $c['icon_bg'] }} {{ $c['text'] }} rounded-full">
                                    <span class="material-symbols-outlined text-sm">check</span>
                                </span>
                            @else
                                <span class="inline-flex items-center justify-center w-6 h-6 bg-slate-100 text-slate-300 rounded-full">
                                    <span class="material-symbols-outlined text-sm">remove</span>
                                </span>
                            @endif
                        </td>
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection

@push('scripts')

{{-- Modal Tambah Role --}}
<div id="addRoleModal" class="fixed inset-0 z-50 items-center justify-center hidden bg-[#002045]/40 backdrop-blur-sm">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg mx-4 overflow-hidden flex flex-col max-h-[90vh]">
        <div class="px-6 py-5 border-b border-slate-200 flex items-center justify-between">
            <h3 class="text-lg font-bold text-[#002045] font-headline">Tambah Role Baru</h3>
            <button onclick="closeModal('addRoleModal')" class="p-2 rounded-full hover:bg-slate-100 text-slate-400">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <form action="/admin/roles/store" method="POST" class="p-6 overflow-y-auto space-y-5 bg-slate-50/50">
            @csrf
            <div>
                <label class="block text-[11px] font-bold uppercase tracking-widests text-slate-500 mb-2">Nama Role</label>
                <input type="text" name="name" placeholder="Contoh: Koordinator Lab" class="w-full bg-white border border-slate-200 rounded-lg p-3.5 text-sm focus:ring-2 focus:ring-[#002045]/20 outline-none" required>
            </div>
            <div>
                <label class="block text-[11px] font-bold uppercase tracking-widests text-slate-500 mb-2">Deskripsi</label>
                <textarea name="description" rows="3" placeholder="Jelaskan tujuan dan cakupan role ini..." class="w-full bg-white border border-slate-200 rounded-lg p-3.5 text-sm focus:ring-2 focus:ring-[#002045]/20 outline-none resize-none"></textarea>
            </div>
            <div>
                <label class="block text-[11px] font-bold uppercase tracking-widests text-slate-500 mb-3">Hak Akses</label>
                <div class="space-y-2">
                    @foreach ($allPermissions as $perm)
                    <label class="flex items-center gap-3 p-3 bg-white border border-slate-200 rounded-lg cursor-pointer hover:bg-slate-50 transition-colors">
                        <input type="checkbox" name="permissions[]" value="{{ $perm }}" class="accent-[#002045] w-4 h-4">
                        <span class="text-sm font-medium text-slate-700">{{ $perm }}</span>
                    </label>
                    @endforeach
                </div>
            </div>
            <div class="pt-4 flex justify-end gap-3">
                <button type="button" onclick="closeModal('addRoleModal')" class="px-5 py-2.5 rounded-lg border border-slate-200 text-slate-600 font-bold text-sm hover:bg-slate-50">Batal</button>
                <button type="submit" class="px-8 py-2.5 rounded-lg bg-primary-gradient text-white font-bold text-sm shadow-md hover:opacity-95">Simpan Role</button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Edit Role --}}
<div id="editRoleModal" class="fixed inset-0 z-50 items-center justify-center hidden bg-[#002045]/40 backdrop-blur-sm">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg mx-4 overflow-hidden flex flex-col max-h-[90vh]">
        <div class="px-6 py-5 border-b border-slate-200 flex items-center justify-between">
            <h3 class="text-lg font-bold text-[#002045] font-headline">Edit Role & Hak Akses</h3>
            <button onclick="closeModal('editRoleModal')" class="p-2 rounded-full hover:bg-slate-100 text-slate-400">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <form id="editRoleForm" action="" method="POST" class="p-6 overflow-y-auto space-y-5 bg-slate-50/50">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-[11px] font-bold uppercase tracking-widests text-slate-500 mb-2">Nama Role</label>
                <input type="text" id="edit_role_name" name="name" class="w-full bg-white border border-slate-200 rounded-lg p-3.5 text-sm focus:ring-2 focus:ring-[#002045]/20 outline-none" required>
            </div>
            <div>
                <label class="block text-[11px] font-bold uppercase tracking-widests text-slate-500 mb-2">Deskripsi</label>
                <textarea id="edit_role_desc" name="description" rows="3" class="w-full bg-white border border-slate-200 rounded-lg p-3.5 text-sm focus:ring-2 focus:ring-[#002045]/20 outline-none resize-none"></textarea>
            </div>
            <div>
                <label class="block text-[11px] font-bold uppercase tracking-widests text-slate-500 mb-3">Hak Akses</label>
                <div class="space-y-2">
                    @foreach ($allPermissions as $perm)
                    <label class="flex items-center gap-3 p-3 bg-white border border-slate-200 rounded-lg cursor-pointer hover:bg-slate-50 transition-colors">
                        <input type="checkbox" name="permissions[]" value="{{ $perm }}" id="perm_edit_{{ Str::slug($perm) }}" class="accent-[#002045] w-4 h-4 perm-checkbox">
                        <span class="text-sm font-medium text-slate-700">{{ $perm }}</span>
                    </label>
                    @endforeach
                </div>
            </div>
            <div class="pt-4 flex justify-end gap-3">
                <button type="button" onclick="closeModal('editRoleModal')" class="px-5 py-2.5 rounded-lg border border-slate-200 text-slate-600 font-bold text-sm hover:bg-slate-50">Batal</button>
                <button type="submit" class="px-8 py-2.5 rounded-lg bg-[#002045] text-white font-bold text-sm shadow-md hover:opacity-95">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Hapus Role --}}
<div id="deleteRoleModal" class="fixed inset-0 z-50 items-center justify-center hidden bg-[#002045]/40 backdrop-blur-sm">
    <div class="bg-white rounded-2xl p-8 w-full max-w-sm text-center shadow-2xl mx-4">
        <form id="deleteRoleForm" action="" method="POST">
            @csrf
            @method('DELETE')
            <div class="w-16 h-16 bg-red-50 text-red-600 rounded-full flex items-center justify-center mx-auto mb-5 border-4 border-red-100">
                <span class="material-symbols-outlined text-3xl">warning</span>
            </div>
            <h3 class="text-xl font-bold text-[#002045] font-headline mb-2">Hapus Role?</h3>
            <p class="text-sm text-slate-500 mb-8 leading-relaxed">Pengguna dengan role ini mungkin akan kehilangan akses. Pastikan pengguna sudah dipindahkan ke role lain.</p>
            <div class="flex flex-col gap-3">
                <button type="submit" class="w-full py-3 rounded-lg bg-red-600 text-white font-bold text-sm hover:bg-red-700">Ya, Hapus Role</button>
                <button type="button" onclick="closeModal('deleteRoleModal')" class="w-full py-3 rounded-lg text-sm font-bold text-slate-600 bg-white border border-slate-200 hover:bg-slate-50">Batal</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal(id) { const m = document.getElementById(id); m.classList.remove('hidden'); m.classList.add('flex'); }
    function closeModal(id) { const m = document.getElementById(id); m.classList.add('hidden'); m.classList.remove('flex'); }

    // Fungsi otomatis mengisi modal edit saat dipencet
    function openEditRoleModal(id, name, desc, permissions) {
        document.getElementById('editRoleForm').action = `/admin/roles/${id}`;
        document.getElementById('edit_role_name').value = name;
        document.getElementById('edit_role_desc').value = desc;

        // Reset semua checkbox
        document.querySelectorAll('.perm-checkbox').forEach(cb => cb.checked = false);

        // Centang checkbox yang dimiliki role ini
        if (Array.isArray(permissions)) {
            permissions.forEach(perm => {
                // Konversi string izin menjadi slug format (contoh: "Kelola Ruangan" -> "kelola-ruangan")
                let slug = perm.toLowerCase().replace(/ /g, '-');
                let checkbox = document.getElementById(`perm_edit_${slug}`);
                if (checkbox) checkbox.checked = true;
            });
        }

        openModal('editRoleModal');
    }

    function openDeleteRoleModal(id) {
        document.getElementById('deleteRoleForm').action = `/admin/roles/${id}`;
        openModal('deleteRoleModal');
    }
</script>
@endpush