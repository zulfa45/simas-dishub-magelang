<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Position;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{
    public function index()
    {
        if (!auth()->user()->hasRole('admin')) abort(403);

        $departments = Department::withCount('users')->get();
        $positions = Position::withCount('users')->get();

        return view('organizations.index', compact('departments', 'positions'));
    }

    public function storeDepartment(Request $request)
    {
        if (!auth()->user()->hasRole('admin')) abort(403);
        
        $request->validate(['name' => 'required|string|max:255|unique:departments,name']);
        Department::create(['name' => $request->name]);
        
        return back()->with('success', 'Departemen / Bagian berhasil ditambahkan.');
    }

    public function destroyDepartment(Department $department)
    {
        if (!auth()->user()->hasRole('admin')) abort(403);
        
        if ($department->users()->count() > 0) {
            return back()->with('error', 'Tidak dapat menghapus departemen yang masih memiliki anggota/pengguna.');
        }

        $department->delete();
        return back()->with('success', 'Departemen berhasil dihapus.');
    }

    public function storePosition(Request $request)
    {
        if (!auth()->user()->hasRole('admin')) abort(403);
        
        $request->validate(['name' => 'required|string|max:255|unique:positions,name']);
        Position::create(['name' => $request->name]);
        
        return back()->with('success', 'Jabatan berhasil ditambahkan.');
    }

    public function destroyPosition(Position $position)
    {
        if (!auth()->user()->hasRole('admin')) abort(403);
        
        if ($position->users()->count() > 0) {
            return back()->with('error', 'Tidak dapat menghapus jabatan yang masih digunakan oleh pengguna.');
        }

        $position->delete();
        return back()->with('success', 'Jabatan berhasil dihapus.');
    }
}
