<div x-show="sidebarOpen" @click="sidebarOpen = false"
    class="fixed inset-0 bg-black/50 z-20 transition-opacity scrollbar-custom md:hidden"
    x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
</div>

{{-- Sidebar Utama --}}
<div :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    class="fixed inset-y-0 left-0 z-30 w-64 transform bg-[#486284] text-white transition duration-300 md:translate-x-0 md:static md:inset-0 flex flex-col">

    {{-- Header Sidebar --}}
    <div class="flex items-center mb-5 space-x-3 px-4 py-4">
        {{-- Logo Gambar --}}
        <img src="{{ asset('img/application-logo.svg') }}" alt="Logo BPS Sulut" class="w-10 h-10 object-contain">

        {{-- Tulisan --}}
        <div class="leading-tight">
            <h2 class="font-semibold">Badan Pusat Statistik</h2>
            <span class="text-sm text-gray-300">Sulawesi Utara</span>
        </div>
    </div>

    {{-- Navigasi Menu --}}
    <nav class="flex-1 overflow-y-auto px-4 space-y-5">
        {{-- Menu --}}
        <div class="space-y-2">
            <h1 class="mb-1 text-xs text-gray-400 font-bold uppercase">Menu</h1>
            <a href="{{ route('dashboard') }}"
                class="flex items-center space-x-3 px-4 py-2 text-gray-200 text-sm font-semibold rounded-md hover:bg-white/10 {{ Route::is('dashboard') ? 'bg-white/10 text-white' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-house-door-fill" viewBox="0 0 16 16">
                    <path
                        d="M6.5 14.5v-3.505c0-.245.25-.495.5-.495h2c.25 0 .5.25.5.5v3.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5" />
                </svg>
                <span>Dashboard</span>
            </a>
        </div>

        {{-- Kepegawaian --}}
        <div class="space-y-2">
            <h1 class="mb-1 text-xs text-gray-400 font-bold uppercase">Kepegawaian</h1>
            <a href="{{ route('dashboard.employee.index') }}"
                class="flex items-center space-x-3 px-4 py-2 text-gray-200 text-sm font-semibold rounded-md hover:bg-white/10 {{ Route::is('dashboard.employee.*') ? 'bg-white/10 text-white' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-person-vcard-fill" viewBox="0 0 16 16">
                    <path
                        d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm9 1.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 0-1h-4a.5.5 0 0 0-.5.5M9 8a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 0-1h-4A.5.5 0 0 0 9 8m1 2.5a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 0-1h-3a.5.5 0 0 0-.5.5m-1 2C9 10.567 7.21 9 5 9c-2.086 0-3.8 1.398-3.984 3.181A1 1 0 0 0 2 13h6.96q.04-.245.04-.5M7 6a2 2 0 1 0-4 0 2 2 0 0 0 4 0" />
                </svg>
                <span>Data Pegawai</span>
            </a>
        </div>

        {{-- Stok Barang --}}
        <div class="space-y-2">
            <h1 class="mb-1 text-xs text-gray-400 font-bold uppercase">Stok Barang</h1>
            <a href="{{ route('dashboard.item.index') }}"
                class="flex items-center space-x-3 px-4 py-2 text-gray-200 text-sm font-semibold rounded-md hover:bg-white/10 {{ Route::is('dashboard.item.*') ? 'bg-white/10 text-white' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-box-seam-fill" viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                        d="M15.528 2.973a.75.75 0 0 1 .472.696v8.662a.75.75 0 0 1-.472.696l-7.25 2.9a.75.75 0 0 1-.557 0l-7.25-2.9A.75.75 0 0 1 0 12.331V3.669a.75.75 0 0 1 .471-.696L7.443.184l.01-.003.268-.108a.75.75 0 0 1 .558 0l.269.108.01.003zM10.404 2 4.25 4.461 1.846 3.5 1 3.839v.4l6.5 2.6v7.922l.5.2.5-.2V6.84l6.5-2.6v-.4l-.846-.339L8 5.961 5.596 5l6.154-2.461z" />
                </svg>
                <span>Data Barang</span>
            </a>
            <a href="{{ route('dashboard.stock-in.index') }}"
                class="flex items-center space-x-3 px-4 py-2 text-gray-200 text-sm font-semibold rounded-md hover:bg-white/10 {{ Route::is('dashboard.stock-in.*') ? 'bg-white/10 text-white' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-mailbox2" viewBox="0 0 16 16">
                    <path d="M9 8.5h2.793l.853.854A.5.5 0 0 0 13 9.5h1a.5.5 0 0 0 .5-.5V8a.5.5 0 0 0-.5-.5H9z" />
                    <path
                        d="M12 3H4a4 4 0 0 0-4 4v6a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1V7a4 4 0 0 0-4-4M8 7a4 4 0 0 0-1.354-3H12a3 3 0 0 1 3 3v6H8zm-3.415.157C4.42 7.087 4.218 7 4 7s-.42.086-.585.157C3.164 7.264 3 7.334 3 7a1 1 0 0 1 2 0c0 .334-.164.264-.415.157" />
                </svg>
                <span>Barang Masuk</span>
            </a>
            <a href="{{ route('dashboard.stock-out.index') }}"
                class="flex items-center space-x-3 px-4 py-2 text-gray-200 text-sm font-semibold rounded-md hover:bg-white/10 {{ Route::is('dashboard.stock-out.*') ? 'bg-white/10 text-white' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-mailbox2-flag" viewBox="0 0 16 16">
                    <path d="M10.5 8.5V3.707l.854-.853A.5.5 0 0 0 11.5 2.5v-2A.5.5 0 0 0 11 0H9.5a.5.5 0 0 0-.5.5v8z" />
                    <path
                        d="M4 3h4v1H6.646A4 4 0 0 1 8 7v6h7V7a3 3 0 0 0-3-3V3a4 4 0 0 1 4 4v6a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V7a4 4 0 0 1 4-4m.585 4.157C4.836 7.264 5 7.334 5 7a1 1 0 0 0-2 0c0 .334.164.264.415.157C3.58 7.087 3.782 7 4 7s.42.086.585.157" />
                </svg>
                <span>Barang Keluar</span>
            </a>
        </div>
    </nav>
</div>
