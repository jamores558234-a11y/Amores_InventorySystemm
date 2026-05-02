{{-- FILE PATH: resources/views/users/edit.blade.php --}}
@extends('layouts.app')
@section('title', 'Edit User')
@section('page-title', 'Edit User')
@section('page-subtitle', 'Admin Control')

@section('content')

<div class="breadcrumb">
    <a href="{{ route('users.index') }}">Manage Users</a>
    <span class="sep">›</span>
    <span class="current">Edit — {{ $user->name }}</span>
</div>

<div class="page-header">
    <div>
        <h1>Edit User</h1>
        <p>Update account details and role for <strong>{{ $user->name }}</strong>.</p>
    </div>
    <a href="{{ route('users.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Back</a>
</div>

<form method="POST" action="{{ route('users.update', $user) }}">
    @csrf @method('PUT')
    <div style="display:grid;grid-template-columns:1fr 320px;gap:20px;align-items:start;">

        <div class="card">
            <div class="card-header">
                <span class="card-title"><i class="fas fa-pen" style="color:var(--gold);margin-right:8px;"></i>User Information</span>
                @if($user->id === Auth::id())
                <span class="badge badge-green">● Your Account</span>
                @endif
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label class="form-label">Full Name <span style="color:var(--red)">*</span></label>
                    <input type="text" name="name" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                        value="{{ old('name', $user->name) }}" required>
                    @error('name')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Email Address <span style="color:var(--red)">*</span></label>
                    <input type="email" name="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                        value="{{ old('email', $user->email) }}" required>
                    @error('email')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>

                <div style="background:var(--amber2);border:1px solid #f0d080;border-radius:var(--radius);padding:12px 16px;font-size:13px;color:var(--amber);margin-bottom:16px;">
                    <i class="fas fa-circle-info"></i> Leave password fields blank to keep the current password.
                </div>

                <div class="form-grid-2">
                    <div class="form-group">
                        <label class="form-label">New Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Leave blank to keep">
                        @error('password')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Repeat new password">
                    </div>
                </div>
            </div>
        </div>

        <div>
            <div class="card" style="margin-bottom:16px;">
                <div class="card-header"><span class="card-title">Role Assignment</span></div>
                <div class="card-body">
                    <div class="form-group" style="margin-bottom:0;">
                        <label class="form-label">Role <span style="color:var(--red)">*</span></label>
                        <select name="role" class="form-select" required>
                            <option value="admin"   {{ old('role', $user->role) === 'admin'   ? 'selected' : '' }}>🛡️ Administrator</option>
                            <option value="manager" {{ old('role', $user->role) === 'manager' ? 'selected' : '' }}>📦 Inventory Manager</option>
                            <option value="staff"   {{ old('role', $user->role) === 'staff'   ? 'selected' : '' }}>👤 Staff</option>
                        </select>
                    </div>
                </div>
            </div>

            {{-- Current user info --}}
            <div style="background:var(--gray1);border:1px solid var(--gray2);border-radius:10px;padding:16px;margin-bottom:16px;font-size:12px;">
                <div style="font-weight:700;color:var(--text);margin-bottom:8px;">Current Info</div>
                <div style="color:var(--text2);line-height:1.9;">
                    <div><span style="color:var(--gray4);">Role:</span>
                        <strong>{{ $user->getRoleLabel() }}</strong>
                    </div>
                    <div><span style="color:var(--gray4);">Joined:</span>
                        {{ $user->created_at->format('M d, Y') }}
                    </div>
                    <div><span style="color:var(--gray4);">Last updated:</span>
                        {{ $user->updated_at->format('M d, Y') }}
                    </div>
                </div>
            </div>

            <div style="display:flex;flex-direction:column;gap:8px;">
                <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;">
                    <i class="fas fa-save"></i> Save Changes
                </button>
                <a href="{{ route('users.index') }}" class="btn btn-outline" style="width:100%;justify-content:center;">Cancel</a>
            </div>
        </div>
    </div>
</form>
@endsection