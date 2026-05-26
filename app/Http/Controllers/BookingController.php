<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function ajukan()
    {
        // 1. Ambil semua data ruangan asli dari database
        $dbRooms = Room::all();

        // 2. Ubah formatnya agar sesuai dengan kebutuhan Javascript di view
        $rooms = $dbRooms->map(function($room) {
            return [
                'code' => $room->code,
                'gedung' => $room->building_id, 
                'name' => $room->name,
                'building' => 'Gedung ' . $room->building_id,
                'capacity' => $room->capacity,
                // Kalau ada gambar di DB, pakai itu. Kalau tidak, pakai gambar default lab.
                'img' => $room->image_path ? asset('storage/' . $room->image_path) : 'https://images.unsplash.com/photo-1593642632559-0c6d3fc62b89?auto=format&fit=crop&w=400&q=80',
                'desc' => 'Fasilitas standar tersedia.' 
            ];
        })->toArray();

        return view('user.ajukan', compact('rooms'));
    }

public function ajukanDetail(Request $request)
    {
        $selectedRoomName = $request->query('roomName');
        $selectedDate = $request->query('date');
        $selectedHour = $request->query('hour');
        
        // CARA PROPER: Cari ruangan berdasarkan nama dengan exact match
        $room = Room::where('name', $selectedRoomName)->first();

        // Jika ruangan benar-benar tidak ada di database, lempar kembali dengan pesan error yang jelas
        if (!$room) {
            return redirect('/user/ajukan')->with('error', "Ruangan '{$selectedRoomName}' tidak ditemukan di database. Pastikan data seeder sesuai dengan nama di kalender.");
        }

        $startTime = str_pad($selectedHour, 2, '0', STR_PAD_LEFT) . ':00:00';
        $endTime = str_pad($selectedHour + 1, 2, '0', STR_PAD_LEFT) . ':00:00';

        $fasilitas = [
            ['icon' => 'speaker', 'border_color' => 'border-blue-100', 'text_color' => 'text-blue-600', 'nama' => 'Sound System Premium'],
            ['icon' => 'ac_unit', 'border_color' => 'border-emerald-100', 'text_color' => 'text-emerald-600', 'nama' => 'AC Sentral'],
            ['icon' => 'podium', 'border_color' => 'border-purple-100', 'text_color' => 'text-purple-600', 'nama' => 'Panggung Utama'],
        ];

        return view('user.ajukan-detail', compact('room', 'selectedDate', 'startTime', 'endTime', 'fasilitas'));
    }

    public function ajukanProses(Request $request)
    {
        // 1. Validasi Super Ketat (Termasuk File PDF/Word)
        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
            'activity_name' => 'required|string|max:255',
            'activity_type' => 'required|string',
            'participants' => 'required|integer|min:1',
            'document_path' => 'nullable|file|mimes:pdf,doc,docx|max:5120', // Maksimal 5MB
        ]);

        // 2. Proses Upload File Surat Permohonan (Jika Ada)
        $filePath = null;
        if ($request->hasFile('document_path')) {
            // File akan disimpan di folder storage/app/public/documents
            $filePath = $request->file('document_path')->store('documents', 'public');
        }

        // 3. Generate ID Permohonan
        $reqId = 'REQ-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -4));

        // 4. Simpan ke Database
        Booking::create([
            'req_id' => $reqId,
            'user_id' => Auth::id(),
            'room_id' => $validated['room_id'],
            'date' => $validated['date'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'activity_name' => $validated['activity_name'],
            'activity_type' => $validated['activity_type'],
            'participants' => $validated['participants'],
            'document_path' => $filePath, // Path file disimpan di sini
            'status' => 'menunggu',
        ]);

        return redirect('/user/riwayat')->with('success', 'Permohonan dan dokumen berhasil diajukan!');
    }
}