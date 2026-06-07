<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->hasRole('gs')) {
            return redirect()->route('gs.dashboard');
        } elseif ($user->hasRole('formateur')) {
            return redirect()->route('formateur.dashboard');
        }
        return view('dashboard');
    }
}
