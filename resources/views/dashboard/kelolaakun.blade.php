@extends('layouts.app')

@section('title', 'Kelola Akun')

@section('content')
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
  <div>
    <h2 class="text-xl font-bold text-slate-700">Kelola Akun</h2>
    <p class="text-gray-500">Kelola pengguna dan peran departemen.</p>
  </div>
  <div class="flex flex-wrap gap-3">
    <button id="add-akun-btn"
      class="bg-blue-600 text-white font-bold py-2 px-4 rounded-lg flex items-center gap-2 hover:bg-blue-700 transition-colors">
      <span class="material-symbols-outlined">add</span> Tambah Akun
    </button>
  </div>
</div>

{{-- Statistik --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
  <div class="bg-white p-6 rounded-xl shadow-sm border text-center">
    <p class="text-sm text-gray-500 mb-1">Total Akun</p>
    <p class="text-3xl font-bold text-slate-800">{{ $totalAkun }}</p>
  </div>
  <div class="bg-white p-6 rounded-xl shadow-sm border text-center">
    <p class="text-sm text-gray-500 mb-1">Akun Aktif</p>
    <p class="text-3xl font-bold text-green-600">{{ $akunAktif }}</p>
  </div>
  <div class="bg-white p-6 rounded-xl shadow-sm border text-center">
    <p class="text-sm text-gray-500 mb-1">Akun Inaktif</p>
    <p class="text-3xl font-bold text-red-600">{{ $akunInactive }}</p>
  </div>
</div>

{{-- Daftar Akun --}}
<div class="bg-white p-4 md:p-6 rounded-xl shadow-md border overflow-x-auto">
  <div class="flex justify-between items-center mb-4">
    <h3 class="text-lg font-bold text-slate-800">Daftar Pengguna</h3>
    <form method="GET" class="flex gap-2">
      <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau NIM..."
        class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500">
      <button class="bg-blue-600 text-white px-3 rounded-lg hover:bg-blue-700">Cari</button>
    </form>
  </div>

  <table class="w-full text-left min-w-[700px]">
    <thead class="border-b border-gray-200 text-sm text-gray-600">
      <tr>
        <th class="py-3 px-4">Nama</th>
        <th class="py-3 px-4">NIM</th>
        <th class="py-3 px-4">Role</th>
        <th class="py-3 px-4">Departemen</th>
        <th class="py-3 px-4">Status</th>
        <th class="py-3 px-4 text-right">Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse($users as $user)
        <tr class="border-b hover:bg-gray-50">
          <td class="py-3 px-4 font-semibold text-slate-800">{{ $user->nama }}</td>
          <td class="py-3 px-4 text-slate-700">{{ $user->nim }}</td>
          <td class="py-3 px-4 text-slate-700">{{ $user->role }}</td>
          <td class="py-3 px-4 text-slate-700">{{ $user->departemen }}</td>
          <td class="py-3 px-4">
            <span
              class="px-2 py-1 rounded-full text-xs font-semibold {{ $user->status == 'Active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
              {{ $user->status }}
            </span>
          </td>
          <td class="py-3 px-4 text-right">
            <form action="{{ route('akun.destroy', $user->id) }}" method="POST"
              onsubmit="return confirm('Yakin ingin menghapus akun ini?')" class="inline-block">
              @csrf
              @method('DELETE')
              <button class="text-red-600 hover:text-red-800">
                <span class="material-symbols-outlined">delete</span>
              </button>
            </form>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="6" class="text-center py-4 text-gray-500">Belum ada data akun.</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>

{{-- Modal Tambah Akun --}}
<div id="add-akun-modal" class="fixed inset-0 bg-black/50 flex justify-center items-center hidden z-50 transition-opacity">
  <div class="bg-white p-6 md:p-8 rounded-xl shadow-2xl w-[90%] max-w-lg relative animate-fade-in">
    <button id="close-modal" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
      <span class="material-symbols-outlined">close</span>
    </button>
    <h2 class="text-2xl font-bold text-slate-800 mb-6">Tambah Akun</h2>

    <form action="{{ route('akun.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label for="nama" class="block text-sm font-medium text-gray-700">Nama</label>
            <input type="text" name="nama" id="nama" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500" required>
        </div>

        <div>
            <label for="nim" class="block text-sm font-medium text-gray-700">NIM</label>
            <input type="text" name="nim" id="nim" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500" required>
        </div>

        <div>
            <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
            <select name="role" id="role" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
                <option value="">Pilih Role</option>
                <option value="Anggota">Anggota</option>
                <option value="Bendahara">Bendahara</option>
                <option value="Ketua">Ketua</option>
                <option value="Sekretaris">Sekretaris</option>
                <option value="pic departemen">PIC Departemen</option>
            </select>
        </div>

        <div>
            <label for="departemen" class="block text-sm font-medium text-gray-700">Departemen</label>
            <select name="departemen" id="departemen" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
                <option value="">Pilih Departemen</option>
                <option value="Minat dan Bakat">Minat dan Bakat</option>
                <option value="Humas">Humas</option>
                <option value="Advokasi">Advokasi</option>
                <option value="Pendidikan">Pendidikan</option>
                <option value="PRTK">PRTK</option>
                <option value="Kominfo">Kominfo</option>
                <option value="Sosker">Sosker</option>
            </select>
        </div>

        <div>
            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
            <select name="status" id="status" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
                <option value="Active">Active</option>
                <option value="Inactive">Inactive</option>
            </select>
        </div>

        <div class="flex justify-end gap-3 pt-4">
          <button type="button" id="cancel-btn" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">Batal</button>
          <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">Simpan</button>
        </div>
    </form>
  </div>
</div>

{{-- Script Modal --}}
<script>
document.addEventListener('DOMContentLoaded', () => {
  const modal = document.getElementById('add-akun-modal');
  const openBtn = document.getElementById('add-akun-btn');
  const cancelBtn = document.getElementById('cancel-btn');
  const closeBtn = document.getElementById('close-modal');

  function showModal() { modal.classList.remove('hidden'); }
  function hideModal() { modal.classList.add('hidden'); }

  openBtn.addEventListener('click', showModal);
  cancelBtn.addEventListener('click', hideModal);
  closeBtn.addEventListener('click', hideModal);
  modal.addEventListener('click', e => { if (e.target === modal) hideModal(); });
});
</script>

<style>
@keyframes fade-in {
  from { opacity: 0; transform: translateY(-10px); }
  to { opacity: 1; transform: translateY(0); }
}
.animate-fade-in {
  animation: fade-in 0.2s ease-out;
}
</style>
@endsection
