@extends('layouts.auth')

@section('title', 'Daftar Akun')
@section('icon', 'person_add')
@section('card_title', 'SIMPRU')
@section('card_subtitle', 'Sistem Informasi Manajemen Peminjaman Ruangan')

@section('content')

{{-- Menampilkan Error dari Server --}}
@if ($errors->any())
    <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-600 rounded-lg">
        <ul class="list-disc pl-5 text-xs font-bold">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="/register-process" method="POST" class="space-y-4">
@csrf

{{-- STEP 1 --}}
<div id="step1" class="space-y-4">

    {{-- Nama Lengkap --}}
    <div class="space-y-2">
        <label class="text-xs font-bold uppercase tracking-wider text-variant px-1">Nama Lengkap <span class="text-red-500">*</span></label>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <span class="material-symbols-outlined text-outline-color text-xl">badge</span>
            </div>
            <input class="block w-full pl-12 pr-4 py-3 bg-[#e5e9eb] border-none rounded-lg text-sm focus:ring-2 focus:ring-[#002045]/20 outline-none"
                   id="inp_name" name="name" type="text" placeholder="Masukkan nama lengkap Anda" value="{{ old('name') }}" required>
        </div>
    </div>

    {{-- Email --}}
    <div class="space-y-2">
        <label class="text-xs font-bold uppercase tracking-wider text-variant px-1">Alamat Email <span class="text-red-500">*</span></label>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <span class="material-symbols-outlined text-outline-color text-xl">mail</span>
            </div>
            <input class="block w-full pl-12 pr-4 py-3 bg-[#e5e9eb] border-none rounded-lg text-sm focus:ring-2 focus:ring-[#002045]/20 outline-none"
                   id="inp_email" name="email" type="email" placeholder="contoh@email.com" value="{{ old('email') }}" required>
        </div>
    </div>

    {{-- NIM / NIDN --}}
    <div class="space-y-2">
        <label class="text-xs font-bold uppercase tracking-wider text-variant px-1">NIM / NIDN <span class="text-red-500">*</span></label>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <span class="material-symbols-outlined text-outline-color text-xl">pin</span>
            </div>
            <input class="block w-full pl-12 pr-4 py-3 bg-[#e5e9eb] border-none rounded-lg text-sm focus:ring-2 focus:ring-[#002045]/20 outline-none"
                   id="inp_id" name="id_number" type="text" placeholder="Masukkan NIM atau NIDN Anda" value="{{ old('id_number') }}" required>
        </div>
    </div>

    {{-- Role --}}
    <div class="space-y-2">
        <label class="text-xs font-bold uppercase tracking-wider text-variant px-1">Peran / Jabatan <span class="text-red-500">*</span></label>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <span class="material-symbols-outlined text-outline-color text-xl">work</span>
            </div>
            <select class="block w-full pl-12 pr-4 py-3 bg-[#e5e9eb] border-none rounded-lg text-sm focus:ring-2 focus:ring-[#002045]/20 outline-none appearance-none"
                    id="inp_role" name="role" required>
                <option value="" disabled {{ old('role') ? '' : 'selected' }}>Pilih peran Anda</option>
                <option value="mahasiswa" {{ old('role') == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                <option value="dosen" {{ old('role') == 'dosen' ? 'selected' : '' }}>Dosen</option>
                <option value="staf" {{ old('role') == 'staf' ? 'selected' : '' }}>Staf / Pegawai</option>
                <option value="organisasi" {{ old('role') == 'organisasi' ? 'selected' : '' }}>Organisasi Mahasiswa</option>
            </select>
        </div>
    </div>

    <button type="button" onclick="nextStep()"
        class="w-full bg-primary-gradient text-white font-headline font-bold py-3.5 rounded-lg shadow-md flex items-center justify-center gap-2">
        Selanjutnya
        <span class="material-symbols-outlined text-lg">arrow_forward</span>
    </button>

</div>


{{-- STEP 2 --}}
<div id="step2" class="space-y-4 hidden">

    {{-- Password --}}
    <div class="space-y-2">
        <label class="text-xs font-bold uppercase tracking-wider text-variant px-1">Kata Sandi <span class="text-red-500">*</span></label>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <span class="material-symbols-outlined text-outline-color text-xl">lock</span>
            </div>
            <input class="block w-full pl-12 pr-12 py-3 bg-[#e5e9eb] border-none rounded-lg text-sm focus:ring-2 focus:ring-[#002045]/20 outline-none"
                   id="password" name="password" type="password" placeholder="Minimal 8 karakter" required>
            <button type="button" onclick="togglePassword()"
                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-[#002045]">
                <span id="toggleIcon" class="material-symbols-outlined">visibility</span>
            </button>
        </div>
    </div>

    {{-- Konfirmasi --}}
    <div class="space-y-2">
        <label class="text-xs font-bold uppercase tracking-wider text-variant px-1">Konfirmasi Kata Sandi <span class="text-red-500">*</span></label>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <span class="material-symbols-outlined text-outline-color text-xl">lock_reset</span>
            </div>
            {{-- PERHATIAN: Atribut name ini sangat penting, harus "password_confirmation" --}}
            <input class="block w-full pl-12 pr-4 py-3 bg-[#e5e9eb] border-none rounded-lg text-sm focus:ring-2 focus:ring-[#002045]/20 outline-none"
                   name="password_confirmation" type="password" placeholder="Ulangi kata sandi" required>
        </div>
    </div>

    <div class="flex gap-3">

        <button type="button" onclick="prevStep()"
            class="w-1/2 bg-gray-300 text-gray-800 font-bold py-3 rounded-lg">
            Kembali
        </button>

        <button type="submit"
            class="w-1/2 bg-primary-gradient text-white font-headline font-bold py-3 rounded-lg flex items-center justify-center gap-2">
            Buat Akun
            <span class="material-symbols-outlined text-lg">arrow_forward</span>
        </button>

    </div>

</div>

{{-- Login --}}
<div class="flex justify-center pt-2">
    <span class="text-sm text-gray-600">Sudah punya akun?</span>
    <a href="/login" class="text-sm font-medium text-[#002045] hover:underline ml-1">
        Masuk di sini
    </a>
</div>

</form>

@endsection

@push('scripts')
<script>

function nextStep(){
    const name = document.getElementById('inp_name').value;
    const email = document.getElementById('inp_email').value;
    const idNum = document.getElementById('inp_id').value;
    const role = document.getElementById('inp_role').value;

    // 1. Cek apakah ada yang kosong
    if(!name || !email || !idNum || !role) {
        alert('Mohon lengkapi semua data pada formulir ini terlebih dahulu!');
        return;
    }

    // 2. Validasi Format Email (Harus ada @ dan titik domain)
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(email)) {
        alert('Format email tidak valid! Harus menggunakan "@" dan domain (contoh: aceng@gmail.com)');
        return;
    }

    // Lanjut ke step 2 jika lolos semua
    document.getElementById('step1').classList.add('hidden');
    document.getElementById('step2').classList.remove('hidden');
}

function prevStep(){
    document.getElementById('step2').classList.add('hidden');
    document.getElementById('step1').classList.remove('hidden');
}

function togglePassword(){
    const input = document.getElementById('password');
    const icon = document.getElementById('toggleIcon');

    if(input.type === 'password'){
        input.type = 'text';
        icon.textContent = 'visibility_off';
    }else{
        input.type = 'password';
        icon.textContent = 'visibility';
    }
}

// Buka otomatis step 2 jika ada error password dari server
@if($errors->has('password'))
    nextStep();
@endif

</script>
@endpush