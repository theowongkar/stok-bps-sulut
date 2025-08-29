<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Item;
use App\Models\Employee;
use App\Models\StockOut;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StockOutController extends Controller
{
    public function index(Request $request)
    {
        // Validasi Search Form
        $validated = $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'search' => 'nullable|string|min:1',
        ]);

        // Ambil Nilai
        $start_date = $validated['start_date'] ?? null;
        $end_date = $validated['end_date'] ?? null;
        $search = $validated['search'] ?? null;

        // Semua Stock Out
        $stockOuts = StockOut::with('item', 'employee')->when($search, function ($query, $search) {
            return $query->whereHas('item', function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('sku', 'LIKE', "{$search}%");
            });
        })
            ->when($start_date, function ($query) use ($start_date) {
                return $query->whereDate('created_at', '>=', $start_date);
            })
            ->when($end_date, function ($query) use ($end_date) {
                return $query->whereDate('created_at', '<=', $end_date);
            })
            ->latest()
            ->paginate(20);

        // Semua Barang
        $items = Item::orderBy('name')->get();

        // Semua Pengguna
        $employees = Employee::orderBy('name')->get();

        return view('dashboard.stock-outs.index', compact('stockOuts', 'items', 'employees'));
    }

    public function store(Request $request)
    {
        // Validasi
        $validated = $request->validate([
            'item_id' => 'required|exists:items,id',
            'employee_id' => 'required|exists:employees,id',
            'quantity' => 'required|integer|min:1',
            'note' => 'nullable|string|max:255',
        ]);

        // Ambil barang
        $item = Item::findOrFail($validated['item_id']);

        // Cek stok cukup atau tidak
        if ($item->stock < $validated['quantity']) {
            return back()->with('error', 'Stok barang tidak mencukupi!');
        }

        // Simpan transaksi barang keluar
        $stockOut = StockOut::create([
            'item_id' => $validated['item_id'],
            'employee_id' => $validated['employee_id'],
            'quantity' => $validated['quantity'],
            'note' => $validated['note'] ?? null,
        ]);

        // Update stok barang
        $item->decrement('stock', $validated['quantity']);

        return redirect()
            ->route('dashboard.stock-out.index')
            ->with('success', 'Barang keluar berhasil disimpan!');
    }

    public function destroy(string $id)
    {
        // Cari data barang keluar
        $stockOut = StockOut::findOrFail($id);

        // Kembalikan stok ke item
        $item = Item::findOrFail($stockOut->item_id);
        $item->increment('stock', $stockOut->quantity);

        // Hapus transaksi barang keluar
        $stockOut->delete();

        return redirect()
            ->route('dashboard.stock-out.index')
            ->with('success', 'Data barang keluar berhasil dihapus dan stok dikembalikan.');
    }
}
