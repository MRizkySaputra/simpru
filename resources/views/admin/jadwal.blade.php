@extends('layouts.admin')

@section('title', 'Jadwal Ruangan')

@section('content')

    {{-- Header & View Switcher --}}
    <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 mb-8">
        <div>
            <h2 class="text-3xl font-headline font-extrabold text-[#002045] mb-2">Jadwal Ruangan</h2>
            <p class="text-slate-500 text-sm">Daftar jadwal peminjaman ruangan yang terdaftar di sistem.</p>
        </div>

        <div class="flex items-center bg-slate-100 p-1 rounded-lg w-full sm:w-auto shadow-inner">
            <button id="btn-bulanan" onclick="switchView('bulanan')" class="flex-1 sm:flex-none px-6 py-2 rounded-md text-sm font-bold transition-all bg-[#002045] text-white shadow-sm">Bulanan</button>
            <button id="btn-mingguan" onclick="switchView('mingguan')" class="flex-1 sm:flex-none px-6 py-2 rounded-md text-sm font-bold text-slate-500 hover:text-[#002045] transition-all">Mingguan</button>
            <button id="btn-harian" onclick="switchView('harian')" class="flex-1 sm:flex-none px-6 py-2 rounded-md text-sm font-bold text-slate-500 hover:text-[#002045] transition-all">Harian</button>
        </div>
    </div>

    {{-- Navigasi Tanggal --}}
    <div class="flex items-center justify-between bg-white p-4 rounded-xl shadow-sm border border-slate-200 mb-6">
        <button onclick="navigateDate(-1)" class="p-2 bg-slate-50 hover:bg-slate-100 rounded-lg text-[#002045] transition-colors border border-slate-200 active:scale-95">
            <span class="material-symbols-outlined">chevron_left</span>
        </button>
        <div class="text-center">
            <h3 id="current-label" class="text-lg font-extrabold text-[#002045] transition-all">Memuat Tanggal...</h3>
        </div>
        <button onclick="navigateDate(1)" class="p-2 bg-slate-50 hover:bg-slate-100 rounded-lg text-[#002045] transition-colors border border-slate-200 active:scale-95">
            <span class="material-symbols-outlined">chevron_right</span>
        </button>
    </div>

    {{-- Filter Bar & Legenda --}}
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4 mb-6 flex flex-col xl:flex-row xl:items-center justify-between gap-4 transition-all">
        
        <div class="flex flex-wrap items-center gap-4 px-2 shrink-0">
            <div class="flex items-center gap-1.5"><div class="w-3 h-3 rounded-full bg-slate-300"></div><span class="text-[10px] font-bold uppercase tracking-wider text-slate-500">Kosong</span></div>
            <div class="flex items-center gap-1.5"><div class="w-3 h-3 rounded-full bg-amber-400"></div><span class="text-[10px] font-bold uppercase tracking-wider text-slate-500">Menunggu</span></div>
            <div class="flex items-center gap-1.5"><div class="w-3 h-3 rounded-full bg-emerald-500"></div><span class="text-[10px] font-bold uppercase tracking-wider text-slate-500">Disetujui</span></div>
        </div>

        <div id="filter-inputs" class="flex flex-wrap items-center gap-3 w-full xl:w-auto">
            <select id="filterGedung" onchange="applyFilter()" class="flex-1 min-w-[120px] bg-slate-50 border border-slate-200 rounded-lg py-2 px-3 text-sm font-medium focus:ring-2 focus:ring-[#002045]/20 outline-none">
                <option value="">Semua Gedung</option>
                <option value="A">Gedung A</option>
                <option value="B">Gedung B</option>
                <option value="C">Gedung C</option>
            </select>
            <select id="filterRuangan" onchange="applyFilter()" class="flex-1 min-w-[140px] bg-slate-50 border border-slate-200 rounded-lg py-2 px-3 text-sm font-medium focus:ring-2 focus:ring-[#002045]/20 outline-none">
                <option value="">Semua Ruangan</option>
                @foreach($rooms as $r)
                    <option value="{{ $r['code'] }}" data-gedung="{{ $r['gedung'] }}">{{ $r['name'] }}</option>
                @endforeach
            </select>
            <input id="filterTanggal" class="flex-1 min-w-[130px] bg-slate-50 border border-slate-200 rounded-lg py-2 px-3 text-sm font-medium focus:ring-2 focus:ring-[#002045]/20 outline-none" type="date">
        </div>
    </div>

    @php
        // KONFIGURASI STATUS DIPERBAIKI
        $statusConfig = [
            'available' => ['bg' => 'bg-slate-100', 'hover' => 'hover:bg-slate-200', 'text' => '', 'border' => 'border-slate-200', 'dot' => 'bg-slate-300', 'label' => ''],
            'menunggu'  => ['bg' => 'bg-amber-50',  'hover' => 'hover:bg-amber-100', 'text' => 'text-amber-800', 'border' => 'border-amber-200', 'dot' => 'bg-amber-400', 'label' => 'Menunggu'],
            'disetujui' => ['bg' => 'bg-emerald-50','hover' => 'hover:bg-emerald-100','text' => 'text-emerald-800','border' => 'border-emerald-200', 'dot' => 'bg-emerald-500', 'label' => 'Disetujui'],
        ];
    @endphp

    <div class="relative">
        {{-- VIEW BULANAN --}}
        <div id="view-bulanan" class="transition-all duration-300">
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden mb-6">
                <div class="grid grid-cols-7 border-b border-slate-200 bg-slate-50">
                    @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $day)
                    <div class="p-3 text-center border-r border-slate-200 last:border-0">
                        <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">{{ $day }}</span>
                    </div>
                    @endforeach
                </div>
                <div id="calendar-grid" class="grid grid-cols-7"></div>
            </div>
        </div>

        {{-- VIEW MINGGUAN --}}
        <div id="view-mingguan" class="hidden transition-all duration-300">
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden mb-6">
                <div class="overflow-x-hidden">
                    <div id="view-mingguan-inner" class="w-full relative bg-white"></div>
                </div>
            </div>
        </div>

        {{-- VIEW HARIAN --}}
        <div id="view-harian" class="hidden transition-all duration-300">
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden mb-6">
                <div class="overflow-x-auto" id="calendarScroll">
                    <div id="calendarInner" class="min-w-max"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- Footer Info --}}
    <div class="px-6 py-4 bg-slate-50 border border-slate-200 rounded-xl flex items-center justify-between mb-6 shadow-sm">
        <p class="text-xs text-slate-500 font-medium">
            Menampilkan <span class="font-bold text-slate-700" id="roomCount">{{ count($rooms) }}</span> ruangan •
            <span id="footerDate"></span>
        </p>
    </div>

    {{-- Pop up Detail & Aksi Pengajuan (ADMIN VERSION) --}}
    <div id="slotPopup" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-[#002045]/40 backdrop-blur-sm" onclick="closePopup(event)">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md mx-4 overflow-hidden" onclick="event.stopPropagation()">

            {{-- Gambar Ruangan --}}
            <div class="relative h-48">
                <img id="popupImg" src="" alt="Ruangan" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-[#002045]/80 via-transparent to-transparent"></div>
                <button onclick="closePopupBtn()" class="absolute top-3 right-3 w-8 h-8 bg-white/20 hover:bg-white/40 rounded-full flex items-center justify-center text-white transition-colors backdrop-blur-sm">
                    <span class="material-symbols-outlined text-sm">close</span>
                </button>
                <div id="popupStatusBadge" class="absolute top-3 left-3 px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider"></div>
                <div class="absolute bottom-4 left-4">
                    <h3 id="popupRoomName" class="text-lg font-bold text-white font-headline"></h3>
                    <p id="popupBuilding" class="text-xs text-white/80 mt-0.5"></p>
                </div>
            </div>

            {{-- Info --}}
            <div class="p-6">
                <div class="grid grid-cols-2 gap-4 mb-5">
                    <div class="bg-slate-50 rounded-lg p-3 border border-slate-100">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Kapasitas</p>
                        <div class="flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-slate-500 text-sm">group</span>
                            <p id="popupCapacity" class="text-sm font-bold text-slate-800"></p>
                        </div>
                    </div>
                    <div class="bg-slate-50 rounded-lg p-3 border border-slate-100">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widests mb-1">Waktu</p>
                        <div class="flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-slate-500 text-sm">schedule</span>
                            <p id="popupTime" class="text-sm font-bold text-slate-800"></p>
                        </div>
                    </div>
                </div>

                <p id="popupDesc" class="text-xs text-slate-500 leading-relaxed mb-5"></p>

                {{-- Aksi Tersedia (Hanya Info Kosong untuk Admin) --}}
                <div id="popupActionAvailable" class="hidden">
                    <p class="text-xs text-slate-500 bg-slate-50 border border-slate-200 rounded-lg px-3 py-3 mb-4 text-center">
                        Ruangan ini kosong dan tersedia untuk dipinjam.
                    </p>
                    <button onclick="closePopupBtn()" class="w-full py-2.5 border border-slate-200 rounded-lg text-sm font-bold text-slate-600 hover:bg-slate-50">
                        Tutup
                    </button>
                </div>

                {{-- Aksi Terisi (Alert & Detail Pemesan) --}}
                <div id="popupActionBooked" class="hidden">
                    {{-- Alert Box (Dinamis dari JS) --}}
                    <div id="popupBookedAlert" class="mb-4 p-3 rounded-lg flex items-start gap-2 border">
                        <span id="popupAlertIcon" class="material-symbols-outlined text-sm mt-0.5"></span>
                        <p id="popupAlertText" class="text-xs font-medium"></p>
                    </div>

                    <div id="popupBookedInfo" class="bg-slate-50 border border-slate-200 rounded-lg p-4 mb-4">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widests mb-1">Dipesan oleh</p>
                        <p id="popupBooker" class="text-sm font-bold text-[#002045]"></p>
                        <p id="popupPurpose" class="text-xs text-slate-500 mt-0.5"></p>
                    </div>
                    
                    <div class="flex gap-3">
                        <button onclick="closePopupBtn()" class="flex-1 py-2.5 border border-slate-200 rounded-lg text-sm font-bold text-slate-600 hover:bg-slate-50">
                            Tutup
                        </button>
                        <a href="/admin/permohonan" class="flex-1 py-2.5 bg-[#002045] text-white rounded-lg text-sm font-bold text-center hover:opacity-95 flex items-center justify-center gap-2">
                            Lihat Berkas <span class="material-symbols-outlined text-sm">visibility</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    let currentView = 'bulanan'; 
    let currentDate = new Date();

    const days = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
    const months = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];

    const roomsData = @json($rooms);
    const allEventsConfig = @json($bookingsList);
    const statusConfig = @json($statusConfig);
    const hours = [7,8,9,10,11,12,13,14,15,16,17,18,19,20];

    // Memformat status menjadi lowercase agar matching dengan config
    const allEvents = allEventsConfig.map(e => ({
        ...e,
        status: e.status.trim().toLowerCase()
    }));

    function formatDateLabel(d) { return `${days[d.getDay()]}, ${d.getDate()} ${months[d.getMonth()]} ${d.getFullYear()}`; }
    function padDate(n) { return n.toString().padStart(2,'0'); }
    function toInputVal(d) { return `${d.getFullYear()}-${padDate(d.getMonth()+1)}-${padDate(d.getDate())}`; }

    function updateDateUI() {
        document.getElementById('filterTanggal').value = toInputVal(currentDate);
        document.getElementById('footerDate').textContent = formatDateLabel(currentDate);
        const label = document.getElementById('current-label');

        if (currentView === 'bulanan') {
            label.innerText = `${months[currentDate.getMonth()]} ${currentDate.getFullYear()}`;
        } else if (currentView === 'mingguan') {
            const startOfWeek = new Date(currentDate);
            let dayIndex = startOfWeek.getDay() || 7; 
            startOfWeek.setDate(startOfWeek.getDate() - dayIndex + 1); 
            const endOfWeek = new Date(startOfWeek);
            endOfWeek.setDate(startOfWeek.getDate() + 6); 
            label.innerText = `${startOfWeek.getDate()} - ${endOfWeek.getDate()} ${months[currentDate.getMonth()]} ${currentDate.getFullYear()}`;
        } else {
            label.innerText = formatDateLabel(currentDate);
        }
    }

    function jumpToDate(y, m, d) {
        currentDate = new Date(y, m, d, 0, 0, 0);
        switchView('harian');
        window.scrollTo({ top: 150, behavior: 'smooth' }); 
    }

    function jumpToWeeklyDay(dayIndex) { 
        let d = new Date(currentDate);
        let currentDay = d.getDay() || 7; 
        d.setDate(d.getDate() - currentDay + 1 + dayIndex); 
        jumpToDate(d.getFullYear(), d.getMonth(), d.getDate());
    }

    function navigateDate(step) {
        if (currentView === 'bulanan') currentDate.setMonth(currentDate.getMonth() + step);
        else if (currentView === 'mingguan') currentDate.setDate(currentDate.getDate() + (step * 7));
        else currentDate.setDate(currentDate.getDate() + step);
        
        updateDateUI();
        renderAllViews();
    }

    document.getElementById('filterTanggal').addEventListener('change', function() {
        currentDate = new Date(this.value + 'T00:00:00');
        updateDateUI();
        renderAllViews();
    });

    function switchView(view) {
        currentView = view;
        ['bulanan', 'mingguan', 'harian'].forEach(v => {
            const btn = document.getElementById(`btn-${v}`);
            const pane = document.getElementById(`view-${v}`);
            if (v === view) {
                btn.className = 'flex-1 sm:flex-none px-6 py-2 rounded-md text-sm font-bold transition-all bg-[#002045] text-white shadow-sm';
                pane.classList.remove('hidden');
            } else {
                btn.className = 'flex-1 sm:flex-none px-6 py-2 rounded-md text-sm font-bold text-slate-500 hover:text-[#002045] transition-all';
                pane.classList.add('hidden');
            }
        });

        const filterInputs = document.getElementById('filter-inputs');
        if (view === 'bulanan') {
            filterInputs.classList.add('hidden'); filterInputs.classList.remove('flex');
        } else {
            filterInputs.classList.remove('hidden'); filterInputs.classList.add('flex');
        }

        updateDateUI();
        renderAllViews();
    }

    function renderAllViews() {
        if(currentView === 'bulanan') renderMonthlyCalendar();
        if(currentView === 'mingguan') renderWeeklyCalendar();
        if(currentView === 'harian') renderDailyCalendar();
        applyFilter();
    }

    function renderDailyCalendar() {
        const container = document.getElementById('calendarInner');
        let dateStr = toInputVal(currentDate);

        let html = `<div class="flex border-b border-slate-200 bg-slate-50 sticky top-0 z-20 shadow-sm">
            <div class="w-20 shrink-0 px-3 py-4 border-r border-slate-200 bg-slate-50 flex items-center justify-center">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widests">Jam</span>
            </div>`;
        roomsData.forEach(room => {
            html += `<div class="room-col flex-1 min-w-[160px] px-3 py-3 border-r border-slate-200 last:border-r-0 bg-slate-50 text-center"
                          data-code="${room.code}" data-gedung="${room.gedung}">
                        <p class="text-xs font-extrabold text-[#002045] truncate">${room.name}</p>
                        <p class="text-[10px] text-slate-400 font-medium mt-0.5">${room.building} • ${room.code}</p>
                    </div>`;
        });
        html += `</div><div class="max-h-[600px] overflow-y-auto bg-slate-50">`;

        hours.forEach(h => {
            html += `<div class="flex border-b border-slate-100 last:border-b-0 hover:bg-slate-50/30 transition-colors h-auto min-h-[56px]">
                        <div class="w-20 shrink-0 px-3 border-r border-slate-200 flex items-center justify-end bg-white">
                            <span class="text-[11px] font-bold text-slate-400">${padDate(h)}:00</span>
                        </div>`;
            roomsData.forEach(room => {
                let slotEvent = allEvents.find(e => e.dateStr === dateStr && e.roomCode === room.code && h >= e.startHour && h < e.endHour);
                let cfg = slotEvent ? (statusConfig[slotEvent.status] || statusConfig['menunggu']) : statusConfig['available'];
                
                html += `<div class="room-col flex-1 min-w-[160px] border-r border-slate-100 last:border-r-0 p-1 group relative bg-white" data-code="${room.code}" data-gedung="${room.gedung}">`;
                if(slotEvent) {
                    html += `<div class="w-full h-14 rounded-lg ${cfg.bg} border ${cfg.border} px-2 py-1 relative overflow-hidden group/item cursor-pointer"
                                  onclick="showBookingInfo('${room.code}', ${h}, '${room.name}', '${room.building}', ${room.capacity}, '${room.img}', '${room.desc}', '${slotEvent.status}', '${slotEvent.booker}', '${slotEvent.title}')">
                                <div class="absolute left-0 top-0 bottom-0 w-1 rounded-l-lg ${cfg.dot}"></div>
                                <div class="pl-2">
                                    <div class="flex items-center gap-1 mb-0.5">
                                        <span class="w-1.5 h-1.5 rounded-full ${cfg.dot} shrink-0"></span>
                                        <span class="text-[9px] font-bold uppercase tracking-wider ${cfg.text}">${cfg.label}</span>
                                    </div>
                                    <p class="text-[10px] font-bold text-slate-700 truncate leading-tight">${slotEvent.title}</p>
                                    <p class="text-[9px] text-slate-500 truncate">${slotEvent.booker}</p>
                                </div>
                            </div>`;
                } else {
                    html += `<div class="w-full h-14 rounded-lg flex items-center justify-center cursor-pointer hover:bg-slate-100 transition-colors"
                                  onclick="selectSlot(this, '${room.code}', ${h}, '${room.name}', '${room.building}', ${room.capacity}, '${room.img}', '${room.desc}')">
                            </div>`;
                }
                html += `</div>`;
            });
            html += `</div>`;
        });
        html += `</div>`;
        container.innerHTML = html;
    }

    function renderWeeklyCalendar() {
        const container = document.getElementById('view-mingguan-inner');
        const startOfWeek = new Date(currentDate);
        let currentDayIndex = startOfWeek.getDay() || 7; 
        startOfWeek.setDate(startOfWeek.getDate() - currentDayIndex + 1);

        let html = `<div class="w-full">
            <div class="flex border-b border-slate-200 bg-slate-50 sticky top-0 z-20 shadow-sm w-full">
                <div class="w-[60px] md:w-20 shrink-0 px-1 py-4 border-r border-slate-200 bg-slate-50 flex items-center justify-center">
                    <span class="text-[9px] md:text-[10px] font-bold text-slate-400 uppercase tracking-widests">Jam</span>
                </div>`;
        
        for(let i=0; i<7; i++) {
            let d = new Date(startOfWeek); d.setDate(d.getDate() + i);
            html += `<div class="flex-1 w-0 px-1 lg:px-3 py-3 border-r border-slate-200 last:border-r-0 bg-slate-50 text-center cursor-pointer hover:bg-slate-200 transition-colors" onclick="jumpToWeeklyDay(${i})">
                    <p class="text-[9px] md:text-xs font-extrabold text-[#002045] hover:underline truncate">${days[d.getDay() === 0 ? 0 : d.getDay()]}</p>
                    <p class="text-[8px] md:text-[10px] text-slate-400 font-medium mt-0.5">${d.getDate()} ${months[d.getMonth()].substring(0,3)}</p>
                </div>`;
        }
        
        html += `</div><div class="max-h-[600px] overflow-y-auto relative bg-slate-50 w-full">`;
        hours.forEach(h => {
            html += `<div class="flex border-b border-slate-100 last:border-b-0 hover:bg-slate-50/30 transition-colors h-auto min-h-[56px] w-full">
                        <div class="w-[60px] md:w-20 shrink-0 px-1 border-r border-slate-200 flex items-center justify-center bg-white">
                            <span class="text-[9px] md:text-[11px] font-bold text-slate-400">${padDate(h)}:00</span>
                        </div>`;
            
            for(let d=0; d<7; d++) {
                let colDate = new Date(startOfWeek); colDate.setDate(colDate.getDate() + d);
                let colDateStr = toInputVal(colDate);
                let dayEvents = allEvents.filter(e => e.dateStr === colDateStr && h >= e.startHour && h < e.endHour);

                html += `<div class="flex-1 w-0 border-r border-slate-100 last:border-r-0 p-1 bg-white relative group cursor-pointer hover:bg-slate-50 transition-colors" onclick="jumpToWeeklyDay(${d})">`;
                if(dayEvents.length > 0) {
                    html += `<div class="flex flex-col gap-1 w-full h-full">`;
                    dayEvents.forEach(e => {
                        let cfg = statusConfig[e.status] || statusConfig['menunggu'];
                        html += `
                            <div class="weekly-event-item w-full min-h-[46px] h-full rounded-lg ${cfg.bg} border ${cfg.border} px-1.5 md:px-2 py-1 relative overflow-hidden group/item cursor-pointer hover:opacity-80" data-code="${e.roomCode}" data-gedung="${e.gedung}" onclick="showBookingInfo('${e.roomCode}', ${h}, '${e.roomName}', '${e.gedung}', ${e.capacity}, '${e.img}', '${e.desc}', '${e.status}', '${e.booker}', '${e.title}'); event.stopPropagation();">
                                <div class="absolute left-0 top-0 bottom-0 w-1 rounded-l-lg ${cfg.dot}"></div>
                                <div class="pl-1.5 md:pl-2">
                                    <p class="text-[8px] md:text-[10px] font-bold text-slate-700 truncate leading-tight">${e.title}</p>
                                    <p class="text-[7px] md:text-[9px] text-slate-500 truncate">${e.roomName}</p>
                                </div>
                            </div>`;
                    });
                    html += `</div>`;
                }
                html += `</div>`;
            }
            html += `</div>`;
        });
        html += `</div></div>`;
        container.innerHTML = html;
    }

    function renderMonthlyCalendar() {
        const grid = document.getElementById('calendar-grid'); grid.innerHTML = '';
        let startOfMonth = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1);
        let startDay = startOfMonth.getDay() || 7; 
        let daysInMonth = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 0).getDate();
        
        let dateCounter = 1;
        let todayStr = toInputVal(new Date());

        for (let i = 1; i <= 35; i++) {
            let isCurrentMonth = (i >= startDay && dateCounter <= daysInMonth);
            let actualDate = isCurrentMonth ? dateCounter++ : '';
            let dateStr = isCurrentMonth ? toInputVal(new Date(currentDate.getFullYear(), currentDate.getMonth(), actualDate)) : '';
            let isToday = (dateStr === todayStr); 

            let div = document.createElement('div');
            div.className = `min-h-[120px] p-2 border-b border-r border-slate-100 transition-all ${isCurrentMonth ? 'hover:bg-slate-50 cursor-pointer bg-white' : 'bg-slate-50/50'} ${i % 7 === 0 ? 'border-r-0' : ''}`;
            if (isCurrentMonth) div.setAttribute('onclick', `jumpToDate(${currentDate.getFullYear()}, ${currentDate.getMonth()}, ${actualDate})`);

            let html = '';
            if (actualDate) {
                html += `<span class="w-6 h-6 flex items-center justify-center rounded-full text-xs font-bold ${isToday ? 'bg-[#002045] text-white shadow-md' : 'text-slate-500'} mb-2">${actualDate}</span>`;
                let dayEvents = allEvents.filter(e => e.dateStr === dateStr);
                
                dayEvents.sort((a,b) => a.startHour - b.startHour);
                let uniqueEvents = [];
                let seenKeys = new Set();
                dayEvents.forEach(e => {
                    let key = `${e.roomCode}-${e.title}`;
                    if(!seenKeys.has(key)) { seenKeys.add(key); uniqueEvents.push(e); }
                });

                uniqueEvents.forEach(e => {
                    let cfg = statusConfig[e.status] || statusConfig['menunggu'];
                    html += `<div class="monthly-event-item px-2 py-1 ${cfg.bg} ${cfg.text} text-[9px] font-bold rounded mb-1 truncate cursor-pointer hover:opacity-80 transition-opacity" 
                                 title="${e.title}" data-code="${e.roomCode}" data-gedung="${e.gedung}" onclick="showBookingInfo('${e.roomCode}', ${e.startHour}, '${e.roomName}', '${e.gedung}', ${e.capacity}, '${e.img}', '${e.desc}', '${e.status}', '${e.booker}', '${e.title}'); event.stopPropagation();">
                                ${padDate(e.startHour)}:00 - ${e.title}
                             </div>`;
                });
            }
            div.innerHTML = html; grid.appendChild(div);
        }
    }

    function applyFilter() {
        const gedungFilter = document.getElementById('filterGedung').value;
        const ruanganFilter = document.getElementById('filterRuangan').value;

        document.querySelectorAll('#view-harian .room-col').forEach(col => {
            const code = col.dataset.code; const gedung = col.dataset.gedung;
            let show = true;
            if (gedungFilter && gedung !== gedungFilter) show = false;
            if (ruanganFilter && code !== ruanganFilter) show = false;
            col.style.display = show ? '' : 'none';
        });

        document.querySelectorAll('.weekly-event-item, .monthly-event-item').forEach(el => {
            const code = el.dataset.code; const gedung = el.dataset.gedung;
            let show = true;
            if (gedungFilter && gedung !== gedungFilter) show = false;
            if (ruanganFilter && code !== ruanganFilter) show = false;
            el.style.display = show ? '' : 'none';
        });

        const visibleCols = document.querySelectorAll('#view-harian #calendarInner .room-col[data-code]:not([style*="display: none"])');
        document.getElementById('roomCount').textContent = Math.round(visibleCols.length / (hours.length + 1));
    }

    document.getElementById('filterGedung').addEventListener('change', function() {
        const val = this.value; const ruanganSel = document.getElementById('filterRuangan'); ruanganSel.value = '';
        Array.from(ruanganSel.options).forEach(opt => {
            if (!opt.value) return;
            opt.style.display = (!val || opt.dataset.gedung === val) ? '' : 'none';
        });
        applyFilter();
    });

    // --- POPUP LOGIC ---
    let selectedSlotEl = null;

    function openPopup() {
        document.getElementById('slotPopup').classList.remove('hidden');
        document.getElementById('slotPopup').classList.add('flex');
    }

    function closePopupBtn() {
        document.getElementById('slotPopup').classList.add('hidden');
        document.getElementById('slotPopup').classList.remove('flex');
    }

    function closePopup(e) {
        if (e.target === document.getElementById('slotPopup')) closePopupBtn();
    }

    function fillPopupBase(roomCode, hour, roomName, building, capacity, img, desc) {
        document.getElementById('popupImg').src = img || 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?auto=format&fit=crop&w=400&q=80';
        document.getElementById('popupRoomName').textContent = roomName;
        document.getElementById('popupBuilding').textContent = building;
        document.getElementById('popupCapacity').textContent = capacity + ' orang';
        document.getElementById('popupTime').textContent = `${String(hour).padStart(2,'0')}:00 – ${String(hour+1).padStart(2,'0')}:00`;
        document.getElementById('popupDesc').textContent = desc || 'Fasilitas standar tersedia.';
    }

    // Fungsi klik slot kosong
    function selectSlot(el, roomCode, hour, roomName, building, capacity, img, desc) {
        fillPopupBase(roomCode, hour, roomName, building, capacity, img, desc);
        
        document.getElementById('popupStatusBadge').textContent = 'Kosong';
        document.getElementById('popupStatusBadge').className = 'absolute top-3 left-3 px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-slate-500 text-white';

        document.getElementById('popupActionBooked').classList.add('hidden');
        document.getElementById('popupActionAvailable').classList.remove('hidden');
        
        openPopup();
    }

    // Fungsi klik slot terisi
    function showBookingInfo(roomCode, hour, roomName, building, capacity, img, desc, status, booker, purpose) {
        fillPopupBase(roomCode, hour, roomName, building, capacity, img, desc);

        const alertBox = document.getElementById('popupBookedAlert');
        const alertIcon = document.getElementById('popupAlertIcon');
        const alertText = document.getElementById('popupAlertText');

        if (status === 'menunggu') {
            document.getElementById('popupStatusBadge').textContent = 'Menunggu';
            document.getElementById('popupStatusBadge').className = 'absolute top-3 left-3 px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-amber-500 text-white';
            
            alertBox.className = 'mb-4 p-3 rounded-lg flex items-start gap-2 border bg-amber-50 border-amber-200 text-amber-800';
            alertIcon.textContent = 'hourglass_empty';
            alertText.textContent = 'Menunggu persetujuan Admin (Anda). Silakan cek halaman Permohonan.';
        } else {
            document.getElementById('popupStatusBadge').textContent = 'Disetujui';
            document.getElementById('popupStatusBadge').className = 'absolute top-3 left-3 px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-emerald-500 text-white';
            
            alertBox.className = 'mb-4 p-3 rounded-lg flex items-start gap-2 border bg-emerald-50 border-emerald-200 text-emerald-800';
            alertIcon.textContent = 'verified';
            alertText.textContent = 'Ruangan ini sudah disetujui peminjamannya.';
        }

        document.getElementById('popupBooker').textContent = booker || 'Anonim';
        document.getElementById('popupPurpose').textContent = purpose || '-';

        document.getElementById('popupActionAvailable').classList.add('hidden');
        document.getElementById('popupActionBooked').classList.remove('hidden');
        openPopup();
    }

    // Jalankan pertama kali
    updateDateUI();
    renderAllViews();
</script>
@endpush