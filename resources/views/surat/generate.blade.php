@extends('layouts.app')

@section('title', 'Buat Surat - ' . $template->judul)

@section('content')
<div class="container py-6">
    <h2 class="text-2xl font-bold mb-6">{{ $template->judul }}</h2>

    <form action="{{ route('surat.template.generate', $template->id) }}" method="POST" target="_blank">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div>
                <label class="block text-gray-700 font-semibold mb-1">Kepada</label>
                <input type="text" name="kepada" class="w-full border rounded-lg p-2" required>
            </div>
            <div>
                <label class="block text-gray-700 font-semibold mb-1">Penanggung Jawab</label>
                <input type="text" name="penanggung_jawab" class="w-full border rounded-lg p-2" required>
            </div>
            <div>
                <label class="block text-gray-700 font-semibold mb-1">Tanggal</label>
                <input type="date" name="tanggal" class="w-full border rounded-lg p-2" required>
            </div>
            <div>
                <label class="block text-gray-700 font-semibold mb-1">Lokasi</label>
                <input type="text" name="lokasi" class="w-full border rounded-lg p-2" required>
            </div>
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 font-semibold mb-1">Detail Surat</label>
            <textarea name="detail" class="w-full border rounded-lg p-3 h-32"></textarea>
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('surat.template') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg">Batal</a>
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                Generate PDF
            </button>
        </div>
    </form>
</div>
@endsection
