<?php

namespace Database\Seeders;

use App\Models\Item;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\StockIn;
use App\Models\Employee;
use App\Models\StockOut;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@bpssulut.com',
        ]);

        // Buat beberapa karyawan
        $employees = Employee::factory()->count(10)->create();

        // Assign salah satu karyawan dengan user admin
        $employees->first()->update([
            'user_id' => $user->id,
        ]);

         // Buat item stok
        $items = Item::factory()->count(10)->create();
        
        foreach ($items as $item) {
            // Buat stok masuk
            $stockIns = StockIn::factory()->count(3)->create([
                'item_id' => $item->id,
            ]);

            // Buat stok keluar dengan employee acak
            $stockOuts = StockOut::factory()->count(2)->create([
                'item_id' => $item->id,
                'employee_id' => $employees->random()->id,
            ]);

            // Hitung ulang stok = total masuk - total keluar
            $totalIn = $stockIns->sum('quantity');
            $totalOut = $stockOuts->sum('quantity');
            $item->update(['stock' => $totalIn - $totalOut]);
        }
    }
}
