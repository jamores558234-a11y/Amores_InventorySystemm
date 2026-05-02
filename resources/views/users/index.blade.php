{{-- FILE PATH: resources/views/users/index.blade.php --}}
@extends('layouts.app')
@section('title', 'Manage Users')
@section('page-title', 'Manage Users')
@section('page-subtitle', 'Admin Control')

@section('content')

<div class="page-header">
    <div>
        <h1>User Management</h1>
        <p>Create, edit and manage system user accounts and roles.</p>
    </div>
    <a href="{{ route('users.create') }}" class="btn btn-primary">
        <i class="fas fa-user-plus"></i> Add New User
    </a>
</div>

{{-- STATS --}}
<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-bottom:22px;">
    <div class="stat-card">
        <div class="stat-icon" style="background:rgba(201,168,76,0.14);color:#9a7a20;">
            <i class="fas fa-shield-halved"></i>
        </div>
        <div>
            <div class="stat-label">Administrators</div>
            <div class="stat-value">{{ $totalAdmins }}</div>
            <div class="stat-sub">Full system access</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon purple">
            <i class="fas fa-boxes-stacked"></i>
        </div>
        <div>
            <div class="stat-label">Inventory Managers</div>
            <div class="stat-value">{{ $totalManagers }}</div>
            <div class="stat-sub">Can manage products</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon teal">
            <i class="fas fa-user"></i>
        </div>
        <div>
            <div class="stat-label">Staff</div>
            <div class="stat-value">{{ $totalStaff }}</div>
            <div class="stat-sub">View & monitor only</div>
        </div>
    </div>
</div>

