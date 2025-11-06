@extends('layouts.app')

@section('title', 'Dashboard - Pengumuman')

@section('content')
<div>
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
            <button id="menu-btn" class="md:hidden text-slate-700">
                <span class="material-symbols-outlined text-3xl">menu</span>
            </button>
            <h1 class="text-3xl font-bold text-slate-800">Pengumuman</h1>
        </div>
    </div>

    <section id="content-pengumuman">
        <div id="announcement-list-view">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h2 class="text-xl font-bold text-slate-700">Pengumuman</h2>
                    <p class="text-gray-500">Jangan sampai ketinggalan Kabar !!!</p>
                </div>
                <button id="add-announcement-btn" class="bg-blue-600 text-white font-bold py-2 px-4 rounded-lg flex items-center gap-2 hover:bg-blue-700 transition-colors">
                    <span class="material-symbols-outlined">add</span> Pengumuman Baru
                </button>
            </div>

            <div class="relative mb-6">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">search</span>
                <input type="text" id="search-input" placeholder="Cari Pengumuman...." class="w-full py-3 pl-10 pr-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div id="announcements-list" class="space-y-4">
                @forelse($pengumuman as $item)
                    <article
                        data-id="{{ $item->id }}"
                        data-title="{{ htmlspecialchars($item->title, ENT_QUOTES) }}"
                        data-short="{{ htmlspecialchars($item->short_description, ENT_QUOTES) }}"
                        data-full="{{ htmlspecialchars($item->full_description, ENT_QUOTES) }}"
                        data-day_date="{{ $item->day_date->format('Y-m-d') }}"
                        data-time="{{ $item->time }}"
                        data-location="{{ htmlspecialchars($item->location, ENT_QUOTES) }}"
                        data-closing="{{ htmlspecialchars($item->closing, ENT_QUOTES) }}"
                        class="announcement-card bg-white p-6 rounded-xl shadow-md border border-gray-100 hover:shadow-lg hover:border-blue-200 cursor-pointer transition-all"
                    >
                        <h3 class="font-bold text-lg text-slate-800 pointer-events-none">{{ $item->title }}</h3>
                        <p class="text-gray-600 mt-1 mb-4 pointer-events-none">{!! \Illuminate\Support\Str::limit($item->short_description, 180) !!}</p>
                        <div class="flex justify-between items-center text-sm text-gray-500 border-t pt-4">
                            <span class="pointer-events-none">
                                {{ $item->day_date->format('l, d F Y') }} • {{ \Carbon\Carbon::parse($item->time)->format('H:i') }}
                            </span>
                            <div class="flex gap-4">
                                <button class="edit-btn hover:text-blue-600" data-id="{{ $item->id }}"><span class="material-symbols-outlined">edit</span></button>
                                <form action="{{ route('pengumuman.destroy', $item->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengumuman ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="hover:text-red-600"><span class="material-symbols-outlined">delete</span></button>
                                </form>
                            </div>
                        </div>
                    </article>
                @empty
                    <p class="text-center text-gray-500">Belum ada pengumuman.</p>
                @endforelse
            </div>
        </div>

        <div id="announcement-detail-view" class="hidden">
            <button id="back-to-list-btn" class="flex items-center gap-2 text-blue-600 font-semibold mb-6 hover:underline">
                <span class="material-symbols-outlined">arrow_back</span>
                Kembali
            </button>
            <div id="detail-content" class="bg-white p-8 rounded-xl shadow-md border border-gray-100"></div>
        </div>
    </section>
</div>

