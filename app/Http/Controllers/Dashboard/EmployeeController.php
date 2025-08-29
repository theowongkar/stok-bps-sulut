<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        // Validasi Search Form
        $validated = $request->validate([
            'gender' => 'nullable|string|in:Laki-laki,Perempuan',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'search' => 'nullable|string|min:1',
        ]);

        // Ambil Nilai
        $gender = $validated['gender'] ?? null;
        $start_date = $validated['start_date'] ?? null;
        $end_date = $validated['end_date'] ?? null;
        $search = $validated['search'] ?? null;

        // Semua Karyawan
        $employees = Employee::when($search, function ($query, $search) {
            return $query->where(function ($query) use ($search) {
                $query->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('nip', 'LIKE', "{$search}%");
            });
        })
            ->when($gender, function ($query) use ($gender) {
                return $query->where('gender', $gender);
            })
            ->when($start_date, function ($query) use ($start_date) {
                return $query->whereDate('created_at', '>=', $start_date);
            })
            ->when($end_date, function ($query) use ($end_date) {
                return $query->whereDate('created_at', '<=', $end_date);
            })
            ->orderBy('name', 'ASC')
            ->paginate(20);

        return view('dashboard.employees.index', compact('employees'));
    }

    public function store(Request $request)
    {
        // Validasi Input
        $validated = $request->validate([
            'nip'        => 'required|numeric|unique:employees,nip',
            'name'       => 'required|string|max:255',
            'gender'     => 'required|in:Laki-laki,Perempuan',
            'department' => 'required|string|max:255',
            'phone'      => 'nullable|string|max:30',
            'avatar'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Simpan avatar (jika ada)
        if ($request->hasFile('avatar')) {
            $request->file('avatar')->store('employees', 'public');
        }

        // Simpan Employee
        Employee::create($validated);

        return redirect()->route('dashboard.employee.index')->with('success', 'Pegawai berhasil ditambahkan');
    }

    public function update(Request $request, string $nip)
    {
        // Ambil data pegawai berdasarkan NIP
        $employee = Employee::where('nip', $nip)->firstOrFail();

        // Validasi Input
        $validated = $request->validate([
            'nip'        => 'required|numeric|unique:employees,nip,' . $employee->id,
            'name'       => 'required|string|max:255',
            'gender'     => 'required|in:Laki-laki,Perempuan',
            'department' => 'required|string|max:255',
            'phone'      => 'nullable|string|max:30',
            'avatar'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Simpan avatar (jika ada)
        if ($request->hasFile('avatar')) {
            // Hapus avatar lama jika ada
            if ($employee->avatar && Storage::disk('public')->exists($employee->avatar)) {
                Storage::disk('public')->delete($employee->avatar);
            }
            $validated['avatar'] = $request->file('avatar')->store('employees', 'public');
        }

        // Update Employee
        $employee->update($validated);

        return redirect()->route('dashboard.employee.index')->with('success', 'Pegawai berhasil diupdate');
    }


    public function destroy(string $nip)
    {
        // Ambil data pegawai berdasarkan NIP
        $employee = Employee::where('nip', $nip)->firstOrFail();

        // Hapus avatar jika ada
        if ($employee->avatar && Storage::disk('public')->exists($employee->avatar)) {
            Storage::disk('public')->delete($employee->avatar);
        }

        // Hapus user login terkait (jika ada relasi ke user)
        if ($employee->user) {
            $employee->user->delete();
        }

        // Hapus data pegawai
        $employee->delete();

        return redirect()->back()->with('success', 'Data pegawai berhasil dihapus.');
    }
}