{{-- USERS TABLE --}}
<div class="card">
    <div class="card-header">
        <span class="card-title"><i class="fas fa-users" style="color:var(--gold);margin-right:8px;"></i>All Users</span>
        <span style="font-size:12px;color:var(--gray4);">{{ $users->total() }} total accounts</span>
    </div>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email Address</th>
                    <th>Role</th>
                    <th>Permissions</th>
                    <th>Joined</th>
                    <th style="text-align:center;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td class="mono text-muted">{{ $user->id }}</td>
                    <td>
                        <div style="display:flex;align-items:center;gap:10px;">
                            <div style="width:34px;height:34px;border-radius:50%;background:{{ $user->getRoleBadgeColor() }};display:flex;align-items:center;justify-content:center;font-weight:700;font-size:13px;color:#fff;flex-shrink:0;">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                            <div>
                                <div style="font-weight:600;color:var(--text);">{{ $user->name }}</div>
                                @if($user->id === Auth::id())
                                    <div style="font-size:10px;color:var(--green);font-weight:600;">● You</div>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td style="color:var(--text2);">{{ $user->email }}</td>
                    <td>
                        @if($user->isAdmin())
                            <span class="badge badge-gold"><i class="fas fa-shield-halved"></i> Administrator</span>
                        @elseif($user->isInventoryManager())
                            <span class="badge badge-purple"><i class="fas fa-boxes-stacked"></i> Inv. Manager</span>
                        @else
                            <span class="badge badge-teal"><i class="fas fa-user"></i> Staff</span>
                        @endif
                    </td>
                    <td>
                        <div style="display:flex;flex-wrap:wrap;gap:4px;">
                            @if($user->isAdmin())
                                <span style="font-size:10px;background:rgba(201,168,76,0.1);color:#9a7a20;padding:2px 7px;border-radius:4px;">Manage Users</span>
                                <span style="font-size:10px;background:rgba(201,168,76,0.1);color:#9a7a20;padding:2px 7px;border-radius:4px;">Configure System</span>
                                <span style="font-size:10px;background:rgba(201,168,76,0.1);color:#9a7a20;padding:2px 7px;border-radius:4px;">View Inventory</span>
                            @elseif($user->isInventoryManager())
                                <span style="font-size:10px;background:var(--purple2);color:var(--purple);padding:2px 7px;border-radius:4px;">Add Product</span>
                                <span style="font-size:10px;background:var(--purple2);color:var(--purple);padding:2px 7px;border-radius:4px;">Update Product</span>
                                <span style="font-size:10px;background:var(--purple2);color:var(--purple);padding:2px 7px;border-radius:4px;">Delete Product</span>
                                <span style="font-size:10px;background:var(--purple2);color:var(--purple);padding:2px 7px;border-radius:4px;">Borrow/Return</span>
                            @else
                                <span style="font-size:10px;background:var(--teal2);color:var(--teal);padding:2px 7px;border-radius:4px;">View Products</span>
                                <span style="font-size:10px;background:var(--teal2);color:var(--teal);padding:2px 7px;border-radius:4px;">Monitor Stock</span>
                            @endif
                        </div>
                    </td>
                    <td class="text-muted" style="font-size:12px;">{{ $user->created_at->format('M d, Y') }}</td>
                    <td>
                        <div style="display:flex;gap:5px;justify-content:center;">
                            <a href="{{ route('users.edit', $user) }}" class="btn btn-outline btn-sm btn-icon" title="Edit User">
                                <i class="fas fa-pen"></i>
                            </a>
                            @if($user->id !== Auth::id())
                            <form method="POST" action="{{ route('users.destroy', $user) }}"
                                onsubmit="return confirm('Delete user \'{{ $user->name }}\'?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm btn-icon" title="Delete User">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                            @else
                            <span class="btn btn-outline btn-sm btn-icon" style="opacity:0.3;cursor:not-allowed;" title="Cannot delete yourself">
                                <i class="fas fa-trash"></i>
                            </span>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7">
                        <div class="empty-state">
                            <i class="fas fa-users"></i>
                            <p>No users found. <a href="{{ route('users.create') }}" style="color:var(--navy);font-weight:600;">Add the first user.</a></p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($users->hasPages())
    <div class="pagination-wrap">
        <span>Showing {{ $users->firstItem() }}–{{ $users->lastItem() }} of {{ $users->total() }}</span>
        <div class="pagination">
            @if($users->onFirstPage())
                <span class="page-item"><span class="page-link" style="opacity:0.4;">‹</span></span>
            @else
                <span class="page-item"><a class="page-link" href="{{ $users->previousPageUrl() }}">‹</a></span>
            @endif
            @foreach($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                <span class="page-item {{ $page == $users->currentPage() ? 'active' : '' }}">
                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                </span>
            @endforeach
            @if($users->hasMorePages())
                <span class="page-item"><a class="page-link" href="{{ $users->nextPageUrl() }}">›</a></span>
            @else
                <span class="page-item"><span class="page-link" style="opacity:0.4;">›</span></span>
            @endif
        </div>
    </div>
    @endif
</div>

{{-- ROLE GUIDE --}}
<div class="card mt-4">
    <div class="card-header">
        <span class="card-title"><i class="fas fa-circle-info" style="color:var(--gold);margin-right:8px;"></i>Role Permissions Guide</span>
    </div>
    <div class="card-body" style="display:grid;grid-template-columns:repeat(3,1fr);gap:16px;">
        <div style="border:1px solid rgba(201,168,76,0.3);border-radius:10px;padding:18px;border-top:3px solid var(--gold);">
            <div style="font-size:13px;font-weight:700;color:#9a7a20;margin-bottom:10px;"><i class="fas fa-shield-halved"></i> Administrator</div>
            <div style="font-size:12px;color:var(--text2);line-height:1.8;">
                ✅ Login<br>
                ✅ Manage Users<br>
                ✅ Configure System<br>
                ✅ View Inventory<br>
                ❌ Add/Edit/Delete Products
            </div>
        </div>
        <div style="border:1px solid rgba(99,102,241,0.3);border-radius:10px;padding:18px;border-top:3px solid var(--purple);">
            <div style="font-size:13px;font-weight:700;color:var(--purple);margin-bottom:10px;"><i class="fas fa-boxes-stacked"></i> Inventory Manager</div>
            <div style="font-size:12px;color:var(--text2);line-height:1.8;">
                ✅ Login<br>
                ✅ Add / Update / Delete Product<br>
                ✅ View Inventory<br>
                ✅ Request / Borrow / Return Item<br>
                ❌ Manage Users
            </div>
        </div>
        <div style="border:1px solid rgba(13,148,136,0.3);border-radius:10px;padding:18px;border-top:3px solid var(--teal);">
            <div style="font-size:13px;font-weight:700;color:var(--teal);margin-bottom:10px;"><i class="fas fa-user"></i> Staff</div>
            <div style="font-size:12px;color:var(--text2);line-height:1.8;">
                ✅ Login<br>
                ✅ View Products<br>
                ✅ Monitor Stock<br>
                ❌ Add/Edit/Delete Products<br>
                ❌ Manage Users
            </div>
        </div>
    </div>
</div>

@endsection