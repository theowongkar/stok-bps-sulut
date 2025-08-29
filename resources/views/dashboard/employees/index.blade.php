<x-app-layout>

    {{-- Judul Halaman --}}
    <x-slot name="title">Data Pegawai</x-slot>

    {{-- Bagian Pegawai --}}
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

                    {{-- Modal Create Employees --}}
                    <div x-show="openCreate" class="fixed inset-0 flex items-center justify-center bg-black/50 z-50">

                        <div class="bg-white rounded-lg p-6 w-full max-w-lg max-h-[80vh] overflow-y-auto">
                            <h2 class="text-lg font-semibold mb-4">Tambah Pegawai</h2>

                            <form method="POST" action="{{ route('dashboard.employee.store') }}"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                    <x-forms.input name="nip" label="NIP" type="number"></x-forms.input>
                                    <x-forms.input name="name" label="Nama"></x-forms.input>
                                    <x-forms.select name="gender" label="Jenis Kelamin"
                                        :options="['Laki-laki', 'Perempuan']"></x-forms.select>
                                    <x-forms.input name="department" label="Departemen"></x-forms.input>
                                    <x-forms.input name="phone" label="No. Telepon (Opsional)"></x-forms.input>
                                    <x-forms.input name="avatar" label="Avatar" type="file"
                                        accept="image/*"></x-forms.input>
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
                    <form method="GET" action="{{ route('dashboard.employee.index') }}"
                        class="w-full flex justify-end gap-1" x-data="{ openFilter: '' }">

                        {{-- Filter: Jenis Kelamin --}}
                        <div class="relative">
                            <button type="button"
                                @click="requestAnimationFrame(() => openFilter = openFilter === 'gender' ? '' : 'gender')"
                                class="cursor-pointer bg-white border border-gray-300 rounded-md p-2 hover:ring-1 hover:ring-blue-500">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                    class="bi bi-gender-ambiguous size-5" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                        d="M11.5 1a.5.5 0 0 1 0-1h4a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-1 0V1.707l-3.45 3.45A4 4 0 0 1 8.5 10.97V13H10a.5.5 0 0 1 0 1H8.5v1.5a.5.5 0 0 1-1 0V14H6a.5.5 0 0 1 0-1h1.5v-2.03a4 4 0 1 1 3.471-6.648L14.293 1zm-.997 4.346a3 3 0 1 0-5.006 3.309 3 3 0 0 0 5.006-3.31z" />
                                </svg>
                            </button>
                            <div x-show="openFilter === 'gender'" @click.away="openFilter = ''" x-transition
                                class="absolute z-10 mt-2 w-48 bg-white border border-gray-300 rounded-md shadow-lg p-3">
                                <label class="block text-xs text-gray-500 mb-1">Jenis Kelamin</label>
                                <select name="gender" x-on:change="$root.submit()"
                                    class="block w-full px-3 py-2 text-sm border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500">
                                    <option value="" @selected(request('gender') === '')>Semua</option>
                                    <option value="Laki-laki" @selected(request('gender') === 'Laki-laki')>Laki-laki</option>
                                    <option value="Perempuan" @selected(request('gender') === 'Perempuan')>Perempuan</option>
                                </select>
                            </div>
                        </div>

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
                            <x-forms.input type="text" name="search" placeholder="Cari nama atau nip pegawai..."
                                autocomplete="off" value="{{ request('search') }}"
                                x-on:input.debounce.500ms="$root.submit()"></x-forms.input>
                        </div>
                    </form>
                </div>

                {{-- Pagination --}}
                <div class="overflow-x-auto">
                    {{ $employees->withQueryString()->links() }}
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
                        <th class="p-2 font-normal text-left border-r border-gray-600">NIP</th>
                        <th class="p-2 font-normal text-left border-r border-gray-600">Nama</th>
                        <th class="p-2 font-normal text-left border-r border-gray-600">Jenis Kelamin</th>
                        <th class="p-2 font-normal text-left border-r border-gray-600">Departemen</th>
                        <th class="p-2 font-normal text-center border-r border-gray-600">Dibuat</th>
                        <th class="p-2 font-normal text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-300">
                    @forelse($employees as $employee)
                        <tr class="hover:bg-blue-50">
                            <td class="p-2 text-center border-r border-gray-300">
                                {{ ($employees->currentPage() - 1) * $employees->perPage() + $loop->iteration }}</td>
                            <td class="p-2 border-r border-gray-300 whitespace-nowrap">{{ $employee->nip }}</td>
                            <td class="p-2 border-r border-gray-300 whitespace-nowrap">{{ $employee->name }}</td>
                            <td class="p-2 border-r border-gray-300 whitespace-nowrap">{{ $employee->gender }}</td>
                            <td class="p-2 border-r border-gray-300 whitespace-nowrap">{{ $employee->department }}
                            </td>
                            <td class="p-2 text-center border-r border-gray-300 whitespace-nowrap">
                                {{ \Carbon\Carbon::parse($employee->created_at)->format('d/m/Y H:i') }}
                            </td>
                            <td class="p-2 whitespace-nowrap">
                                <div class="flex justify-center items-center gap-2">
                                    <div x-data="{ openEdit: false }">
                                        {{-- Tombol Edit --}}
                                        <a @click="openEdit = true"
                                            class="text-yellow-600 hover:underline text-sm cursor-pointer">
                                            Edit
                                        </a>

                                        {{-- Modal Edit Employees --}}
                                        <div x-show="openEdit"
                                            class="fixed inset-0 flex items-center justify-center bg-black/50 z-50">

                                            <div
                                                class="bg-white rounded-lg p-6 w-full max-w-lg max-h-[80vh] overflow-y-auto">
                                                <h2 class="text-lg font-semibold mb-4">Edit Pegawai</h2>

                                                <form method="POST"
                                                    action="{{ route('dashboard.employee.update', $employee->nip) }}"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')

                                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                                        <x-forms.input name="nip" label="NIP" type="number"
                                                            :value="old('nip', $employee->nip)"></x-forms.input>
                                                        <x-forms.input name="name" label="Nama"
                                                            :value="old('name', $employee->name)"></x-forms.input>
                                                        <x-forms.select name="gender" label="Jenis Kelamin"
                                                            :options="['Laki-laki', 'Perempuan']" :selected="old('gender', $employee->gender)"></x-forms.select>
                                                        <x-forms.input name="department" label="Departemen"
                                                            :value="old('department', $employee->department)"></x-forms.input>
                                                        <x-forms.input name="phone" label="No. Telepon (Opsional)"
                                                            :value="old('phone', $employee->phone)"></x-forms.input>
                                                        <x-forms.input name="avatar" label="Avatar" type="file"
                                                            accept="image/*"></x-forms.input>
                                                    </div>

                                                    {{-- Preview Avatar Lama --}}
                                                    @if ($employee->avatar)
                                                        <div class="mt-2 w-full h-52 overflow-auto">
                                                            <p class="text-sm text-gray-500">Avatar saat ini:</p>
                                                            <img src="{{ asset('storage/' . $employee->avatar) }}"
                                                                alt="Avatar" class="w-full h-full rounded-md mt-1">
                                                        </div>
                                                    @endif

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

                                    <form action="{{ route('dashboard.employee.destroy', $employee->nip) }}"
                                        method="POST" class="inline"
                                        onsubmit="return confirm('Yakin ingin menghapus?')">
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
                            <td colspan="7" class="p-4 text-center text-gray-500">Tidak ada data karyawan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

</x-app-layout>
