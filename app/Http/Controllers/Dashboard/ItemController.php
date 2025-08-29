<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Item;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ItemController extends Controller
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

        // Semua Items
        $items = Item::when($search, function ($query, $search) {
            return $query->where(function ($query) use ($search) {
                $query->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('sku', 'LIKE', "{$search}%");
            });
        })
            ->when($start_date, function ($query) use ($start_date) {
                return $query->whereDate('created_at', '>=', $start_date);
            })
            ->when($end_date, function ($query) use ($end_date) {
                return $query->whereDate('created_at', '<=', $end_date);
            })
            ->orderBy('name', 'ASC')
            ->paginate(20);

        return view('dashboard.items.index', compact('items'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'sku' => [
                'required',
                'numeric',
                'digits_between:1,10',
                function ($attribute, $value, $fail) {
                    // Format SKU menjadi SKU-XXX
                    $formattedSku = 'SKU-' . ltrim($value, '0');

                    // Cek apakah SKU sudah ada di database
                    if (Item::where('sku', $formattedSku)->exists()) {
                        $fail("{$formattedSku} sudah terdaftar.");
                    }
                },
            ],
            'stock' => 'required|integer|min:0',
        ]);

        // Format ulang SKU
        $formattedSku = 'SKU-' . ltrim($validated['sku'], '0');
        $validated['sku'] = $formattedSku;

        // Tambah data Barang
        Item::create($validated);

        return redirect()->route('dashboard.item.index')->with('success', 'Data barang berhasil ditambahkan.');
    }

    public function update(Request $request, string $sku)
    {
        // Ambil data barang berdasarkan SKU
        $item = Item::where('sku', $sku)->firstOrFail();

        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'sku' => [
                'required',
                'numeric',
                'digits_between:1,10',
                function ($attribute, $value, $fail) use ($item) {
                    // Format SKU jadi SKU-XXX
                    $formattedSku = 'SKU-' . ltrim($value, '0');

                    // Cek apakah SKU sudah ada selain milik item ini
                    if (Item::where('sku', $formattedSku)->where('id', '!=', $item->id)->exists()) {
                        $fail("{$formattedSku} sudah terdaftar.");
                    }
                },
            ],
            'stock' => 'required|integer|min:0',
        ]);

        // Format ulang SKU
        $formattedSku = 'SKU-' . ltrim($validated['sku'], '0');
        $validated['sku'] = $formattedSku;

        // Update data barang
        $item->update($validated);

        return redirect()->route('dashboard.item.index')->with('success', 'Data barang berhasil diperbarui.');
    }

    public function destroy(string $sku)
    {
        // Ambil data barang berdasarkan SKU
        $item = Item::where('sku', $sku)->firstOrFail();

        // Hapus data Barang
        $item->delete();

        return redirect()->route('dashboard.item.index')->with('success', 'Data barang berhasil dihapus.');
    }
}
