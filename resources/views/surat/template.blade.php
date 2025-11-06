@extends('layouts.app')

@section('title', 'Template Surat')

@section('content')
<div class="min-h-screen bg-white text-gray-900 py-10 px-6">

    <div class="mb-6">
        <a href="{{ route('surat.index') }}"
           class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M15 19l-7-7 7-7" />
            </svg>
            Kembali
        </a>
    </div>

    <div class="text-center mb-10">
        <h1 class="text-3xl font-bold mb-2">Pilih Template Surat</h1>
        <p class="text-gray-600">
            Pilih template surat yang ingin kamu gunakan di bawah ini.
        </p>
    </div>

    {{-- Grid Card Template --}}
    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @forelse ($templates as $template)
            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm hover:shadow-md transition-shadow duration-300">
                <div class="p-6 flex flex-col h-full">
                    <div class="flex-grow">
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">
                            {{ $template->tipe }}
                        </h3>
                        <p class="text-gray-600 text-sm leading-relaxed">
                            {{ $template->deskripsi ?? 'Tidak ada deskripsi tersedia.' }}
                        </p>
                    </div>
                    <div class="mt-5">
                        <a href="{{ route('surat.create', $template->id) }}"
                           class="w-full inline-flex justify-center items-center bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition">
                            Gunakan Template
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-10">
                <p class="text-gray-500">Belum ada template surat yang tersedia.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
