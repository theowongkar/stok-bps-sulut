<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Item;
use App\Models\StockIn;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StockInController extends Controller
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

        // Semua Stock In
        $stockIns = StockIn::with('item')->when($search, function ($query, $search) {
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

        return view('dashboard.stock-ins.index', compact('stockIns', 'items'));
    }

    public function store(Request $request)
    {
        // Validasi Input
        $validated = $request->validate([
            'item_id' => 'required|exists:items,id',
            'quantity' => 'required|integer|min:1',
            'note' => 'nullable|string',
        ]);

        // Simpan Stock In
        $stockIn = StockIn::create($validated);

        // Tambahkan jumlah stok ke item terkait
        $item = Item::findOrFail($validated['item_id']);
        $item->increment('stock', $validated['quantity']);

        return redirect()->route('dashboard.stock-in.index')
            ->with('success', 'Barang masuk berhasil disimpan dan stok ditambahkan.');
    }


    public function destroy(string $id)
    {
        // Cari data stock-in berdasarkan ID
        $stockIn = StockIn::findOrFail($id);

        // Cari item terkait
        $item = Item::findOrFail($stockIn->item_id);

        // Kurangi stok sesuai quantity di stock-in
        $item->decrement('stock', $stockIn->quantity);

        // Pastikan stok tidak minus
        if ($item->stock < 0) {
            $item->stock = 0;
            $item->save();
        }

        // Hapus record stock-in
        $stockIn->delete();

        return redirect()->route('dashboard.stock-in.index')
            ->with('success', 'Data barang masuk berhasil dihapus dan stok diperbarui.');
    }
}
