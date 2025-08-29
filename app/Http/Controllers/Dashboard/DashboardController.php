<?php

namespace App\Http\Controllers\Dashboard;

use Carbon\Carbon;
use App\Models\StockIn;
use App\Models\Employee;
use App\Models\StockOut;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        // Set locale ke Bahasa Indonesia
        Carbon::setLocale('id');

        // Data Pegawai
        $totalEmployees = Employee::count();
        $maleEmployees = Employee::where('gender', 'Laki-Laki')->count();
        $femaleEmployees = Employee::where('gender', 'Perempuan')->count();

        // Ambil tahun saat ini
        $currentYear = now()->year;

        // Nama bulan dalam bahasa Indonesia
        $months = collect(range(1, 12))->map(function ($m) {
            return Carbon::create()->month($m)->translatedFormat('F');
        });

        // Jumlah Barang Masuk per Bulan
        $stockInPerMonth = collect(range(1, 12))->map(function ($month) use ($currentYear) {
            return StockIn::whereYear('created_at', $currentYear)
                ->whereMonth('created_at', $month)
                ->sum('quantity');
        });

        // Jumlah Barang Keluar per Bulan
        $stockOutPerMonth = collect(range(1, 12))->map(function ($month) use ($currentYear) {
            return StockOut::whereYear('created_at', $currentYear)
                ->whereMonth('created_at', $month)
                ->sum('quantity');
        });

        return view('dashboard.index', compact(
            'totalEmployees',
            'maleEmployees',
            'femaleEmployees',
            'months',
            'stockInPerMonth',
            'stockOutPerMonth',
            'currentYear'
        ));
    }
}
