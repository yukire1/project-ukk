<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Penduduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('penduduk')->paginate(10);
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $penduduk = Penduduk::all();
        return view('users.create', compact('penduduk'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users,username',
            'password' => 'required|min:6',
            'role' => 'required',
        ]);

        User::create([
            'penduduk_id' => $request->penduduk_id,
            'username' => $request->username,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $penduduk = Penduduk::all();
        return view('users.edit', compact('user', 'penduduk'));
    }

    public function update(Request $request, User $user)
    {
        $user->update($request->only(['username', 'email', 'role']));
        return redirect()->route('users.index')->with('success', 'Data user diperbarui.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
    }
}
