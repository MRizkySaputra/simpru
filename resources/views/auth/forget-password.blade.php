<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Lupa Password - SiPinjam Ruang</title>

    @vite(['resources/css/app.css', 'resources/css/auth.css', 'resources/js/app.js'])
</head>
<body class="forgot-password-body min-h-screen flex flex-col items-center justify-center p-6 relative z-0">

    <div class="fixed inset-0 z-[-1] overflow-hidden pointer-events-none">
        <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] rounded-full bg-[#d6e3ff]/30 blur-[120px]"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] rounded-full bg-[#d9e3f8]/30 blur-[120px]"></div>
    </div>

    <main class="w-full max-w-md z-10">
        <div class="bg-white rounded-xl p-8 md:p-10 shadow-[0_12px_32px_-4px_rgba(24,28,30,0.06)] border border-[#c4c6cf]/15 flex flex-col items-center">
            
            <div class="mb-8 flex flex-col items-center">
                <div class="w-16 h-16 bg-primary-gradient rounded-xl flex items-center justify-center mb-4 shadow-lg">
                    <span class="material-symbols-outlined text-white text-4xl">domain</span>
                </div>
                <h2 class="font-headline text-xl font-extrabold text-[#002045] tracking-tight">SIMPRU</h2>
            </div>

            <div class="text-center mb-8">
                <h1 class="font-headline text-2xl font-bold text-[#181c1e] mb-3 tracking-tight">Lupa Password?</h1>
                <p class="text-[#5b6577] text-sm leading-relaxed">
                    Masukkan email Anda untuk menerima instruksi pemulihan kata sandi.
                </p>
            </div>

            <form action="#" method="POST" class="w-full space-y-6">
                @csrf <div class="space-y-2">
                    <label class="block text-[0.75rem] font-bold text-[#43474e] uppercase tracking-wider" for="identity">Email</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="material-symbols-outlined text-outline-color text-xl">mail</span>
                        </div>
                        <input class="block w-full pl-11 pr-4 py-3 bg-[#e5e9eb] border-none rounded-lg text-[#181c1e] placeholder:text-[#74777f]/60 focus:ring-2 focus:ring-[#002045] focus:bg-white transition-all duration-200 text-sm outline-none" id="identity" name="identity" placeholder="Masukkan email" required type="text">
                    </div>
                </div>

                <button class="w-full bg-primary-gradient text-white font-headline font-bold py-3.5 rounded-lg shadow-md hover:brightness-110 active:scale-[0.98] transition-all flex items-center justify-center gap-2" type="submit">
                    <span>Kirim Instruksi</span>
                </button>
            </form>

            <div class="mt-8 pt-6 border-t border-[#c4c6cf]/15 w-full text-center">
                <a class="inline-flex items-center gap-2 text-sm font-medium text-[#5b6577] hover:text-[#002045] transition-colors group" href="/login">
                    <span class="material-symbols-outlined text-lg group-hover:-translate-x-1 transition-transform">arrow_back</span>
                    <span>Kembali ke Login</span>
                </a>
            </div>
        </div>
    </main>

    <footer class="mt-12 w-full max-w-2xl text-center space-y-3 z-10">
        <p class="text-[0.75rem] font-body text-[#94a3b8] tracking-normal leading-relaxed">
            Sistem Digital Peminjaman & Monitoring Ruang Kelas
        </p>
        <div class="flex items-center justify-center gap-6">
            <a class="text-[0.7rem] text-[#94a3b8] hover:text-[#2563eb] transition-colors" href="#">Syarat & Ketentuan</a>
            <span class="w-1 h-1 rounded-full bg-[#cbd5e1]"></span>
            <a class="text-[0.7rem] text-[#94a3b8] hover:text-[#2563eb] transition-colors" href="#">Kebijakan Privasi</a>
            <span class="w-1 h-1 rounded-full bg-[#cbd5e1]"></span>
            <a class="text-[0.7rem] text-[#94a3b8] hover:text-[#2563eb] transition-colors" href="#">Bantuan</a>
        </div>
        <p class="text-[0.75rem] text-[#94a3b8] pt-4">
            © 2026 Universitas Ma'soem
        </p>
    </footer>

</body>
</html>