@extends('layouts.app')

@section('title', 'Dashboard - Kegiatan')

@section('content')
<div>
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
            <button id="menu-btn" class="md:hidden text-slate-700">
                <span class="material-symbols-outlined text-3xl">menu</span>
            </button>
            <h1 class="text-2xl md:text-3xl font-bold text-slate-800">Kegiatan</h1>
        </div>
    </div>

    <section id="content-kegiatan">
        <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-4 mb-6">
            <div>
                <h2 class="text-xl font-bold text-slate-700">Daftar Kegiatan</h2>
                <p class="text-gray-500">Jangan sampai ketinggalan Kabar !!!</p>
            </div>
            <button id="add-kegiatan-btn" class="bg-blue-600 text-white font-bold py-2 px-4 rounded-lg flex items-center justify-center gap-2 hover:bg-blue-700 transition-colors w-full sm:w-auto">
                <span class="material-symbols-outlined">add</span> Kegiatan Baru
            </button>
        </div>

        <div class="flex flex-col md:flex-row gap-4 mb-6">
            <div class="relative flex-grow">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">search</span>
                <input type="text" id="kegiatan-search-input" placeholder="Cari Kegiatan...." class="w-full py-3 pl-10 pr-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <select id="kegiatan-departemen-filter" class="border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Semua Departemen</option>
                <option value="Pendidikan">Pendidikan</option>
                <option value="Minat dan Bakat">Minat dan Bakat</option>
                <option value="Sosial dan Kerohanian">Sosial dan Kerohanian</option>
                <option value="Kominfo">Kominfo</option>
                <option value="PRTK">PRTK</option>
            </select>
            <select id="kegiatan-kategori-filter" class="border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Semua Kategori</option>
                <option value="Akan Datang">Akan Datang</option>
                <option value="Berjalan">Berjalan</option>
                <option value="Selesai">Selesai</option>
            </select>
        </div>

        <div id="kegiatan-list" class="space-y-4">
            @forelse($kegiatan as $item)
                <article
                    data-id="{{ $item->id }}"
                    data-title="{{ e($item->title) }}"
                    data-description="{{ e($item->description) }}"
                    data-date="{{ $item->date ? $item->date->format('Y-m-d') : '' }}"
                    data-date-display="{{ $item->date ? $item->date->format('d F Y') : '' }}"
                    data-location="{{ e($item->location) }}"
                    data-department="{{ e($item->department) }}"
                    data-status="{{ e($item->status) }}"
                    class="kegiatan-card bg-white p-6 rounded-xl shadow-md border border-gray-100"
                >
                    <div class="flex justify-between items-start gap-2">
                        <h3 class="text-lg font-bold text-slate-800">{{ $item->title }}</h3>
                        <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full {{ $item->status === 'Akan Datang' ? 'bg-orange-100 text-orange-800' : ($item->status === 'Berjalan' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800') }} flex-shrink-0">
                            {{ $item->status }}
                        </span>
                    </div>
                    <p class="text-gray-600 mt-2 mb-4">{{ \Illuminate\Support\Str::limit($item->description, 200) }}</p>
                    <div class="text-sm text-gray-500 border-t pt-4 flex flex-col sm:flex-row justify-between sm:items-center">
                        <div class="space-y-1 mb-4 sm:mb-0">
                            <p class="flex items-center gap-2"><span class="material-symbols-outlined text-base">calendar_month</span>{{ $item->date ? $item->date->format('d F Y') : '' }}</p>
                            <p class="flex items-center gap-2"><span class="material-symbols-outlined text-base">location_on</span>{{ $item->location }}</p>
                            <p class="flex items-center gap-2"><span class="material-symbols-outlined text-base">apartment</span>Departemen {{ $item->department }}</p>
                        </div>
                        <div class="flex gap-4 self-end">
                            <button class="kegiatan-edit-btn hover:text-blue-600 transition-colors" data-id="{{ $item->id }}"><span class="material-symbols-outlined">edit</span></button>
                            <form action="{{ route('kegiatan.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menghapus kegiatan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="hover:text-red-600 transition-colors"><span class="material-symbols-outlined">delete</span></button>
                            </form>
                        </div>
                    </div>
                </article>
            @empty
                <p class="text-center text-gray-500 py-4">Belum ada kegiatan.</p>
            @endforelse
        </div>
    </section>
</div>

{{-- Modal --}}
<div id="kegiatan-modal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden z-50 p-4">
    <div class="bg-white p-6 sm:p-8 rounded-xl shadow-2xl w-full max-w-lg">
        <h2 id="kegiatan-modal-title" class="text-2xl font-bold text-slate-800 mb-6"></h2>

        <form id="kegiatan-form" action="{{ route('kegiatan.store') }}" method="POST">
            @csrf
            <input type="hidden" id="kegiatan-id" name="id">
            <div class="mb-4">
                <label for="kegiatan-title" class="block text-sm font-medium text-gray-700 mb-1">Nama Kegiatan</label>
                <input type="text" id="kegiatan-title" name="title" required class="w-full px-3 py-2 border border-gray-300 rounded-lg">
            </div>
            <div class="mb-4">
                <label for="kegiatan-description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Singkat</label>
                <textarea id="kegiatan-description" name="description" rows="3" required class="w-full px-3 py-2 border border-gray-300 rounded-lg"></textarea>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="kegiatan-date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                    <input type="date" id="kegiatan-date" name="date" required class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                </div>
                 <div>
                    <label for="kegiatan-location" class="block text-sm font-medium text-gray-700 mb-1">Lokasi</label>
                    <input type="text" id="kegiatan-location" name="location" required class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                <div>
                    <label for="kegiatan-departemen" class="block text-sm font-medium text-gray-700 mb-1">Departemen</label>
                    <select id="kegiatan-departemen" name="department" required class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                        <option value="Pendidikan">Pendidikan</option>
                        <option value="Minat dan Bakat">Minat dan Bakat</option>
                        <option value="Sosial dan Kerohanian">Sosial dan Kerohanian</option>
                        <option value="Kominfo">Kominfo</option>
                        <option value="PRTK">PRTK</option>
                    </select>
                </div>
                <div>
                    <label for="kegiatan-status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select id="kegiatan-status" name="status" required class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                        <option value="Akan Datang">Akan Datang</option>
                        <option value="Berjalan">Berjalan</option>
                        <option value="Selesai">Selesai</option>
                    </select>
                </div>
            </div>
            <div class="flex justify-end gap-4">
                <button type="button" id="kegiatan-cancel-btn" class="bg-gray-200 text-gray-800 font-bold py-2 px-4 rounded-lg hover:bg-gray-300">Batal</button>
                <button type="submit" id="kegiatan-save-btn" class="bg-blue-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-700">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const kegiatanListContainer = document.getElementById('kegiatan-list');
    const kegiatanSearchInput = document.getElementById('kegiatan-search-input');
    const departemenFilter = document.getElementById('kegiatan-departemen-filter');
    const kategoriFilter = document.getElementById('kegiatan-kategori-filter');
    const kegiatanModal = document.getElementById('kegiatan-modal');
    const kegiatanModalTitle = document.getElementById('kegiatan-modal-title');
    const kegiatanForm = document.getElementById('kegiatan-form');
    const addKegiatanBtn = document.getElementById('add-kegiatan-btn');
    const cancelKegiatanBtn = document.getElementById('kegiatan-cancel-btn');

    function getCardsArray() {
        return Array.from(kegiatanListContainer.querySelectorAll('.kegiatan-card'));
    }

    function applyFiltersAndRender() {
        const searchTerm = kegiatanSearchInput.value.toLowerCase().trim();
        const selectedDepartemen = departemenFilter.value;
        const selectedKategori = kategoriFilter.value;

        const cards = getCardsArray();
        let visible = 0;
        cards.forEach(card => {
            const title = (card.dataset.title || '').toLowerCase();
            const desc = (card.dataset.description || '').toLowerCase();
            const dept = card.dataset.department || '';
            const status = card.dataset.status || '';

            const searchMatch = title.includes(searchTerm) || desc.includes(searchTerm);
            const departemenMatch = !selectedDepartemen || dept === selectedDepartemen;
            const kategoriMatch = !selectedKategori || status === selectedKategori;

            if (searchMatch && departemenMatch && kategoriMatch) {
                card.classList.remove('hidden');
                visible++;
            } else {
                card.classList.add('hidden');
            }
        });

        const existing = document.getElementById('no-kegiatan-results');
        if (visible === 0) {
            if (!existing) {
                const p = document.createElement('p');
                p.id = 'no-kegiatan-results';
                p.className = 'text-center text-gray-500 py-4';
                kegiatanListContainer.appendChild(p);
            }
        } else {
            if (existing) existing.remove();
        }
    }

    [kegiatanSearchInput, departemenFilter, kategoriFilter].forEach(el => {
        el.addEventListener('input', applyFiltersAndRender);
        el.addEventListener('change', applyFiltersAndRender);
    });

    // Open modal for add
    addKegiatanBtn.addEventListener('click', () => {
        kegiatanForm.reset();
        kegiatanForm.action = "{{ route('kegiatan.store') }}";
        const methodInput = kegiatanForm.querySelector('input[name="_method"]');
        if (methodInput) methodInput.remove();
        document.getElementById('kegiatan-id').value = '';
        kegiatanModalTitle.textContent = 'Tambah Kegiatan Baru';
        kegiatanModal.classList.remove('hidden');
    });

    // Edit handler
    kegiatanListContainer.addEventListener('click', e => {
        const editBtn = e.target.closest('.kegiatan-edit-btn');
        if (editBtn) {
            const id = editBtn.dataset.id;
            const card = kegiatanListContainer.querySelector(`.kegiatan-card[data-id="${id}"]`);
            if (!card) return;
            document.getElementById('kegiatan-id').value = id;
            kegiatanForm['title'].value = card.dataset.title;
            kegiatanForm['description'].value = card.dataset.description;
            kegiatanForm['date'].value = card.dataset.date || '';
            kegiatanForm['location'].value = card.dataset.location;
            kegiatanForm['department'].value = card.dataset.department;
            kegiatanForm['status'].value = card.dataset.status;

            kegiatanForm.action = `/kegiatan/${id}`;
            let methodInput = kegiatanForm.querySelector('input[name="_method"]');
            if (!methodInput) {
                methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                kegiatanForm.appendChild(methodInput);
            }
            methodInput.value = 'PUT';

            kegiatanModalTitle.textContent = 'Edit Kegiatan';
            kegiatanModal.classList.remove('hidden');
        }
    });

    cancelKegiatanBtn.addEventListener('click', () => kegiatanModal.classList.add('hidden'));
    kegiatanModal.addEventListener('click', e => { if (e.target === kegiatanModal) kegiatanModal.classList.add('hidden'); });

    // initial
    applyFiltersAndRender();
});
</script>
@endpush