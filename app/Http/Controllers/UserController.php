<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Department;
use App\Models\Position;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    public function __construct()
    {
        // Akan lebih baik menggunakan middleware di level route, tapi memastikan di sini juga aman
    }

    public function index()
    {
        if (!auth()->user()->hasRole('admin')) abort(403);

        $users = User::with(['department', 'position', 'roles'])->paginate(10);
        return view('users.index', compact('users'));
    }

    public function create()
    {
        if (!auth()->user()->hasRole('admin')) abort(403);

        $departments = Department::all();
        $positions = Position::all();
        $roles = Role::whereIn('name', ['admin', 'staf-loket', 'karyawan'])->get();

        return view('users.create', compact('departments', 'positions', 'roles'));
    }

    public function store(Request $request)
    {
        if (!auth()->user()->hasRole('admin')) abort(403);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'department_id' => ['nullable', 'exists:departments,id'],
            'position_id' => ['nullable', 'exists:positions,id'],
            'role' => ['required', 'exists:roles,name'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'department_id' => $request->department_id,
            'position_id' => $request->position_id,
        ]);

        $user->assignRole($request->role);

        return redirect()->route('users.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        if (!auth()->user()->hasRole('admin')) abort(403);

        $departments = Department::all();
        $positions = Position::all();
        $roles = Role::whereIn('name', ['admin', 'staf-loket', 'karyawan'])->get();

        return view('users.edit', compact('user', 'departments', 'positions', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        if (!auth()->user()->hasRole('admin')) abort(403);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'department_id' => ['nullable', 'exists:departments,id'],
            'position_id' => ['nullable', 'exists:positions,id'],
            'role' => ['required', 'exists:roles,name'],
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'department_id' => $request->department_id,
            'position_id' => $request->position_id,
        ]);

        // Update password only if provided
        if ($request->filled('password')) {
            $request->validate(['password' => ['confirmed', Rules\Password::defaults()]]);
            $user->update(['password' => Hash::make($request->password)]);
        }

        $user->syncRoles([$request->role]);

        return redirect()->route('users.index')->with('success', 'Data pengguna berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if (!auth()->user()->hasRole('admin')) abort(403);
        
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();
        return redirect()->route('users.index')->with('success', 'Pengguna berhasil dihapus.');
    }
}
