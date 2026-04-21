<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Cek apakah user yang login adalah Administrator
     */
    private function checkAdmin()
    {
        if (!auth()->check() || strtolower(trim(auth()->user()->role)) !== 'administrator') {
            abort(403, 'Akses ditolak');
        }
    }

    /**
     * Tampilkan daftar user
     */
    public function index(Request $request)
    {
        $query = User::where('isdeleted', 'N');

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%")
                  ->orWhere('role', 'like', "%{$request->search}%");
            });
        }

        $users = $query->latest()->get();

        return view('users.index', compact('users'));
    }

    /**
     * Tambah user baru
     */
    public function store(Request $request)
    {
        $this->checkAdmin();

        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role'     => 'required|in:administrator,user',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
            'isactive' => 'Y',
            'isdeleted'=> 'N',
        ]);

        return redirect()
            ->route('users.index')
            ->with('success', 'User berhasil ditambahkan');
    }

    /**
     * Update data user
     */
    public function update(Request $request, User $user)
    {
        $this->checkAdmin();

        $request->validate([
            'name'  => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role'  => 'required|in:administrator,user',
        ]);

        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
            'role'  => $request->role,
        ]);

        return redirect()
            ->route('users.index')
            ->with('success', 'User berhasil diupdate');
    }

    /**
     * Hapus user (soft delete)
     */
    public function destroy(User $user)
    {
        $this->checkAdmin();

        // Tidak boleh hapus diri sendiri
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak boleh hapus akun sendiri');
        }

        // Cek jika yang dihapus administrator
        if (strtolower(trim($user->role)) === 'administrator') {

            $adminCount = User::whereRaw('LOWER(TRIM(role)) = ?', ['administrator'])
                              ->where('isdeleted','N')
                              ->count();

            // Minimal harus ada 1 administrator
            if ($adminCount <= 1) {
                return back()->with('error', 'Minimal harus ada 1 Administrator');
            }
        }

        // Soft delete manual
        $user->update([
            'isdeleted' => 'Y'
        ]);

        return redirect()
            ->route('users.index')
            ->with('success', 'User berhasil dihapus');
    }
}