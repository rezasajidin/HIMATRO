<nav id="sidebar" class="w-64 h-full bg-slate-800 text-white flex flex-col p-4 fixed z-40 transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out">
    <div class="flex items-center gap-3 px-2 mb-8">
        <img src="{{ asset('img/logo.jpg') }}" alt="Logo Himatro" class="h-10 w-10">
        <div>
            <h2 class="font-bold text-sm">Sekretariat<br>Himatro</h2>
        </div>
    </div>

    <ul class="flex-grow">
        <li>
            <a href="{{ route('dashboard') }}"
               class="{{ request()->routeIs('dashboard') || request()->routeIs('pengumuman.*') ? 'nav-link bg-white text-slate-800 font-bold' : 'nav-link text-gray-300 hover:bg-slate-700' }}">
                <span class="material-symbols-outlined">campaign</span> Pengumuman
            </a>
        </li>
        <li>
            <a href="{{ route('kegiatan.index') }}"
               class="{{ request()->routeIs('kegiatan.*') ? 'nav-link bg-white text-slate-800 font-bold' : 'nav-link text-gray-300 hover:bg-slate-700' }}">
                <span class="material-symbols-outlined">event</span> Kegiatan
            </a>
        </li>
        
        <li>
            <a href="{{ route('kehadiran.index') }}" 
               class="{{ request()->routeIs('kehadiran.*') ? 'nav-link bg-white text-slate-800 font-bold' : 'nav-link text-gray-300 hover:bg-slate-700' }}">
               <span class="material-symbols-outlined">person_check</span> Kehadiran
            </a>
        </li>
        <li>
            <a href="{{ route('surat.index') }}"
               class="{{ request()->routeIs('surat.*') ? 'nav-link bg-white text-slate-800 font-bold' : 'nav-link text-gray-300 hover:bg-slate-700' }}">
               <span class="material-symbols-outlined">mail</span> Surat
            </a>
        </li>
        <li>
            <a href="{{ route('keuangan.index') }}"
               class="{{ request()->routeIs('keuangan.*') ? 'nav-link bg-white text-slate-800 font-bold' : 'nav-link text-gray-300 hover:bg-slate-700' }}">
               <span class="material-symbols-outlined">payments</span> Keuangan
           </a>
        </li>

        {{-- Sesuai migrasi dan request Anda (Super Admin & Sekretaris) --}}
        @if(in_array(auth()->user()->role, ['Super Admin', 'Sekretaris']))
        <li>
            <a href="{{ route('akun.index') }}"
               class="{{ request()->routeIs('akun.*') ? 'nav-link bg-white text-slate-800 font-bold' : 'nav-link text-gray-300 hover:bg-slate-700' }}">
                <span class="material-symbols-outlined">manage_accounts</span> Kelola Akun
            </a>
        </li>
        @endif
        </ul>

    <ul class="border-t border-slate-600 pt-4 mt-4">
        <li class="mb-2 text-xs text-gray-400 tracking-wide uppercase">
            Anda masuk sebagai:
        </li>
        <li class="mb-3 text-sm font-semibold text-white">
            {{ \Illuminate\Support\Str::title(auth()->user()->nama) }}
            ({{ \Illuminate\Support\Str::title(auth()->user()->role) }})
        </li>
        <li>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="nav-link w-full text-left">
                    <span class="material-symbols-outlined">logout</span> Log Out
                </button>
            </form>
        </li>
    </ul>
</nav>