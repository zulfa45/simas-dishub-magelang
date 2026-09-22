<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole('admin')) {
            return view('dashboard.admin');
        } elseif ($user->hasRole('staf-loket')) {
            return view('dashboard.staff');
        } else {
            return view('dashboard.employee');
        }
    }
}
