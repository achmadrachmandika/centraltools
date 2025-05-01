<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class StaffController extends Controller
{

    public function index()
{
    // Mengambil semua data staff dari database
    $staffs = User::whereHas('roles', function($query) {
        $query->where('name', 'staff');
    })->get();

    // Mengirim data staff ke tampilan
    return view('admin.staff.index', compact('staffs'));
}


    public function create()
    {
        return view('admin.staff.create');
    }

  public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string',
        'site' => 'required|string',
        'email' => 'required|email|unique:users',
        'password' => 'required|string|min:6',
    ]);

    // Menyimpan data user baru
    $user = User::create([
        'name' => $request->name,
        'site' => $request->site,  // Menambahkan kolom site
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);

    // Menambahkan role staff
    $user->assignRole('staff');

    return redirect()->route('staff.create')->with('success', 'Staff berhasil dibuat.');
}

public function edit($id)
{
    $staff = User::findOrFail($id);
    return view('admin.staff.edit', compact('staff'));
}

public function update(Request $request, $id)
{
    // Validasi inputan form
    $request->validate([
        'name' => 'required|string',
        'email' => 'required|email|unique:users,email,' . $id,
        'site' => 'required|string',
        'password' => 'nullable|string|min:6',
    ]);

    // Ambil data staff berdasarkan ID
    $staff = User::findOrFail($id);

    // Update data staff
    $staff->name = $request->name;
    $staff->email = $request->email;
    $staff->site = $request->site;

    // Jika password tidak kosong, update password
    if ($request->filled('password')) {
        $staff->password = Hash::make($request->password);
    }

    $staff->save();

    return redirect()->route('staff.index')->with('success', 'Staff berhasil diperbarui.');
}

public function destroy($id)
{
    $staff = User::findOrFail($id);
    $staff->delete();
    return redirect()->route('staff.index')->with('success', 'Staff berhasil dihapus.');
}



}
