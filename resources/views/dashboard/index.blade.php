<x-app-layout>
    
    {{-- Script Tambahan --}}
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @endpush

    {{-- Judul Halaman --}}
    <x-slot name="title">Dashboard</x-slot>

    {{-- Bagian Statistik Pegawai --}}
    <section class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        {{-- Total Pegawai --}}
        <div
            class="p-6 bg-gray-50 rounded-xl border border-gray-200 hover:border-blue-400 transition-all duration-300 shadow-sm hover:shadow-md">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm font-medium text-gray-500">Jumlah Pegawai</span>
                <span class="text-xl">👥</span>
            </div>
            <p class="text-3xl font-bold text-blue-600">{{ $totalEmployees }}</p>
        </div>

        {{-- Pegawai Laki-Laki --}}
        <div
            class="p-6 bg-gray-50 rounded-xl border border-gray-200 hover:border-green-400 transition-all duration-300 shadow-sm hover:shadow-md">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm font-medium text-gray-500">Pegawai Laki-Laki</span>
                <span class="text-xl">👨‍💼</span>
            </div>
            <p class="text-3xl font-bold text-green-600">{{ $maleEmployees }}</p>
        </div>

        {{-- Pegawai Perempuan --}}
        <div
            class="p-6 bg-gray-50 rounded-xl border border-gray-200 hover:border-pink-400 transition-all duration-300 shadow-sm hover:shadow-md">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm font-medium text-gray-500">Pegawai Perempuan</span>
                <span class="text-xl">👩‍💼</span>
            </div>
            <p class="text-3xl font-bold text-pink-600">{{ $femaleEmployees }}</p>
        </div>
    </section>

    {{-- Bagian Grafik Barang Masuk & Keluar --}}
    <section class="bg-white p-6 rounded-xl shadow-md">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">
            Barang Masuk & Keluar - {{ now()->year }}
        </h2>
        <canvas id="monthlyChart" height="120"></canvas>
    </section>

    {{-- Chart.js CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    {{-- Script: Grafik Line --}}
    <script>
        const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
        new Chart(monthlyCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($months) !!},
                datasets: [{
                        label: 'Barang Masuk',
                        data: {!! json_encode($stockInPerMonth) !!},
                        borderColor: 'rgba(16, 185, 129, 1)',
                        backgroundColor: 'rgba(16, 185, 129, 0.2)',
                        tension: 0.4,
                        fill: true,
                        pointRadius: 4,
                    },
                    {
                        label: 'Barang Keluar',
                        data: {!! json_encode($stockOutPerMonth) !!},
                        borderColor: 'rgba(239, 68, 68, 1)',
                        backgroundColor: 'rgba(239, 68, 68, 0.2)',
                        tension: 0.4,
                        fill: true,
                        pointRadius: 4,
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top'
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false
                    }
                },
                interaction: {
                    mode: 'nearest',
                    axis: 'x',
                    intersect: false
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
    </script>

</x-app-layout>