<?php
// FILE PATH: app/Http/Controllers/UserController.php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    private function adminOnly()
    {
        if (!Auth::user()->isAdmin()) {
            return redirect()->route('dashboard')
                ->with('error', '🔒 Access Denied: Only Administrators can manage users.');
        }
        return null;
    }

    public function index()
    {
        if ($redirect = $this->adminOnly()) return $redirect;
        $users = User::latest()->paginate(10);
        $totalAdmins   = User::where('role', 'admin')->count();
        $totalManagers = User::where('role', 'manager')->count();
        $totalStaff    = User::where('role', 'staff')->count();
        return view('users.index', compact('users', 'totalAdmins', 'totalManagers', 'totalStaff'));
    }

    public function create()
    {
        if ($redirect = $this->adminOnly()) return $redirect;
        return view('users.create');
    }

    public function store(Request $request)
    {
        if ($redirect = $this->adminOnly()) return $redirect;

        $data = $request->validate([
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|email|unique:users',
            'role'                  => 'required|in:admin,manager,staff',
            'password'              => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required',
        ]);

        User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'role'     => $data['role'],
            'password' => Hash::make($data['password']),
        ]);

        return redirect()->route('users.index')
            ->with('success', "✅ User '{$data['name']}' created successfully.");
    }

    public function edit(User $user)
    {
        if ($redirect = $this->adminOnly()) return $redirect;
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        if ($redirect = $this->adminOnly()) return $redirect;

        $data = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role'  => 'required|in:admin,manager,staff',
        ]);

        $user->update($data);

        if ($request->filled('password')) {
            $request->validate([
                'password'              => 'min:6|confirmed',
                'password_confirmation' => 'required',
            ]);
            $user->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('users.index')
            ->with('success', "✅ User '{$user->name}' updated successfully.");
    }

    public function destroy(User $user)
    {
        if ($redirect = $this->adminOnly()) return $redirect;

        if ($user->id === Auth::id()) {
            return redirect()->route('users.index')
                ->with('error', '⚠️ You cannot delete your own account.');
        }

        $name = $user->name;
        $user->delete();

        return redirect()->route('users.index')
            ->with('success', "🗑️ User '{$name}' deleted.");
    }
}