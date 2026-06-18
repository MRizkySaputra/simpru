<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMPRU - Bukti Peminjaman #{{ $booking->req_id }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            body { background: white; color: black; }
            .no-print { display: none; }
            .print-border { border: 2px solid #000 !important; }
        }
    </style>
</head>
<body class="bg-slate-100 font-sans p-4 md:p-8">

    <div class="max-w-3xl mx-auto mb-6 flex justify-between items-center no-print">
        <button onclick="window.close()" class="px-4 py-2 bg-slate-500 text-white font-semibold rounded-lg shadow hover:bg-slate-600 transition flex items-center gap-2">
            Tutup Halaman
        </button>
        <button onclick="window.print()" class="px-6 py-2 bg-blue-800 text-white font-bold rounded-lg shadow hover:bg-blue-900 transition flex items-center gap-2">
            Mulai Cetak / Simpan PDF
        </button>
    </div>

    <div class="max-w-3xl mx-auto bg-white p-10 rounded-xl shadow-sm border border-slate-200 print-border relative overflow-hidden">
        
        <div class="absolute inset-0 opacity-[0.03] pointer-events-none flex items-center justify-center select-none">
            <h1 class="text-8xl font-black transform -rotate-45">SIMPRU VALID</h1>
        </div>

        <div class="flex justify-between items-center border-b-2 border-slate-900 pb-6 mb-8">
            <div>
                <h1 class="text-2xl font-black tracking-tight text-slate-900">SIMPRU</h1>
                <p class="text-xs text-slate-500 font-semibold uppercase tracking-wider">Sistem Manajemen Peminjaman Ruangan</p>
            </div>
            <div class="text-right">
                <span class="px-3 py-1 bg-emerald-100 text-emerald-800 font-bold text-xs uppercase tracking-widest rounded">VALID / APPROVED</span>
                <p class="text-xs text-slate-400 mt-2">ID Dokumen: #{{ $booking->req_id }}</p>
            </div>
        </div>

        <div class="text-center mb-8">
            <h2 class="text-xl font-bold uppercase tracking-wide text-slate-900 decoration-1 underline underline-offset-4">SURAT IZIN PENGGUNAAN RUANGAN</h2>
            <p class="text-sm text-slate-500 mt-1">Diterbitkan otomatis oleh Sistem SIMPRU pada {{ now()->translatedFormat('d F Y H:i') }} WIB</p>
        </div>

        <p class="text-sm text-slate-700 leading-relaxed mb-6">
            Berdasarkan hasil verifikasi sistem dan persetujuan dari pihak Admin Logistik/Sarana Prasarana Kampus, dengan ini diberikan izin penggunaan ruangan kepada pengguna tertera di bawah ini:
        </p>

        <table class="w-full text-sm border-collapse mb-8">
            <tbody>
                <tr class="border-b border-slate-200">
                    <td class="py-3 font-bold text-slate-600 w-1/3">Nama Penanggung Jawab</td>
                    <td class="py-3 text-slate-900">: {{ auth()->user()->name }}</td>
                </tr>
                <tr class="border-b border-slate-200">
                    <td class="py-3 font-bold text-slate-600">NIM / Nomor Identitas</td>
                    <td class="py-3 text-slate-900">: {{ auth()->user()->identity_number }}</td>
                </tr>
                <tr class="border-b border-slate-200">
                    <td class="py-3 font-bold text-slate-600">Nama Kegiatan</td>
                    <td class="py-3 text-slate-900 font-semibold">: {{ $booking->activity_name }}</td>
                </tr>
                <tr class="border-b border-slate-200">
                    <td class="py-3 font-bold text-slate-600">Jenis Kegiatan</td>
                    <td class="py-3 text-slate-900">: {{ $booking->activity_type }}</td>
                </tr>
                <tr class="border-b border-slate-200">
                    <td class="py-3 font-bold text-slate-600">Ruangan & Lokasi</td>
                    <td class="py-3 text-slate-900 font-bold">: {{ $booking->room->name ?? 'Ruangan' }} (Gedung {{ $booking->room->building_id ?? 'A' }})</td>
                </tr>
                <tr class="border-b border-slate-200">
                    <td class="py-3 font-bold text-slate-600">Waktu Pelaksanaan</td>
                    <td class="py-3 text-slate-900">: {{ \Carbon\Carbon::parse($booking->date)->translatedFormat('d F Y') }}</td>
                </tr>
                <tr class="border-b border-slate-200">
                    <td class="py-3 font-bold text-slate-600">Durasi Jam Kerja</td>
                    <td class="py-3 text-slate-900">: {{ substr($booking->start_time, 0, 5) }} s/d {{ substr($booking->end_time, 0, 5) }} WIB</td>
                </tr>
                <tr class="border-b border-slate-200">
                    <td class="py-3 font-bold text-slate-600">Estimasi Jumlah Peserta</td>
                    <td class="py-3 text-slate-900">: {{ $booking->participants }} Orang</td>
                </tr>
            </tbody>
        </table>

        <div class="bg-slate-50 border border-slate-200 rounded-lg p-4 mb-8 text-xs text-slate-600 leading-relaxed">
            <h4 class="font-bold text-slate-900 mb-1">Syarat & Ketentuan Penggunaan Ruangan:</h4>
            <ol class="list-decimal pl-4 space-y-1">
                <li>Wajib menjaga kebersihan, ketertiban, dan fasilitas di dalam ruangan selama kegiatan berlangsung.</li>
                <li>Dilarang mengubah posisi instrumen kelistrikan atau perangkat inventaris kampus tanpa izin petugas.</li>
                <li>Pastikan seluruh AC, lampu, dan proyektor telah dimatikan kembali setelah selesai digunakan.</li>
                <li>Tunjukkan lembar cetak bukti/PDF ini kepada petugas keamanan kampus (SATPAM) saat meminta kunci ruangan.</li>
            </ol>
        </div>

        <div class="flex justify-between items-end text-sm mt-12">
            <div class="text-center w-40">
                <p class="text-xs text-slate-400 mb-12">Petugas Keamanan</p>
                <div class="border-t border-slate-400 pt-2 font-medium text-slate-400">( ............................ )</div>
            </div>
            
            <div class="text-center flex flex-col items-center">
                <div class="w-20 h-20 bg-slate-100 border border-slate-300 flex items-center justify-center p-1 text-slate-400 text-[10px] rounded shadow-inner mb-1">
                     QR VALID SYSTEM
                </div>
                <p class="text-[10px] text-slate-400 font-mono">SIMPRU-SECURE-KEY</p>
            </div>

            <div class="text-center w-40">
                <p class="text-xs text-slate-500 mb-12">Sistem Informasi SIMPRU</p>
                <div class="border-t border-slate-900 pt-2 font-bold text-slate-900">ADMINISTRATOR</div>
            </div>
        </div>

    </div>

</body>
</html>