{{-- Modal tambah / edit pengumuman --}}
<div id="announcement-modal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden z-50">
    <div class="bg-white p-8 rounded-xl shadow-2xl w-full max-w-lg">
        <h2 id="modal-title" class="text-2xl font-bold text-slate-800 mb-6">Tambah Pengumuman Baru</h2>

        <form id="announcement-form" action="{{ route('pengumuman.store') }}" method="POST">
            @csrf
            <input type="hidden" id="announcement-id" name="id">
            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Judul</label>
                <input type="text" id="title" name="title" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="mb-6">
                <label for="short_description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Singkat (untuk kartu)</label>
                <textarea id="short_description" name="short_description" rows="3" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
            </div>
            <div class="mb-4">
                <label for="day_date" class="block text-sm font-medium text-gray-700 mb-1">Hari/Tanggal</label>
                <input type="date" id="day_date" name="day_date" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="time" class="block text-sm font-medium text-gray-700 mb-1">Waktu</label>
                    <input type="time" id="time" name="time" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Lokasi</label>
                    <input type="text" id="location" name="location" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>
            <div class="mb-6">
                <label for="full_description" class="block text-sm font-medium text-gray-700 mb-1">Isi Pengumuman Lengkap</label>
                <textarea id="full_description" name="full_description" rows="4" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
            </div>
            <div class="mb-6">
                <label for="closing" class="block text-sm font-medium text-gray-700 mb-1">Penutup (cth: Pengurus Himpunan)</label>
                <input type="text" id="closing" name="closing" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="flex justify-end gap-4">
                <button type="button" id="cancel-btn" class="bg-gray-200 text-gray-800 font-bold py-2 px-4 rounded-lg hover:bg-gray-300">Batal</button>
                <button type="submit" id="save-btn" class="bg-blue-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-700">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // DOM
    const listView = document.getElementById('announcement-list-view');
    const detailView = document.getElementById('announcement-detail-view');
    const listContainer = document.getElementById('announcements-list');
    const detailContent = document.getElementById('detail-content');
    const backBtn = document.getElementById('back-to-list-btn');
    const searchInput = document.getElementById('search-input');

    const modal = document.getElementById('announcement-modal');
    const modalTitle = document.getElementById('modal-title');
    const form = document.getElementById('announcement-form');
    const addBtn = document.getElementById('add-announcement-btn');
    const cancelBtn = document.getElementById('cancel-btn');
    const announcementIdInput = document.getElementById('announcement-id');

    // Utility: show/hide
    const showListView = () => { detailView.classList.add('hidden'); listView.classList.remove('hidden'); };
    const showDetailView = () => { listView.classList.add('hidden'); detailView.classList.remove('hidden'); };
    const showModal = () => modal.classList.remove('hidden');
    const hideModal = () => modal.classList.add('hidden');

    function renderDetailFromDataset(el) {
        const ann = {
            id: el.dataset.id,
            title: el.dataset.title,
            short_description: el.dataset.short,
            full_description: el.dataset.full,
            day_date: el.dataset.day_date,
            time: el.dataset.time,
            location: el.dataset.location,
            closing: el.dataset.closing
        };

        detailContent.innerHTML = `
            <h2 class="text-2xl font-bold text-slate-800 mb-2 uppercase">${ann.title}</h2>
            <p class="text-gray-600 mb-6">${ann.short_description}</p>
            <div class="space-y-3 text-gray-700 mb-6">
                <p class="flex items-center gap-3"><span class="material-symbols-outlined text-red-500">calendar_month</span> <strong>Hari/Tanggal :</strong> ${ann.day_date}</p>
                <p class="flex items-center gap-3"><span class="material-symbols-outlined text-red-500">schedule</span> <strong>Waktu :</strong> ${ann.time}</p>
                <p class="flex items-center gap-3"><span class="material-symbols-outlined text-red-500">location_on</span> <strong>Tempat :</strong> ${ann.location}</p>
            </div>
            <div class="text-gray-700 leading-relaxed">
                <p>${ann.full_description}</p>
                <br>
                <p>Hormat kami,</p>
                <p class="font-semibold">${ann.closing}</p>
            </div>
        `;
        showDetailView();
    }

    // Click handling on cards (view details / edit)
    listContainer.addEventListener('click', (e) => {
        const card = e.target.closest('.announcement-card');
        const editBtn = e.target.closest('.edit-btn');
        if (editBtn) {
            // Edit -> fill modal
            const id = editBtn.dataset.id;
            const cardEl = listContainer.querySelector(`.announcement-card[data-id="${id}"]`);
            if (!cardEl) return;
            announcementIdInput.value = id;
            form.title.value = cardEl.dataset.title;
            form.short_description.value = cardEl.dataset.short;
            form.full_description.value = cardEl.dataset.full;
            form.day_date.value = cardEl.dataset.day_date;
            form.time.value = cardEl.dataset.time;
            form.location.value = cardEl.dataset.location;
            form.closing.value = cardEl.dataset.closing;

            // Change form action to update and add hidden _method for PUT if not present
            form.action = `/pengumuman/${id}`;
            let methodInput = form.querySelector('input[name="_method"]');
            if (!methodInput) {
                methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                form.appendChild(methodInput);
            }
            methodInput.value = 'PUT';

            modalTitle.textContent = 'Edit Pengumuman';
            showModal();
        } else if (card) {
            // View detail
            renderDetailFromDataset(card);
        }
    });

    // Add new
    addBtn.addEventListener('click', () => {
        form.reset();
        announcementIdInput.value = '';
        form.action = "{{ route('pengumuman.store') }}";
        const methodInput = form.querySelector('input[name="_method"]');
        if (methodInput) methodInput.remove();
        modalTitle.textContent = 'Tambah Pengumuman Baru';
        showModal();
    });

    // Cancel modal
    cancelBtn.addEventListener('click', hideModal);
    modal.addEventListener('click', (e) => { if (e.target === modal) hideModal(); });

    backBtn.addEventListener('click', showListView);

    // Search client-side by reading dataset
    searchInput.addEventListener('input', () => {
        const searchTerm = searchInput.value.toLowerCase().trim();
        const cards = Array.from(listContainer.querySelectorAll('.announcement-card'));
        let visible = 0;
        cards.forEach(card => {
            const title = (card.dataset.title || '').toLowerCase();
            const short = (card.dataset.short || '').toLowerCase();
            if (title.includes(searchTerm) || short.includes(searchTerm)) {
                card.classList.remove('hidden');
                visible++;
            } else {
                card.classList.add('hidden');
            }
        });
        if (visible === 0) {
            // show message if none found
            if (!document.getElementById('no-results')) {
                const p = document.createElement('p');
                p.id = 'no-results';
                p.className = 'text-center text-gray-500';
                p.textContent = 'Pengumuman tidak ditemukan.';
                listContainer.appendChild(p);
            }
        } else {
            const p = document.getElementById('no-results');
            if (p) p.remove();
        }
    });

    // Sidebar active state switching if you still use in-page nav (not necessary for separate pages)
    const navLinks = document.querySelectorAll('.nav-link');
    const contentSections = document.querySelectorAll('.content-section');
    const activeClasses = ['bg-white', 'text-slate-800', 'font-bold'];
    const inactiveClasses = ['text-gray-300', 'hover:bg-slate-700'];

    function setInitialState() {
        navLinks.forEach(link => { link.classList.remove(...activeClasses); link.classList.add(...inactiveClasses); });
        const firstLink = navLinks[0];
        if (firstLink) {
            firstLink.classList.add(...activeClasses);
            firstLink.classList.remove(...inactiveClasses);
            const target = firstLink.dataset.target;
            if (target) document.getElementById(target).classList.remove('hidden');
        }
    }
    setInitialState();

    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            // If these links are navigation to different pages, they will reload; keep handler only for in-page switching
            if (this.dataset && this.dataset.target) {
                e.preventDefault();
                showListView();
                navLinks.forEach(nav => { nav.classList.remove(...activeClasses); nav.classList.add(...inactiveClasses); });
                contentSections.forEach(section => section.classList.add('hidden'));
                this.classList.add(...activeClasses);
                this.classList.remove(...inactiveClasses);
                const target = this.dataset.target;
                if (target) document.getElementById(target).classList.remove('hidden');
            }
        });
    });
});
</script>
@endpush