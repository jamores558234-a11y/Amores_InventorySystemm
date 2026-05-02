{{-- FILE PATH: resources/views/users/create.blade.php --}}
@extends('layouts.app')
@section('title', 'Add User')
@section('page-title', 'Add User')
@section('page-subtitle', 'Admin Control')

@section('content')

<div class="breadcrumb">
    <a href="{{ route('users.index') }}">Manage Users</a>
    <span class="sep">›</span>
    <span class="current">Add New User</span>
</div>

<div class="page-header">
    <div>
        <h1>Add New User</h1>
        <p>Create a new system account and assign a role.</p>
    </div>
    <a href="{{ route('users.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Back</a>
</div>

<form method="POST" action="{{ route('users.store') }}">
    @csrf
    <div style="display:grid;grid-template-columns:1fr 320px;gap:20px;align-items:start;">

        <div class="card">
            <div class="card-header">
                <span class="card-title"><i class="fas fa-user-plus" style="color:var(--gold);margin-right:8px;"></i>User Information</span>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label class="form-label">Full Name <span style="color:var(--red)">*</span></label>
                    <input type="text" name="name" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                        value="{{ old('name') }}" placeholder="e.g. Juan Dela Cruz" required>
                    @error('name')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Email Address <span style="color:var(--red)">*</span></label>
                    <input type="email" name="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                        value="{{ old('email') }}" placeholder="e.g. juan@company.com" required>
                    @error('email')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>

                <div class="form-grid-2">
                    <div class="form-group">
                        <label class="form-label">Password <span style="color:var(--red)">*</span></label>
                        <input type="password" name="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                            placeholder="Minimum 6 characters" required>
                        @error('password')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Confirm Password <span style="color:var(--red)">*</span></label>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Repeat password" required>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <div class="card" style="margin-bottom:16px;">
                <div class="card-header"><span class="card-title">Assign Role</span></div>
                <div class="card-body">
                    <div class="form-group" style="margin-bottom:0;">
                        <label class="form-label">Role <span style="color:var(--red)">*</span></label>
                        <select name="role" class="form-select {{ $errors->has('role') ? 'is-invalid' : '' }}" required>
                            <option value="">— Select Role —</option>
                            <option value="admin"   {{ old('role') === 'admin'   ? 'selected' : '' }}>🛡️ Administrator</option>
                            <option value="manager" {{ old('role') === 'manager' ? 'selected' : '' }}>📦 Inventory Manager</option>
                            <option value="staff"   {{ old('role') === 'staff'   ? 'selected' : '' }}>👤 Staff</option>
                        </select>
                        @error('role')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>

            {{-- Role info box --}}
            <div style="background:var(--gray1);border:1px solid var(--gray2);border-radius:10px;padding:16px;margin-bottom:16px;font-size:12px;color:var(--text2);line-height:1.9;">
                <div style="font-weight:700;color:var(--text);margin-bottom:8px;">Role Permissions:</div>
                <div><span style="color:var(--gold);font-weight:600;">🛡️ Admin</span> — Manage users, configure system</div>
                <div><span style="color:var(--purple);font-weight:600;">📦 Manager</span> — Add, edit, delete products</div>
                <div><span style="color:var(--teal);font-weight:600;">👤 Staff</span> — View & monitor stock only</div>
            </div>

            <div style="display:flex;flex-direction:column;gap:8px;">
                <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;">
                    <i class="fas fa-user-plus"></i> Create User
                </button>
                <a href="{{ route('users.index') }}" class="btn btn-outline" style="width:100%;justify-content:center;">Cancel</a>
            </div>
        </div>
    </div>
</form>
@endsection