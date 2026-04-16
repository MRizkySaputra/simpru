<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Daftar - SiPinjam Ruang</title>

    @vite(['resources/css/app.css', 'resources/css/auth.css', 'resources/js/app.js'])
</head>

<body class="register-body min-h-screen flex flex-col items-center justify-center p-6 relative z-0">

    <div class="w-full max-w-md z-10">

        <div class="mb-10 text-center">
            <h1 class="font-headline text-3xl font-extrabold tracking-tight text-[#1a365d] mb-2">SiPinjam Ruang</h1>
            <p class="text-[#555f70] text-sm">Universitas Ma'soem</p>
        </div>

        <div class="bg-white rounded-xl p-10 shadow-[0_12px_32px_-4px_rgba(24,28,30,0.06)] border border-[#c4c6cf]/15">
            <header class="mb-8">
                <h2 class="font-headline text-2xl font-bold text-[#181c1e] mb-1 text-center">Buat Akun</h2>
                <p class="text-[#43474e] text-sm text-center">Lengkapi data diri Anda untuk mengakses sistem peminjaman ruangan.</p>
            </header>

            <form action="#" method="POST" class="space-y-6">
                @csrf <div class="space-y-1.5">
                    <label class="text-[10px] font-bold uppercase tracking-wider text-[#3e4758]" for="full-name">Nama Lengkap</label>
                    <input class="w-full bg-[#e5e9eb] border-none rounded-lg px-4 py-3 text-sm text-[#181c1e] placeholder:text-[#74777f] transition-all focus:bg-white focus:ring-2 focus:ring-[#002045] focus:outline-none" id="full-name" name="name" placeholder="Masukkan nama lengkap" type="text" required>
                </div>

                <div class="space-y-1.5">
                    <label class="text-[10px] font-bold uppercase tracking-wider text-[#3e4758]" for="email">Alamat Email</label>
                    <input class="w-full bg-[#e5e9eb] border-none rounded-lg px-4 py-3 text-sm text-[#181c1e] placeholder:text-[#74777f] transition-all focus:bg-white focus:ring-2 focus:ring-[#002045] focus:outline-none" id="email" name="email" placeholder="nama@masoemuniversity.ac.id" type="email" required>
                </div>

                <div class="space-y-1.5">
                    <label class="text-[10px] font-bold uppercase tracking-wider text-[#3e4758]" for="id-number">NIM / NIDN</label>
                    <input class="w-full bg-[#e5e9eb] border-none rounded-lg px-4 py-3 text-sm text-[#181c1e] placeholder:text-[#74777f] transition-all focus:bg-white focus:ring-2 focus:ring-[#002045] focus:outline-none" id="id-number" name="id_number" placeholder="Contoh: 11223344" type="text" required>
                </div>

                <div class="space-y-1.5">
                    <label class="text-[10px] font-bold uppercase tracking-wider text-[#3e4758]" for="password">Kata Sandi</label>
                    <div class="relative">
                        <input class="w-full bg-[#e5e9eb] border-none rounded-lg px-4 py-3 text-sm text-[#181c1e] placeholder:text-[#74777f] transition-all focus:bg-white focus:ring-2 focus:ring-[#002045] focus:outline-none pr-12" id="password" name="password" placeholder="••••••••" type="password" required>
                        <button class="absolute right-3 top-1/2 -translate-y-1/2 text-[#74777f] hover:text-[#43474e] transition-colors p-1" type="button" onclick="togglePassword('password', 'toggleIcon')">
                            <span id="toggleIcon" class="material-symbols-outlined">visibility</span>
                        </button>
                    </div>
                    <script>
                        function togglePassword() {
                            const input = document.getElementById("password");
                            const icon = document.getElementById("toggleIcon");

                            if (input.type === "password") {
                                input.type = "text";
                                icon.textContent = "visibility_off";
                            } else {
                                input.type = "password";
                                icon.textContent = "visibility";
                            }
                        }
                    </script>
                </div>

                <div class="pt-2">
                    <button class="w-full bg-primary-gradient text-white font-headline font-bold py-3.5 rounded-lg shadow-md hover:brightness-110 active:scale-[0.98] transition-all flex items-center justify-center gap-2" type="submit">
                        Daftar
                    </button>
                </div>
            </form>

            <div class="mt-8 pt-8 border-t border-[#c4c6cf]/15 text-center">
                <p class="text-sm text-[#43474e]">
                    Sudah punya akun?
                    <a class="text-[#002045] font-semibold hover:underline decoration-[#002045] underline-offset-4 ml-1 transition-all" href="/login">Masuk</a>
                </p>
            </div>
        </div>

        <footer class="mt-12 text-center space-y-4">
            <div class="flex justify-center items-center gap-6 text-[10px] font-bold uppercase tracking-widest text-[#74777f]">
                <a class="hover:text-[#002045] transition-colors" href="#">Kebijakan Privasi</a>
                <span class="w-1 h-1 rounded-full bg-[#c4c6cf]"></span>
                <a class="hover:text-[#002045] transition-colors" href="#">Syarat & Ketentuan</a>
            </div>
            <p class="text-[10px] text-[#74777f]/60">© 2026 SiPinjam Ruang - Hak Cipta Dilindungi.</p>
        </footer>
    </div>

    <div class="fixed bottom-0 left-0 w-full overflow-hidden -z-10 opacity-30 pointer-events-none">
        <svg class="w-full h-auto translate-y-20" viewBox="0 0 1440 320">
            <path fill="#d6e3ff" fill-opacity="1" d="M0,224L80,213.3C160,203,320,181,480,186.7C640,192,800,224,960,234.7C1120,245,1280,235,1360,229.3L1440,224L1440,320L1360,320C1280,320,1120,320,960,320C800,320,640,320,480,320C320,320,160,320,80,320L0,320Z"></path>
        </svg>
    </div>

</body>
</html>