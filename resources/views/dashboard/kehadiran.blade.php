@extends('layouts.app') {{-- Pastikan ini mengarah ke layout utama Anda --}}

@section('title', 'Dashboard - Kehadiran')

@section('content')

    {{-- Notifikasi (Penting untuk user setelah scan) --}}
    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg" role="alert">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="mb-4 p-4 bg-red-100 text-red-800 rounded-lg" role="alert">
            {{ session('error') }}
        </div>
    @endif
    @if (session('warning'))
        <div class="mb-4 p-4 bg-yellow-100 text-yellow-800 rounded-lg" role="alert">
            {{ session('warning') }}
        </div>
    @endif

    {{-- Cek jika role user adalah 'Anggota' --}}
    @if(auth()->user()->role == 'Anggota')

        {{-- ======================== --}}
        {{--      TAMPILAN ANGGOTA    --}}
        {{-- ======================== --}}
        <section id="content-scan-kehadiran">
            <h1 class="text-3xl font-bold text-slate-800 mb-6">Scan Kehadiran</h1>
            <div class="bg-white p-6 rounded-xl shadow-md border border-gray-100">
                <div class="flex flex-col items-center justify-center max-w-lg mx-auto text-center">
                    <h2 class="text-xl font-bold text-slate-700 mb-4">Absensi QR Code</h2>
                    <p class="text-gray-500 mb-6">Pindai QR Code yang disediakan oleh admin untuk mencatat kehadiran Anda. Pastikan GPS Anda aktif.</p>
                    
                    {{-- Placeholder untuk Video QR Scanner --}}
                    <div id="qr-reader" class="w-full max-w-xs sm:max-w-sm border-4 border-dashed border-gray-300 rounded-lg overflow-hidden" style="width: 300px; height: 300px;"></div>
                    
                    <button id="start-scan-btn" class="mt-6 bg-blue-600 text-white font-bold py-2 px-4 rounded-lg flex items-center gap-2 hover:bg-blue-700 transition-colors">
                        <span class="material-symbols-outlined">qr_code_scanner</span> Mulai Scan
                    </button>

                    <div id="qr-scan-result" class="mt-4 text-sm font-medium"></div>

                    {{-- Form untuk mengirim hasil scan ke rute 'kehadiran.store.scan' --}}
                    <form id="scan-form" action="{{ route('kehadiran.store.scan') }}" method="POST" class="hidden">
                        @csrf
                        <input type="hidden" name="qr_data" id="qr_data_input">
                        <input type="hidden" name="latitude" id="user_latitude">
                        <input type="hidden" name="longitude" id="user_longitude">
                    </form>
                </div>
            </div>
        </section>

    @else 

        {{-- ======================== --}}
        {{-- TAMPILAN ADMIN (Non-Anggota) --}}
        {{-- ======================== --}}
        <section id="content-kehadiran">
            <h1 class="text-3xl font-bold text-slate-800 mb-6">Kehadiran</h1>
            <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-4 mb-6">
                <div>
                    <h2 class="text-xl font-bold text-slate-700">Kehadiran</h2>
                    <p class="text-gray-500">Buat QR Code dan pantau kehadiran anggota.</p>
                </div>
                {{-- Tombol ini hanya muncul untuk admin --}}
                <button id="buat-qr-btn" class="bg-blue-600 text-white font-bold py-2 px-4 rounded-lg flex items-center justify-center gap-2 hover:bg-blue-700 transition-colors w-full sm:w-auto">
                    <span class="material-symbols-outlined">qr_code_2</span> Buat QR Code
                </button>
            </div>
            
            <div class="relative mb-6">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">search</span>
                <input type="text" id="kehadiran-search-input" placeholder="Cari Akun...." class="w-full py-3 pl-10 pr-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="bg-white p-6 rounded-xl shadow-md border border-gray-100 overflow-x-auto">
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <h3 class="text-lg font-bold text-slate-800">
                            Kehadiran anggota 
                            @if($sesiInfo ?? null)
                                ({{ $sesiInfo['event'] }})
                            @endif
                        </h3>
                        <p class="text-sm text-gray-500">
                            @if($sesiInfo ?? null)
                                Daftar Kehadiran untuk tanggal {{ $sesiInfo['tanggal'] }}
                            @else
                                Belum ada sesi kehadiran yang dibuat.
                            @endif
                        </p>
                    </div>
                    <button class="border border-gray-300 text-gray-700 font-semibold py-2 px-4 rounded-lg flex items-center gap-2 hover:bg-gray-50 transition-colors">
                        <span class="material-symbols-outlined">download</span> Export
                    </button>
                </div>
                
                <table class="w-full text-left min-w-[640px]">
                    <thead class="border-b border-gray-200 text-sm text-gray-600">
                        <tr>
                            <th class="py-3 px-4 font-semibold">Pengguna</th>
                            <th class="py-3 px-4 font-semibold">Departemen</th>
                            <th class="py-3 px-4 font-semibold">Waktu</th>
                            <th class="py-3 px-4 font-semibold">Status</th>
                            <th class="py-3 px-4 font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="kehadiran-list">
                        {{-- Data kehadiran akan dirender oleh JavaScript --}}
                    </tbody>
                </table>
            </div>
        </section>

        {{-- Modal untuk Generate QR Code (Admin) --}}
        <div id="qr-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
            <div class="bg-white p-6 rounded-lg shadow-xl w-full max-w-md">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold">Buat QR Code Kehadiran</h3>
                    <button id="close-qr-modal" class="text-gray-500 hover:text-gray-800 text-3xl">&times;</button>
                </div>
                
                {{-- Form untuk generate QR. Aksi ke rute 'kehadiran.generate' --}}
                <form id="qr-generate-form" action="{{ route('kehadiran.generate') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="qr-event" class="block text-sm font-medium text-gray-700 mb-1">Nama Acara/Keperluan</label>
                        <input type="text" id="qr-event" name="event_name" class="w-full border border-gray-300 rounded-lg px-3 py-2" placeholder="Contoh: Rapat Bulanan" required>
                    </div>
                    <div class="mb-4">
                        <label for="qr-radius" class="block text-sm font-medium text-gray-700 mb-1">Radius Valid (meter)</label>
                        <input type="number" id="qr-radius" name="radius" class="w-full border border-gray-300 rounded-lg px-3 py-2" value="50" required>
                        <p class="text-xs text-gray-500 mt-1">Geolocation Anda akan diambil saat menekan "Generate".</p>
                    </div>
                    
                    {{-- Input tersembunyi untuk data geolokasi --}}
                    <input type="hidden" name="latitude" id="admin_latitude">
                    <input type="hidden" name="longitude" id="admin_longitude">

                    <div class="flex justify-end gap-3 pt-4">
                        <button type="button" id="cancel-qr-btn" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">Batal</button>
                        <button type="submit" id="submit-qr-btn" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition flex items-center gap-2">
                            <span id="qr-btn-text">Generate</span>
                            <span id="qr-btn-spinner" class="hidden w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></span>
                        </button>
                    </div>
                </form>
                
                {{-- Area untuk menampilkan QR code setelah di-generate --}}
                <div id="qrcode-display" class="mt-6 hidden text-center">
                    <h4 class="font-semibold mb-2 text-green-700">QR Code Berhasil Dibuat!</h4>
                    <div id="qrcode-container" class="flex justify-center p-4 border border-gray-200 rounded-lg">
                        {{-- QR code (dari server) akan ditampilkan di sini --}}
                    </div>
                    <p class="text-sm text-gray-600 mt-2">Silakan perlihatkan QR Code ini untuk di-scan.</p>
                </div>
            </div>
        </div>

    @endif
