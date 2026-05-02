<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    public function index()
    {
        if (!Auth::user()->isAdmin()) {
            return redirect()->route('dashboard')
                ->with('error', 'Access Denied.');
        }
        return view('settings.index');
    }

    public function clearCache()
    {
        if (!Auth::user()->isAdmin()) {
            return redirect()->route('dashboard')
                ->with('error', 'Access Denied.');
        }
        return redirect()->route('settings.index')
            ->with('success', 'Cache cleared.');
    }
}