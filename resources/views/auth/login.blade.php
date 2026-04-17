<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Login - SiPinjam Ruang</title>

    @vite(['resources/css/app.css', 'resources/css/auth.css', 'resources/js/app.js'])
</head>

<body class="login-body min-h-screen flex items-center justify-center p-6 relative overflow-hidden">

    <div class="absolute top-[-10%] left-[-5%] w-[40vw] h-[40vw] bg-[#002045]/5 rounded-full blur-[100px] pointer-events-none -z-10"></div>
    <div class="absolute bottom-[-10%] right-[-5%] w-[30vw] h-[30vw] bg-[#1a365d]/10 rounded-full blur-[100px] pointer-events-none -z-10"></div>

    <main class="w-full max-w-md z-10">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">

            <div class="pt-10 pb-6 px-10 flex flex-col items-center text-center">
                <div class="mb-6 w-16 h-16 bg-[#e5e9eb] rounded-full flex items-center justify-center">
                    <span class="material-symbols-outlined text-[#002045] text-4xl scale-150">account_balance</span>
                </div>
                <h1 class="font-headline text-2xl font-extrabold text-[#002045] tracking-tight">SIMPRU</h1>
                <p class="text-variant text-sm mt-2">Sistem Peminjaman & Monitoring Kelas</p>
            </div>

            @if(session('error'))
                <div class="mx-10 mb-4 p-3 bg-red-50 border border-red-200 text-red-600 text-sm font-bold rounded-lg text-center">
                    {{ session('error') }}
                </div>
            @endif

            <form action="/login-process" method="POST" class="px-10 pb-10 space-y-6">
                @csrf
                <div class="space-y-2">
                    <label class="text-xs font-bold uppercase tracking-wider text-variant px-1" for="username">Username</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="material-symbols-outlined text-outline-color text-xl">person</span>
                        </div>
                        <input class="block w-full pl-14 pr-4 py-3 bg-[#e5e9eb] border-none rounded-lg text-sm focus:ring-2 focus:ring-[#002045]/20 outline-none" id="username" name="username" type="text" placeholder="Enter your username" required>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-bold uppercase tracking-wider text-variant px-1" for="password">Kata Sandi</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="material-symbols-outlined text-outline-color text-xl">lock</span>
                        </div>
                        <input class="block w-full pl-14 pr-12 py-3 bg-[#e5e9eb] border-none rounded-lg text-sm focus:ring-2 focus:ring-[#002045]/20 outline-none" id="password" name="password" type="password" placeholder="••••••••" required>
                        
                        <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 pr-3 flex items-center text-[#002045]">
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

                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center">
                        <label for="create-account" class="ml-2 block text-sm text-gray-600">Do you have an account?</label>
                        <a href="/register" class="text-sm font-medium text-[#002045] hover:underline decoration-[#002045] underline-offset-4 ml-1 transition-all">Create account</a>
                    </div>
                </div>

                <button class="w-full bg-primary-gradient text-white font-headline font-bold py-3.5 rounded-lg shadow-md hover:brightness-110 active:scale-[0.98] transition-all flex items-center justify-center gap-2" type="submit">
                    Masuk
                    <span class="material-symbols-outlined text-lg">arrow_forward</span>
                </button>

                <div class="flex items-end justify-end mb-5">
                    <a href="forget-password" class="text-sm font-medium text-[#002045] hover:underline decoration-[#002045] underline-offset-4 ml-1 transition-all">Forget Password?</a>
                </div>
            </form>
        </div>

        <footer class="mt-8 text-center text-[#43474e]/60 text-[11px] uppercase tracking-widest">
            © 2026 Ma'soem University • All Rights Reserved
        </footer>
    </main>
</body>
</html>