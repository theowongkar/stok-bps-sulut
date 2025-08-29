<x-app-layout>

    {{-- Judul Halaman --}}
    <x-slot name="title">Data Barang</x-slot>

    {{-- Bagian Barang --}}
    <section class="space-y-2">

        {{-- Header --}}
        <div class="bg-gray-50 rounded-lg border border-gray-300 shadow">
            <div class="p-2 space-y-2">
                {{-- Modal Create --}}
                <div x-data="{ openCreate: false }" class="flex flex-col lg:flex-row items-center justify-between gap-4">
                    {{-- Tombol Tambah --}}
                    <x-buttons.primary-button @click="openCreate = true"
                        class="w-full lg:w-auto text-center bg-green-600 hover:bg-green-700">
                        Tambah
                    </x-buttons.primary-button>

                    {{-- Modal Create Items --}}
                    <div x-show="openCreate" class="fixed inset-0 flex items-center justify-center bg-black/50 z-50">

                        <div class="bg-white rounded-lg p-6 w-full max-w-lg max-h-[80vh] overflow-y-auto">
                            <h2 class="text-lg font-semibold mb-4">Tambah Data Barang</h2>

                            <form method="POST" action="{{ route('dashboard.item.store') }}"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="space-y-5">
                                    <x-forms.input name="name" label="Nama Barang"></x-forms.input>
                                    <x-forms.textarea name="description" label="Description"
                                        rows="2"></x-forms.textarea>
                                    <div class="grid grid-cols-2 gap-5">
                                        <div>
                                            <label for="sku"
                                                class="block mb-1 text-sm font-medium text-gray-700">SKU</label>
                                            <div
                                                class="mt-1 flex rounded-md border border-gray-300 focus-within:ring focus-within:ring-blue-500 focus-within:border-blue-500">
                                                <span
                                                    class="inline-flex items-center px-3 text-sm text-gray-500 bg-gray-100 border-r border-gray-300 rounded-l-md">
                                                    SKU-
                                                </span>
                                                <input id="sku" name="sku" type="number"
                                                    value="{{ old('sku') }}"
                                                    class="w-full px-3 py-2 text-sm bg-white rounded-r-lg border-none focus:outline-none" />
                                            </div>

                                            @error('sku')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <x-forms.input name="stock" label="Stock Awal" type="number"></x-forms.input>
                                    </div>
                                </div>

                                <div class="mt-3 flex justify-end gap-2">
                                    <x-buttons.primary-button @click="openCreate = false"
                                        class="bg-gray-600 hover:bg-gray-700">
                                        Batal
                                    </x-buttons.primary-button>
                                    <x-buttons.primary-button type="submit" class="bg-green-600 hover:bg-green-700">
                                        Simpan
                                    </x-buttons.primary-button>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- Form Filter & Search --}}
                    <form method="GET" action="{{ route('dashboard.item.index') }}"
                        class="w-full flex justify-end gap-1" x-data="{ openFilter: '' }">

                        {{-- Filter: Tanggal Mulai --}}
                        <div class="relative">
                            <button type="button"
                                @click="requestAnimationFrame(() => openFilter = openFilter === 'start_date' ? '' : 'start_date')"
                                class="cursor-pointer bg-white border border-gray-300 rounded-md p-2 hover:ring-1 hover:ring-blue-500">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                    class="bi bi-calendar-check size-5" viewBox="0 0 16 16">
                                    <path
                                        d="M10.854 7.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708 0" />
                                    <path
                                        d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4z" />
                                </svg>
                            </button>
                            <div x-show="openFilter === 'start_date'" @click.away="openFilter = ''" x-transition
                                class="absolute z-10 mt-2 w-48 bg-white border border-gray-300 rounded-md shadow-lg p-3">
                                <label class="block text-xs text-gray-500 mb-1">Tanggal Mulai</label>
                                <input type="date" name="start_date" value="{{ request('start_date') }}"
                                    x-on:input.debounce.500ms="$root.submit()"
                                    class="block w-full px-3 py-2 text-sm border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500" />
                            </div>
                        </div>

                        {{-- Filter: Tanggal Selesai --}}
                        <div class="relative">
                            <button type="button"
                                @click="requestAnimationFrame(() => openFilter = openFilter === 'end_date' ? '' : 'end_date')"
                                class="cursor-pointer bg-white border border-gray-300 rounded-md p-2 hover:ring-1 hover:ring-blue-500">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                    class="bi bi-calendar-x size-5" viewBox="0 0 16 16">
                                    <path
                                        d="M6.146 7.146a.5.5 0 0 1 .708 0L8 8.293l1.146-1.147a.5.5 0 1 1 .708.708L8.707 9l1.147 1.146a.5.5 0 0 1-.708.708L8 9.707l-1.146 1.147a.5.5 0 0 1-.708-.708L7.293 9 6.146 7.854a.5.5 0 0 1 0-.708" />
                                    <path
                                        d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4z" />
                                </svg>
                            </button>
                            <div x-show="openFilter === 'end_date'" @click.away="openFilter = ''" x-transition
                                class="absolute z-10 mt-2 w-48 bg-white border border-gray-300 rounded-md shadow-lg p-3">
                                <label class="block text-xs text-gray-500 mb-1">Tanggal Selesai</label>
                                <input type="date" name="end_date" value="{{ request('end_date') }}"
                                    x-on:input.debounce.500ms="$root.submit()"
                                    class="block w-full px-3 py-2 text-sm border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500" />
                            </div>
                        </div>

                        {{-- Input Search --}}
                        <div class="w-full lg:w-80">
                            <x-forms.input type="text" name="search" placeholder="Cari nama atau sku barang..."
                                autocomplete="off" value="{{ request('search') }}"
                                x-on:input.debounce.500ms="$root.submit()"></x-forms.input>
                        </div>
                    </form>
                </div>

                {{-- Pagination --}}
                <div class="overflow-x-auto">
                    {{ $items->withQueryString()->links() }}
                </div>
            </div>
        </div>

        {{-- Flash Message --}}
        <x-alerts.flash-message />

        {{-- Table --}}
        <div class="bg-white rounded-lg border border-gray-300 shadow overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-[#486284] text-gray-50">
                    <tr>
                        <th class="p-2 font-normal text-center border-r border-gray-600">#</th>
                        <th class="p-2 font-normal text-center border-r border-gray-600">SKU</th>
                        <th class="p-2 font-normal text-left border-r border-gray-600">Nama Barang</th>
                        <th class="p-2 font-normal text-left border-r border-gray-600">Deskripsi</th>
                        <th class="p-2 font-normal text-center border-r border-gray-600">Stok</th>
                        <th class="p-2 font-normal text-center border-r border-gray-600">Dibuat</th>
                        <th class="p-2 font-normal text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-300">
                    @forelse($items as $item)
                        <tr class="hover:bg-blue-50">
                            <td class="p-2 text-center border-r border-gray-300">
                                {{ ($items->currentPage() - 1) * $items->perPage() + $loop->iteration }}</td>
                            <td class="p-2 text-center border-r border-gray-300 whitespace-nowrap">{{ $item->sku }}
                            </td>
                            <td class="p-2 border-r border-gray-300 whitespace-nowrap">{{ $item->name }}</td>
                            <td class="p-2 border-r border-gray-300 whitespace-nowrap">{{ $item->description }}</td>
                            <td class="p-2 text-center border-r border-gray-300 whitespace-nowrap">{{ $item->stock }}
                            </td>
                            <td class="p-2 text-center border-r border-gray-300 whitespace-nowrap">
                                {{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y H:i') }}
                            </td>
                            <td class="p-2 whitespace-nowrap">
                                <div class="flex justify-center items-center gap-2">
                                    <div x-data="{ openEdit: false }">
                                        {{-- Tombol Edit --}}
                                        <a @click="openEdit = true"
                                            class="text-yellow-600 hover:underline text-sm cursor-pointer">
                                            Edit
                                        </a>

                                        {{-- Modal Edit Items --}}
                                        <div x-show="openEdit"
                                            class="fixed inset-0 flex items-center justify-center bg-black/50 z-50">

                                            <div
                                                class="bg-white rounded-lg p-6 w-full max-w-lg max-h-[80vh] overflow-y-auto">
                                                <h2 class="text-lg font-semibold mb-4">Edit Data Barang</h2>

                                                <form method="POST"
                                                    action="{{ route('dashboard.item.update', $item->sku) }}">
                                                    @csrf
                                                    @method('PUT')

                                                    <div class="space-y-5">
                                                        <x-forms.input name="name" label="Nama Barang"
                                                            :value="old('name', $item->name)"></x-forms.input>
                                                        <x-forms.textarea name="description" label="Description"
                                                            :value="old('description', $item->description)" rows="2"></x-forms.textarea>
                                                        <div class="grid grid-cols-2 gap-5">
                                                            <div>
                                                                <label for="sku"
                                                                    class="block mb-1 text-sm font-medium text-gray-700">SKU</label>
                                                                <div
                                                                    class="mt-1 flex rounded-md border border-gray-300 focus-within:ring focus-within:ring-blue-500 focus-within:border-blue-500">
                                                                    <span
                                                                        class="inline-flex items-center px-3 text-sm text-gray-500 bg-gray-100 border-r border-gray-300 rounded-l-md">
                                                                        SKU-
                                                                    </span>
                                                                    <input id="sku" name="sku"
                                                                        type="number"
                                                                        value="{{ old('sku', str_replace('SKU-', '', $item->sku)) }}"
                                                                        class="w-full px-3 py-2 text-sm bg-white rounded-r-lg border-none focus:outline-none" />
                                                                </div>

                                                                @error('sku')
                                                                    <p class="mt-1 text-sm text-red-600">
                                                                        {{ $message }}</p>
                                                                @enderror
                                                            </div>
                                                            <x-forms.input name="stock" label="Stock Awal"
                                                                type="number" :value="old('stock', $item->stock)"></x-forms.input>
                                                        </div>
                                                    </div>

                                                    <div class="mt-3 flex justify-end gap-2">
                                                        <x-buttons.primary-button @click="openEdit = false"
                                                            class="bg-gray-600 hover:bg-gray-700">
                                                            Batal
                                                        </x-buttons.primary-button>
                                                        <x-buttons.primary-button type="submit"
                                                            class="bg-green-600 hover:bg-green-700">
                                                            Update
                                                        </x-buttons.primary-button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <form action="{{ route('dashboard.item.destroy', $item->sku) }}" method="POST"
                                        class="inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            class="text-red-600 hover:underline text-sm cursor-pointer">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-4 text-center text-gray-500">Tidak ada data barang</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

</x-app-layout>
