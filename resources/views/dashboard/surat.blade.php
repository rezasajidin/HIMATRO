@extends('layouts.app')

@section('title', 'Dashboard - Surat')

@section('content')
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
  <div>
    <h2 class="text-xl font-bold text-slate-700">Manajemen Surat</h2>
    <p class="text-gray-500">Kelola surat masuk dan keluar dengan mudah.</p>
  </div>
  <div class="flex flex-wrap gap-3">
    <a href="{{ route('surat.template') }}" class="border border-gray-300 text-gray-700 font-semibold py-2 px-4 rounded-lg hover:bg-gray-50 transition-colors">
      Template Surat
    </a>
    <button id="upload-surat-btn" class="bg-blue-600 text-white font-bold py-2 px-4 rounded-lg flex items-center gap-2 hover:bg-blue-700 transition-colors">
      <span class="material-symbols-outlined">add</span> Upload Surat
    </button>
  </div>
</div>

<!-- Filter -->
<div class="flex flex-col sm:flex-row gap-4 mb-6">
  <div class="relative flex-grow">
    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">search</span>
    <input type="text" id="surat-search-input" placeholder="Cari Surat..." class="w-full py-3 pl-10 pr-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
  </div>
  <select id="surat-kategori-filter" class="border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
    <option value="">Semua Kategori</option>
    <option value="Masuk">Masuk</option>
    <option value="Keluar">Keluar</option>
  </select>
</div>

<div id="surat-list" class="space-y-3">
    @forelse ($surat as $item)
      <div class="p-4 bg-white rounded-lg shadow flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 border border-gray-200">
        <div class="flex items-center gap-3">
          {{-- ICON FILE --}}
          @if(Str::endsWith($item->filename, '.pdf'))
            <img src="https://cdn-icons-png.flaticon.com/512/337/337946.png" alt="PDF Icon" class="w-8 h-8">
          @elseif(Str::endsWith($item->filename, ['.doc', '.docx']))
            <img src="https://cdn-icons-png.flaticon.com/512/281/281760.png" alt="Word Icon" class="w-8 h-8">
          @elseif(Str::endsWith($item->filename, ['.jpg', '.jpeg', '.png']))
            <img src="https://cdn-icons-png.flaticon.com/512/337/337940.png" alt="Image Icon" class="w-8 h-8">
          @else
            <img src="https://cdn-icons-png.flaticon.com/512/833/833524.png" alt="File Icon" class="w-8 h-8">
          @endif
  
          <div>
            <h3 class="font-semibold text-gray-800">{{ $item->filename }}</h3>
            <p class="text-sm text-gray-500">Kategori: {{ $item->kategori }}</p>
          </div>
        </div>
  
        <div class="flex gap-2">
          <a href="{{ asset('storage/' . $item->path) }}" target="_blank" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700 flex items-center gap-1">
            <span class="material-symbols-outlined text-sm">download</span> Lihat
          </a>
          <form action="{{ route('surat.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus surat ini?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-red-700 flex items-center gap-1">
              <span class="material-symbols-outlined text-sm">delete</span> Hapus
            </button>
          </form>
        </div>
      </div>
    @empty
      <p class="text-gray-500 text-center py-6">Belum ada surat yang diunggah.</p>
    @endforelse
  </div>
  
  

<!-- Modal Upload Surat -->
<div id="upload-surat-modal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden z-50">
  <div class="bg-white p-6 md:p-8 rounded-xl shadow-2xl w-[90%] max-w-lg relative">
    <button id="close-modal" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
      <span class="material-symbols-outlined">close</span>
    </button>
    <h2 class="text-2xl font-bold text-slate-800 mb-6">Upload Surat Baru</h2>

    <form id="upload-surat-form" method="POST" enctype="multipart/form-data" action="{{ route('surat.store') }}">
      @csrf
      <div class="mb-4">
        <label for="file-input" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition">
          <div id="dropzone-content" class="flex flex-col items-center justify-center pt-5 pb-6 text-center">
            <span class="material-symbols-outlined text-gray-500 text-4xl">cloud_upload</span>
            <p id="dropzone-text" class="mb-2 text-sm text-gray-500"><span class="font-semibold">Klik untuk memilih</span> atau seret & lepas</p>
            <p class="text-xs text-gray-500">PDF, DOCX, PNG, atau JPG</p>
          </div>
          <input id="file-input" name="file" type="file" class="hidden" required />
        </label>
      </div>

      <div class="mb-4">
        <label for="surat-filename" class="block text-sm font-medium text-gray-700 mb-1">Nama File Surat</label>
        <input type="text" id="surat-filename" name="filename" required placeholder="Contoh: Surat Undangan Rapat.pdf" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
      </div>

      <div class="mb-6">
        <label for="surat-kategori" class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
        <select id="surat-kategori" name="kategori" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
          <option value="Masuk">Masuk</option>
          <option value="Keluar">Keluar</option>
        </select>
      </div>

      <div class="flex justify-end gap-4">
        <button type="button" id="cancel-upload-btn" class="bg-gray-200 text-gray-800 font-bold py-2 px-4 rounded-lg hover:bg-gray-300">Batal</button>
        <button type="submit" class="bg-blue-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-700">Upload</button>
      </div>
    </form>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const uploadModal = document.getElementById('upload-surat-modal');
  const uploadBtn = document.getElementById('upload-surat-btn');
  const cancelBtn = document.getElementById('cancel-upload-btn');
  const closeModal = document.getElementById('close-modal');
  const fileInput = document.getElementById('file-input');
  const dropzoneText = document.getElementById('dropzone-text');
  const filenameInput = document.getElementById('surat-filename');

  function showModal() { uploadModal.classList.remove('hidden'); }
  function hideModal() { uploadModal.classList.add('hidden'); }

  uploadBtn.onclick = showModal;
  cancelBtn.onclick = hideModal;
  closeModal.onclick = hideModal;
  uploadModal.onclick = e => { if (e.target === uploadModal) hideModal(); };

  fileInput.onchange = () => {
    if (fileInput.files.length) {
      const fileName = fileInput.files[0].name;
      dropzoneText.textContent = fileName;
      filenameInput.value = fileName;
    }
  };
});
</script>
@endsection
