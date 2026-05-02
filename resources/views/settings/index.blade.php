{{-- FILE PATH: resources/views/settings/index.blade.php --}}
@extends('layouts.app')
@section('title', 'System Settings')
@section('page-title', 'Configure System')
@section('page-subtitle', 'Admin Control')

@section('content')

<div class="page-header">
    <div>
        <h1>System Configuration</h1>
        <p>Manage application settings and maintenance tools.</p>
    </div>
</div>

{{-- SYSTEM INFO --}}
<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-bottom:22px;">
    <div class="stat-card">
        <div class="stat-icon navy"><i class="fas fa-server"></i></div>
        <div>
            <div class="stat-label">PHP Version</div>
            <div class="stat-value" style="font-size:18px;">{{ PHP_VERSION }}</div>
            <div class="stat-sub">Server runtime</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon gold"><i class="fab fa-laravel"></i></div>
        <div>
            <div class="stat-label">Laravel Version</div>
            <div class="stat-value" style="font-size:18px;">{{ app()->version() }}</div>
            <div class="stat-sub">Framework</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon amber"><i class="fas fa-circle-dot"></i></div>
        <div>
            <div class="stat-label">Environment</div>
            <div class="stat-value" style="font-size:18px;text-transform:capitalize;">{{ config('app.env') }}</div>
            <div class="stat-sub">{{ config('app.debug') ? '⚠️ Debug ON' : '✅ Debug OFF' }}</div>
        </div>
    </div>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;">

    {{-- APP DETAILS --}}
    <div class="card">
        <div class="card-header">
            <span class="card-title">
                <i class="fas fa-gear" style="color:var(--gold);margin-right:8px;"></i>Application Details
            </span>
        </div>
        <div>
            <div style="display:flex;justify-content:space-between;align-items:center;padding:14px 22px;border-bottom:1px solid var(--gray2);">
                <span style="font-size:13px;color:var(--gray4);">App Name</span>
                <span style="font-size:13px;font-weight:600;color:var(--text);">{{ config('app.name') }}</span>
            </div>
            <div style="display:flex;justify-content:space-between;align-items:center;padding:14px 22px;border-bottom:1px solid var(--gray2);">
                <span style="font-size:13px;color:var(--gray4);">Environment</span>
                <span class="badge {{ config('app.env') === 'production' ? 'badge-green' : 'badge-amber' }}">
                    {{ config('app.env') }}
                </span>
            </div>
            <div style="display:flex;justify-content:space-between;align-items:center;padding:14px 22px;border-bottom:1px solid var(--gray2);">
                <span style="font-size:13px;color:var(--gray4);">Debug Mode</span>
                <span class="badge {{ config('app.debug') ? 'badge-red' : 'badge-green' }}">
                    {{ config('app.debug') ? 'Enabled' : 'Disabled' }}
                </span>
            </div>
            <div style="display:flex;justify-content:space-between;align-items:center;padding:14px 22px;border-bottom:1px solid var(--gray2);">
                <span style="font-size:13px;color:var(--gray4);">Database</span>
                <span style="font-size:13px;font-weight:600;color:var(--text);">{{ config('database.connections.mysql.database') }}</span>
            </div>
            <div style="display:flex;justify-content:space-between;align-items:center;padding:14px 22px;border-bottom:1px solid var(--gray2);">
                <span style="font-size:13px;color:var(--gray4);">PHP Version</span>
                <span style="font-size:13px;font-weight:600;color:var(--text);">{{ PHP_VERSION }}</span>
            </div>
            <div style="display:flex;justify-content:space-between;align-items:center;padding:14px 22px;">
                <span style="font-size:13px;color:var(--gray4);">Laravel Version</span>
                <span style="font-size:13px;font-weight:600;color:var(--text);">{{ app()->version() }}</span>
            </div>
        </div>
    </div>

    {{-- TOOLS & ADMIN INFO --}}
    <div style="display:flex;flex-direction:column;gap:16px;">

        {{-- MAINTENANCE --}}
        <div class="card">
            <div class="card-header">
                <span class="card-title">
                    <i class="fas fa-wrench" style="color:var(--gold);margin-right:8px;"></i>Quick Actions
                </span>
            </div>
            <div class="card-body" style="display:flex;flex-direction:column;gap:10px;padding:16px;">

                <form method="POST" action="{{ route('settings.clear-cache') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline"
                        style="width:100%;justify-content:flex-start;gap:12px;">
                        <div style="width:32px;height:32px;background:var(--gray1);border-radius:8px;display:flex;align-items:center;justify-content:center;">
                            <i class="fas fa-broom" style="color:var(--navy);"></i>
                        </div>
                        <div style="text-align:left;">
                            <div style="font-weight:600;font-size:13px;">Clear Cache</div>
                            <div style="font-size:11px;color:var(--gray4);">Remove cached files</div>
                        </div>
                    </button>
                </form>

                <a href="{{ route('users.index') }}" class="btn btn-outline"
                    style="width:100%;justify-content:flex-start;gap:12px;">
                    <div style="width:32px;height:32px;background:var(--purple2);border-radius:8px;display:flex;align-items:center;justify-content:center;">
                        <i class="fas fa-users-cog" style="color:var(--purple);"></i>
                    </div>
                    <div style="text-align:left;">
                        <div style="font-weight:600;font-size:13px;">Manage Users</div>
                        <div style="font-size:11px;color:var(--gray4);">Add, edit or remove accounts</div>
                    </div>
                </a>

                <a href="{{ route('products.index') }}" class="btn btn-outline"
                    style="width:100%;justify-content:flex-start;gap:12px;">
                    <div style="width:32px;height:32px;background:var(--teal2);border-radius:8px;display:flex;align-items:center;justify-content:center;">
                        <i class="fas fa-boxes-stacked" style="color:var(--teal);"></i>
                    </div>
                    <div style="text-align:left;">
                        <div style="font-weight:600;font-size:13px;">View Inventory</div>
                        <div style="font-size:11px;color:var(--gray4);">Browse all products</div>
                    </div>
                </a>

                <a href="{{ route('dashboard') }}" class="btn btn-outline"
                    style="width:100%;justify-content:flex-start;gap:12px;">
                    <div style="width:32px;height:32px;background:rgba(201,168,76,0.12);border-radius:8px;display:flex;align-items:center;justify-content:center;">
                        <i class="fas fa-chart-pie" style="color:var(--gold);"></i>
                    </div>
                    <div style="text-align:left;">
                        <div style="font-weight:600;font-size:13px;">Dashboard</div>
                        <div style="font-size:11px;color:var(--gray4);">Return to overview</div>
                    </div>
                </a>
            </div>
        </div>

        {{-- ADMIN CARD --}}
        <div class="card">
            <div class="card-header">
                <span class="card-title">
                    <i class="fas fa-user-shield" style="color:var(--gold);margin-right:8px;"></i>Logged In As
                </span>
            </div>
            <div class="card-body">
                <div style="display:flex;align-items:center;gap:14px;">
                    <div style="width:46px;height:46px;border-radius:50%;background:var(--gold);display:flex;align-items:center;justify-content:center;font-weight:800;font-size:18px;color:var(--navy);flex-shrink:0;">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div>
                        <div style="font-size:15px;font-weight:700;color:var(--text);">{{ Auth::user()->name }}</div>
                        <div style="font-size:12px;color:var(--gray4);margin-top:2px;">{{ Auth::user()->email }}</div>
                        <span class="badge badge-gold" style="margin-top:6px;">
                            <i class="fas fa-shield-halved"></i> {{ Auth::user()->getRoleLabel() }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection