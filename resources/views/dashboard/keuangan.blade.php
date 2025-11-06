@extends('layouts.app')

@section('title', 'Dashboard - Keuangan')

@section('content')
<div>
    <!-- HEADER -->
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
            <button id="menu-btn" class="md:hidden text-slate-700">
                <span class="material-symbols-outlined text-3xl">menu</span>
            </button>
            <h1 class="text-3xl font-bold text-slate-800">Keuangan</h1>
        </div>
    </div>

    <!-- SECTION UTAMA -->
    <section id="content-keuangan">
        <!-- HEADER SECTION -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
            <div>
                <h2 class="text-xl font-bold text-slate-700">Manajemen Keuangan</h2>
                <p class="text-gray-500">Kelola pemasukan dan pengeluaran dengan mudah.</p>
            </div>
            <button id="add-transaksi-btn"
                class="bg-blue-600 text-white font-bold py-2 px-4 rounded-lg flex items-center gap-2 hover:bg-blue-700 transition-colors w-full md:w-auto justify-center">
                <span class="material-symbols-outlined">add</span> Transaksi Baru
            </button>
        </div>

        <!-- CARD RINGKASAN -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <p class="text-sm text-gray-500 mb-2">Total Uang Masuk</p>
                <p class="text-2xl font-bold text-green-600">Rp {{ number_format($totalMasuk, 0, ',', '.') }}</p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <p class="text-sm text-gray-500 mb-2">Total Uang Keluar</p>
                <p class="text-2xl font-bold text-red-600">Rp {{ number_format($totalKeluar, 0, ',', '.') }}</p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <p class="text-sm text-gray-500 mb-2">Saldo Akhir</p>
                <p class="text-2xl font-bold text-slate-800">Rp {{ number_format($totalSaldo, 0, ',', '.') }}</p>
            </div>
        </div>

        <!-- TABEL TRANSAKSI -->
        <div class="bg-white p-6 rounded-xl shadow-md border border-gray-100">
            <div class="flex justify-between items-center mb-4 flex-wrap gap-3">
                <div>
                    <h3 class="text-lg font-bold text-slate-800">Riwayat Transaksi</h3>
                    <p class="text-sm text-gray-500">Daftar semua pemasukan dan pengeluaran.</p>
                </div>
                <button
                    class="border border-gray-300 text-gray-700 font-semibold py-2 px-4 rounded-lg flex items-center gap-2 hover:bg-gray-50 transition-colors">
                    <span class="material-symbols-outlined">download</span> Export
                </button>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-left text-sm">
                    <thead class="border-b border-gray-200 text-gray-600 bg-gray-50">
                        <tr>
                            <th class="py-3 px-4 font-semibold">Tanggal</th>
                            <th class="py-3 px-4 font-semibold">Deskripsi</th>
                            <th class="py-3 px-4 font-semibold">Kategori</th>
                            <th class="py-3 px-4 font-semibold">Tipe</th>
                            <th class="py-3 px-4 font-semibold">Jumlah</th>
                            <th class="py-3 px-4 font-semibold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transaksis as $item)
                            <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                                <td class="py-3 px-4 text-gray-600">
                                    {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}
                                </td>
                                <td class="py-3 px-4 font-semibold text-slate-800">{{ $item->deskripsi }}</td>
                                <td class="py-3 px-4 text-gray-600">{{ $item->kategori }}</td>
                                <td class="py-3 px-4 text-gray-600">{{ $item->tipe }}</td>
                                <td class="py-3 px-4 font-semibold {{ $item->tipe === 'Masuk' ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $item->tipe === 'Masuk' ? '+' : '-' }}Rp {{ number_format($item->jumlah, 0, ',', '.') }}
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <form action="{{ route('keuangan.destroy', $item->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin hapus transaksi ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-gray-500 hover:text-red-600">
                                            <span class="material-symbols-outlined text-xl">delete</span>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-gray-500 py-4">Belum ada transaksi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- MODAL TAMBAH TRANSAKSI -->
    <div id="transaksi-modal"
        class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden z-50 p-4">
        <div class="bg-white p-6 rounded-xl shadow-2xl w-full max-w-lg transform transition-all">
            <h2 class="text-2xl font-bold text-slate-800 mb-6">Tambah Transaksi</h2>

            <form action="{{ route('keuangan.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                    <input type="text" name="deskripsi" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="jumlah" class="block text-sm font-medium text-gray-700 mb-1">Jumlah (Rp)</label>
                        <input type="number" name="jumlah" required placeholder="Contoh: 50000"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label for="tanggal" class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                        <input type="date" name="tanggal" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div>
                        <label for="tipe" class="block text-sm font-medium text-gray-700 mb-1">Tipe Transaksi</label>
                        <select name="tipe" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            <option value="Masuk">Masuk</option>
                            <option value="Keluar">Keluar</option>
                        </select>
                    </div>
                    <div>
                        <label for="kategori" class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                        <input type="text" name="kategori" required placeholder="Contoh: Operasional"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <div class="flex justify-end gap-4">
                    <button type="button" id="cancel-btn"
                        class="bg-gray-200 text-gray-800 font-bold py-2 px-4 rounded-lg hover:bg-gray-300">Batal</button>
                    <button type="submit"
                        class="bg-blue-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-700">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('transaksi-modal');
    const addBtn = document.getElementById('add-transaksi-btn');
    const cancelBtn = document.getElementById('cancel-btn');

    addBtn.addEventListener('click', () => {
        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    });

    cancelBtn.addEventListener('click', () => {
        modal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    });

    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }
    });
});
</script>
@endpush
