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
        $dbRooms = \App\Models\Room::all();
        $rooms = $dbRooms->map(function($room) {
            return [
                'code' => $room->code,
                'gedung' => $room->building_id,
                'name' => $room->name,
                'building' => 'Gedung ' . $room->building_id,
                'capacity' => $room->capacity,
                'img' => $room->image_path ? asset('storage/' . $room->image_path) : 'https://images.unsplash.com/photo-1593642632559-0c6d3fc62b89?auto=format&fit=crop&w=400&q=80',
                'desc' => 'Fasilitas standar tersedia.'
            ];
        })->toArray();

        $dbBookings = \App\Models\Booking::whereIn('status', ['menunggu', 'disetujui'])->get();
        $bookingsList = [];

        foreach($dbBookings as $booking) {
            $room = \App\Models\Room::find($booking->room_id);
            if(!$room) continue;

            $bookingsList[] = [
                'roomCode'  => $room->code,
                'gedung'    => $room->building_id,
                'roomName'  => $room->name,
                'capacity'  => $room->capacity,
                'img'       => $room->image_path ? asset('storage/' . $room->image_path) : 'https://images.unsplash.com/photo-1593642632559-0c6d3fc62b89?auto=format&fit=crop&w=400&q=80',
                'desc'      => 'Fasilitas standar tersedia.',
                'dateStr'   => $booking->date,
                'startHour' => (int) date('H', strtotime($booking->start_time)),
                'endHour'   => (int) date('H', strtotime($booking->end_time)),
                'status'    => strtolower($booking->status),
                'title'     => $booking->activity_name,
                'booker'    => 'Pemohon',
            ];
        }

        return view('user.ajukan', compact('rooms', 'bookingsList'));
    }

    public function ajukanDetail(Request $request)
    {
        $selectedRoomName = $request->query('roomName');
        $selectedDate = $request->query('date');
        $selectedHour = $request->query('hour');

        $room = Room::where('name', $selectedRoomName)->first();

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

    public function ajukanKonfirmasi(Request $request)
    {
        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'date' => 'required|date|after_or_equal:today', 
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'activity_name' => 'required|string|max:255',
            'activity_type' => 'required|string',
            'participants' => 'required|integer|min:1',
            'document_path' => 'required|file|mimes:pdf|max:5120',
            'purpose' => 'required|string'
        ]);

        $room = Room::findOrFail($validated['room_id']);
        if ($validated['participants'] > $room->capacity) {
            return back()->withErrors([
                'participants' => "Jumlah peserta melebihi kapasitas ruangan ({$room->capacity} orang)."
            ])->withInput();
        }

        $isBooked = Booking::where('room_id', $validated['room_id'])
            ->where('date', $validated['date'])
            ->where('status', '!=', 'ditolak')
            ->where(function($query) use ($validated) {
                $query->whereBetween('start_time', [$validated['start_time'], $validated['end_time']])
                      ->orWhereBetween('end_time', [$validated['start_time'], $validated['end_time']])
                      ->orWhere(function($q) use ($validated) {
                          $q->where('start_time', '<=', $validated['start_time'])
                            ->where('end_time', '>=', $validated['end_time']);
                      });
            })->exists();

        if ($isBooked) {
            return back()->withErrors(['room_id' => 'Maaf, ruangan ini sudah terpesan pada jam tersebut. Silakan pilih waktu lain.'])->withInput();
        }

        $filePath = $request->file('document_path')->store('documents', 'public');
        $validated['document_path'] = $filePath;

        $room = Room::find($validated['room_id']);

        return view('user.ajukan-konfirmasi', compact('validated', 'room'));
    }

    public function ajukanProses(Request $request)
    {
        $reqId = 'REQ-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -4));

        $booking = Booking::create([
            'req_id' => $reqId,
            'user_id' => Auth::id(),
            'room_id' => $request->room_id,
            'date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'activity_name' => $request->activity_name,
            'activity_type' => $request->activity_type,
            'participants' => $request->participants,
            'document_path' => $request->document_path,
        ]);

        $booking->status = 'menunggu';
        $booking->save();

        return redirect('/user/riwayat')->with('success', 'Permohonan dan dokumen berhasil diajukan!');
    }
}
