{{-- FILE PATH: resources/views/auth/login.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In — StockVault IMS</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=DM+Serif+Display&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --navy:  #0f1d35;
            --navy2: #162540;
            --navy3: #1e3258;
            --gold:  #c9a84c;
            --gold2: #e0be78;
            --white: #ffffff;
            --gray1: #f8f7f4;
            --gray2: #e8e4dc;
            --gray3: #a8a090;
            --text:  #1a2540;
            --red:   #c0392b;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            min-height: 100vh;
            display: flex;
            background: var(--navy);
            overflow: hidden;
        }

        /* ── LEFT PANEL ─────────────────────────────── */
        .left-panel {
            flex: 1;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 48px;
            overflow: hidden;
        }

        /* Animated background grid */
        .left-panel::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(201,168,76,0.06) 1px, transparent 1px),
                linear-gradient(90deg, rgba(201,168,76,0.06) 1px, transparent 1px);
            background-size: 48px 48px;
            animation: grid-move 20s linear infinite;
        }

        @keyframes grid-move {
            0%   { transform: translateY(0); }
            100% { transform: translateY(48px); }
        }

        /* Glowing orbs */
        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            pointer-events: none;
        }
        .orb-1 {
            width: 400px; height: 400px;
            background: rgba(201,168,76,0.12);
            top: -100px; left: -100px;
            animation: orb-float 8s ease-in-out infinite;
        }
        .orb-2 {
            width: 300px; height: 300px;
            background: rgba(30,50,88,0.8);
            bottom: 50px; right: -50px;
            animation: orb-float 12s ease-in-out infinite reverse;
        }
        @keyframes orb-float {
            0%, 100% { transform: translate(0, 0); }
            50%       { transform: translate(30px, -30px); }
        }

        .left-brand {
            position: relative;
            z-index: 2;
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .brand-logo {
            width: 48px; height: 48px;
            background: var(--gold);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'DM Serif Display', serif;
            font-size: 22px;
            color: var(--navy);
            font-weight: 400;
            box-shadow: 0 0 0 4px rgba(201,168,76,0.2);
        }

        .brand-name {
            font-family: 'DM Serif Display', serif;
            font-size: 22px;
            color: var(--white);
            letter-spacing: 0.02em;
        }

        .brand-tag {
            font-size: 11px;
            color: var(--gold);
            letter-spacing: 0.14em;
            text-transform: uppercase;
            margin-top: 1px;
        }

        .left-content {
            position: relative;
            z-index: 2;
        }

        .left-headline {
            font-family: 'DM Serif Display', serif;
            font-size: 52px;
            line-height: 1.1;
            color: var(--white);
            margin-bottom: 20px;
        }

        .left-headline span {
            color: var(--gold);
        }

        .left-desc {
            font-size: 16px;
            color: rgba(255,255,255,0.45);
            line-height: 1.7;
            max-width: 380px;
        }

        .left-features {
            display: flex;
            flex-direction: column;
            gap: 14px;
            margin-top: 40px;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .feature-icon {
            width: 36px; height: 36px;
            border-radius: 8px;
            background: rgba(201,168,76,0.12);
            border: 1px solid rgba(201,168,76,0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gold);
            font-size: 14px;
            flex-shrink: 0;
        }

        .feature-text {
            font-size: 14px;
            color: rgba(255,255,255,0.6);
        }

        .feature-text strong { color: rgba(255,255,255,0.9); }

        .left-footer {
            position: relative;
            z-index: 2;
            font-size: 12px;
            color: rgba(255,255,255,0.25);
        }

        /* ── RIGHT PANEL (LOGIN FORM) ────────────────── */
        .right-panel {
            width: 480px;
            background: var(--gray1);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 48px 52px;
            position: relative;
            flex-shrink: 0;
        }

        .right-panel::before {
            content: '';
            position: absolute;
            top: 0; left: 0; bottom: 0;
            width: 1px;
            background: linear-gradient(to bottom, transparent, rgba(201,168,76,0.4), transparent);
        }

        .login-box {
            width: 100%;
        }

        .login-eyebrow {
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: var(--gold);
            margin-bottom: 10px;
        }

        .login-title {
            font-family: 'DM Serif Display', serif;
            font-size: 34px;
            color: var(--text);
            line-height: 1.15;
            margin-bottom: 8px;
        }

        .login-subtitle {
            font-size: 14px;
            color: var(--gray3);
            margin-bottom: 36px;
        }

        /* Role selector tabs */
        .role-tabs {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 8px;
            margin-bottom: 28px;
            background: var(--gray2);
            padding: 5px;
            border-radius: 10px;
        }

        .role-tab {
            padding: 9px 6px;
            border-radius: 7px;
            font-size: 12px;
            font-weight: 600;
            text-align: center;
            cursor: pointer;
            border: none;
            background: transparent;
            color: var(--gray3);
            transition: all 0.2s;
            font-family: 'DM Sans', sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 4px;
        }

        .role-tab i { font-size: 14px; }

        .role-tab.active {
            background: var(--white);
            color: var(--navy);
            box-shadow: 0 2px 8px rgba(15,29,53,0.1);
        }

        /* Form */
        .form-group {
            margin-bottom: 18px;
        }

        .form-label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: var(--text);
            margin-bottom: 7px;
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }

        .input-wrap {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray3);
            font-size: 14px;
            pointer-events: none;
        }

        .form-control {
            width: 100%;
            padding: 13px 14px 13px 42px;
            border: 1.5px solid var(--gray2);
            border-radius: 10px;
            font-size: 14px;
            font-family: 'DM Sans', sans-serif;
            color: var(--text);
            background: var(--white);
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .form-control:focus {
            border-color: var(--navy);
            box-shadow: 0 0 0 3px rgba(15,29,53,0.08);
        }

        .form-control.is-invalid { border-color: var(--red); }

        .invalid-feedback {
            color: var(--red);
            font-size: 12px;
            margin-top: 5px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .toggle-pass {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray3);
            cursor: pointer;
            font-size: 14px;
            background: none;
            border: none;
            padding: 0;
        }

        .toggle-pass:hover { color: var(--navy); }

        .form-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
        }

        .checkbox-wrap {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }

        .checkbox-wrap input[type="checkbox"] {
            width: 16px; height: 16px;
            accent-color: var(--navy);
            cursor: pointer;
        }

        .checkbox-label {
            font-size: 13px;
            color: var(--gray3);
            cursor: pointer;
        }

        .forgot-link {
            font-size: 13px;
            color: var(--navy);
            text-decoration: none;
            font-weight: 600;
        }

        .forgot-link:hover { color: var(--gold); }

        .btn-login {
            width: 100%;
            padding: 14px;
            background: var(--navy);
            color: var(--white);
            border: none;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 700;
            font-family: 'DM Sans', sans-serif;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            letter-spacing: 0.02em;
        }

        .btn-login:hover {
            background: var(--navy3);
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(15,29,53,0.25);
        }

        .btn-login:active { transform: translateY(0); }

        .login-divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 24px 0;
        }

        .login-divider::before,
        .login-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--gray2);
        }

        .login-divider span {
            font-size: 12px;
            color: var(--gray3);
            white-space: nowrap;
        }

        .role-hint {
            background: var(--white);
            border: 1px solid var(--gray2);
            border-radius: 10px;
            padding: 14px 16px;
            font-size: 13px;
            color: var(--gray3);
            line-height: 1.6;
        }

        .role-hint strong { color: var(--text); }

        .login-footer {
            margin-top: 28px;
            text-align: center;
            font-size: 12px;
            color: var(--gray3);
        }

        /* Alert */
        .alert-error {
            background: #fdf0ee;
            border: 1px solid #f0c4be;
            border-radius: 8px;
            padding: 12px 16px;
            color: var(--red);
            font-size: 13px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Animate in */
        .login-box > * {
            animation: fade-up 0.5s ease both;
        }
        .login-box > *:nth-child(1) { animation-delay: 0.05s; }
        .login-box > *:nth-child(2) { animation-delay: 0.10s; }
        .login-box > *:nth-child(3) { animation-delay: 0.15s; }
        .login-box > *:nth-child(4) { animation-delay: 0.20s; }
        .login-box > *:nth-child(5) { animation-delay: 0.25s; }
        .login-box > *:nth-child(6) { animation-delay: 0.30s; }

        @keyframes fade-up {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

<!-- LEFT PANEL -->
<div class="left-panel">
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>

    <div class="left-brand">
        <div class="brand-logo">S</div>
        <div>
            <div class="brand-name">StockVault</div>
            <div class="brand-tag">Inventory Management System</div>
        </div>
    </div>

    <div class="left-content">
        <div class="left-headline">
            Smart Inventory.<br>
            <span>Smarter</span> Decisions.
        </div>
        <div class="left-desc">
            A complete inventory management solution for businesses of all sizes. Track stock, manage suppliers, and get real-time insights.
        </div>
        <div class="left-features">
            <div class="feature-item">
                <div class="feature-icon"><i class="fas fa-chart-line"></i></div>
                <div class="feature-text"><strong>Real-time Analytics</strong> — Live stock level dashboards</div>
            </div>
            <div class="feature-item">
                <div class="feature-icon"><i class="fas fa-bell"></i></div>
                <div class="feature-text"><strong>Smart Alerts</strong> — Automatic low stock notifications</div>
            </div>
            <div class="feature-item">
                <div class="feature-icon"><i class="fas fa-users"></i></div>
                <div class="feature-text"><strong>Role-Based Access</strong> — Admin, Manager & Staff roles</div>
            </div>
            <div class="feature-item">
                <div class="feature-icon"><i class="fas fa-shield-halved"></i></div>
                <div class="feature-text"><strong>Secure & Reliable</strong> — Enterprise-grade security</div>
            </div>
        </div>
    </div>

    <div class="left-footer">
        © {{ date('Y') }} StockVault IMS. All rights reserved.
    </div>
</div>

<!-- RIGHT PANEL -->
<div class="right-panel">
    <div class="login-box">
        <div class="login-eyebrow">Secure Access</div>
        <div class="login-title">Sign in to<br>your account</div>
        <div class="login-subtitle">Enter your credentials to access the system.</div>

        <!-- Role Tabs -->
        <div class="role-tabs">
            <button class="role-tab active" onclick="setRole('admin', this)">
                <i class="fas fa-shield-halved"></i> Admin
            </button>
            <button class="role-tab" onclick="setRole('manager', this)">
                <i class="fas fa-user-tie"></i> Manager
            </button>
            <button class="role-tab" onclick="setRole('staff', this)">
                <i class="fas fa-user"></i> Staff
            </button>
        </div>

        @if($errors->any())
        <div class="alert-error">
            <i class="fas fa-circle-exclamation"></i>
            These credentials do not match our records.
        </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <input type="hidden" name="role_hint" id="roleHint" value="admin">

            <div class="form-group">
                <label class="form-label">Email Address</label>
                <div class="input-wrap">
                    <i class="fas fa-envelope input-icon"></i>
                    <input type="email" name="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                        placeholder="you@example.com" value="{{ old('email') }}" required autofocus>
                </div>
                @error('email')
                <div class="invalid-feedback"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Password</label>
                <div class="input-wrap">
                    <i class="fas fa-lock input-icon"></i>
                    <input type="password" name="password" id="passwordInput" class="form-control" placeholder="••••••••" required>
                    <button type="button" class="toggle-pass" onclick="togglePass()">
                        <i class="fas fa-eye" id="eyeIcon"></i>
                    </button>
                </div>
            </div>

            <div class="form-row">
                <label class="checkbox-wrap">
                    <input type="checkbox" name="remember">
                    <span class="checkbox-label">Remember me</span>
                </label>
                @if(Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="forgot-link">Forgot password?</a>
                @endif
            </div>

            <button type="submit" class="btn-login">
                <i class="fas fa-right-to-bracket"></i>
                Sign In to StockVault
            </button>
        </form>

        <div class="login-divider"><span>Default Credentials</span></div>

        <div class="role-hint">
            <strong>Admin:</strong> admin@inventory.com / password<br>
            <strong>Manager:</strong> manager@inventory.com / password<br>
            <strong>Staff:</strong> staff@inventory.com / password
        </div>

        <div class="login-footer">
            Powered by StockVault IMS v2.0 &mdash; Secure & Encrypted
        </div>
    </div>
</div>

<script>
function setRole(role, el) {
    document.querySelectorAll('.role-tab').forEach(t => t.classList.remove('active'));
    el.classList.add('active');
    document.getElementById('roleHint').value = role;
}

function togglePass() {
    const input = document.getElementById('passwordInput');
    const icon  = document.getElementById('eyeIcon');
    if (input.type === 'password') {
        input.type = 'text';
        icon.className = 'fas fa-eye-slash';
    } else {
        input.type = 'password';
        icon.className = 'fas fa-eye';
    }
}
</script>
</body>
</html>