@endsection

@push('scripts')
    {{-- Script hanya di-load berdasarkan role --}}
    
    @if(auth()->user()->role == 'Anggota')
        {{-- SCRIPT UNTUK ANGGOTA --}}
        <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
        
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const startScanBtn = document.getElementById('start-scan-btn');
            const scanResultEl = document.getElementById('qr-scan-result');
            const scanForm = document.getElementById('scan-form');
            const qrDataInput = document.getElementById('qr_data_input');
            const latitudeInput = document.getElementById('user_latitude');
            const longitudeInput = document.getElementById('user_longitude');
            let html5QrCode;

            function onScanSuccess(decodedText, decodedResult) {
                scanResultEl.textContent = '✅ Scan Berhasil! Mendapatkan lokasi...';
                scanResultEl.className = 'mt-4 text-sm font-medium text-green-600';

                html5QrCode.stop().catch(err => console.error('Gagal stop scanner.', err));

                navigator.geolocation.getCurrentPosition(position => {
                    scanResultEl.textContent = '✅ Lokasi didapat! Mengirim data...';
                    qrDataInput.value = decodedText; // Data dari QR (token)
                    latitudeInput.value = position.coords.latitude;
                    longitudeInput.value = position.coords.longitude;
                    scanForm.submit();
                }, (error) => {
                    scanResultEl.textContent = '❌ Gagal mendapatkan lokasi: ' + error.message;
                    scanResultEl.className = 'mt-4 text-sm font-medium text-red-600';
                    startScanBtn.classList.remove('hidden'); 
                });
            }

            function onScanFailure(error) { /* Biarkan */ }

            if (startScanBtn) {
                startScanBtn.addEventListener('click', () => {
                    scanResultEl.textContent = 'Menyalakan kamera...';
                    scanResultEl.className = 'mt-4 text-sm font-medium text-gray-600';
                    startScanBtn.classList.add('hidden'); 

                    html5QrCode = new Html5Qrcode("qr-reader");
                    
                    html5QrCode.start(
                        { facingMode: "environment" }, 
                        { fps: 10, qrbox: { width: 250, height: 250 } },
                        onScanSuccess,
                        onScanFailure
                    ).catch(err => {
                        scanResultEl.textContent = '❌ Gagal memulai scanner: Izin kamera ditolak atau tidak ditemukan.';
                        scanResultEl.className = 'mt-4 text-sm font-medium text-red-600';
                        startScanBtn.classList.remove('hidden');
                    });
                });
            }
        });
        </script>

    @else
        {{-- SCRIPT UNTUK ADMIN (Non-Anggota) --}}
        <script src="https://cdn.jsdelivr.net/npm/qrcode-generator/qrcode.js"></script>
        
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const kehadiranData = @json($kehadiranData ?? []);
            const kehadiranListBody = document.getElementById('kehadiran-list');
            const searchInput = document.getElementById('kehadiran-search-input');

            const getStatusBadge = (status) => {
                if (status === 'Hadir') return 'bg-green-100 text-green-800';
                if (status === 'Tidak Valid') return 'bg-yellow-100 text-yellow-800';
                return 'bg-gray-100 text-gray-800';
            };

            function renderKehadiran(dataToRender) {
                if (!kehadiranListBody) return;
                kehadiranListBody.innerHTML = '';
                if (dataToRender.length === 0) {
                    kehadiranListBody.innerHTML = `<tr><td colspan="5" class="text-center text-gray-500 py-4">Belum ada data kehadiran.</td></tr>`;
                    return;
                }
                dataToRender.forEach(item => {
                    const badgeClass = getStatusBadge(item.status);
                    // Perhatikan: item.nama, item.nim, item.departemen
                    kehadiranListBody.innerHTML += `
                        <tr class="border-b border-gray-100 hover:bg-gray-50">
                            <td class="py-3 px-4">
                                <div class="flex items-center gap-3">
                                    <span class="material-symbols-outlined bg-blue-100 text-blue-600 p-2 rounded-full">person</span>
                                    <div>
                                        <p class="font-semibold text-slate-800">${item.nama}</p>
                                        <p class="text-sm text-gray-500">${item.nim}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 px-4 text-gray-600">${item.departemen}</td>
                            <td class="py-3 px-4 text-gray-600">${item.waktu}</td>
                            <td class="py-3 px-4">
                                <span class="text-xs font-semibold px-2.5 py-1 rounded-full ${badgeClass}">${item.status}</span>
                            </td>
                            <td class="py-3 px-4">
                                <button class="text-gray-500 hover:text-blue-600"><span class="material-symbols-outlined">edit</span></button>
                            </td>
                        </tr>
                    `;
                });
            }

            if(searchInput) {
                searchInput.addEventListener('input', () => {
                    const searchTerm = searchInput.value.toLowerCase().trim();
                    const filteredData = kehadiranData.filter(item => 
                        item.nama.toLowerCase().includes(searchTerm) ||
                        item.nim.toLowerCase().includes(searchTerm)
                    );
                    renderKehadiran(filteredData);
                });
            }
            renderKehadiran(kehadiranData); // Initial render

            // --- QR Modal Logic ---
            const qrModal = document.getElementById('qr-modal');
            const openQrBtn = document.getElementById('buat-qr-btn');
            const closeQrBtn = document.getElementById('close-qr-modal');
            const cancelQrBtn = document.getElementById('cancel-qr-btn');
            const qrForm = document.getElementById('qr-generate-form');
            const qrDisplay = document.getElementById('qrcode-display');
            const qrContainer = document.getElementById('qrcode-container');
            const submitQrBtn = document.getElementById('submit-qr-btn');
            const qrBtnText = document.getElementById('qr-btn-text');
            const qrBtnSpinner = document.getElementById('qr-btn-spinner');

            if (qrModal) {
                openQrBtn.addEventListener('click', () => qrModal.classList.remove('hidden'));
                const hideModal = () => qrModal.classList.add('hidden');
                closeQrBtn.addEventListener('click', hideModal);
                cancelQrBtn.addEventListener('click', hideModal);
                qrModal.addEventListener('click', e => { if(e.target === qrModal) hideModal(); });

                qrForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    qrBtnText.classList.add('hidden');
                    qrBtnSpinner.classList.remove('hidden');
                    submitQrBtn.disabled = true;

                    navigator.geolocation.getCurrentPosition(position => {
                        document.getElementById('admin_latitude').value = position.coords.latitude;
                        document.getElementById('admin_longitude').value = position.coords.longitude;

                        fetch(qrForm.action, {
                            method: 'POST',
                            body: new FormData(qrForm),
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if(data.success && data.qrData) {
                                qrContainer.innerHTML = '';
                                const qr = qrcode(0, 'L');
                                qr.addData(data.qrData); // data.qrData adalah token
                                qr.make();
                                qrContainer.innerHTML = qr.createImgTag(6, 8);
                                qrDisplay.classList.remove('hidden');
                            } else {
                                alert('Gagal membuat QR Code: ' + (data.message || 'Error'));
                            }
                        })
                        .catch(error => alert('Terjadi error: ' + error.message))
                        .finally(() => {
                            qrBtnText.classList.remove('hidden');
                            qrBtnSpinner.classList.add('hidden');
                            submitQrBtn.disabled = false;
                        });

                    }, (error) => {
                        alert('Error lokasi: ' + error.message + '. Pastikan GPS aktif.');
                        qrBtnText.classList.remove('hidden');
                        qrBtnSpinner.classList.add('hidden');
                        submitQrBtn.disabled = false;
                    });
                });
            }
        });
        </script>
    @endif
@endpush