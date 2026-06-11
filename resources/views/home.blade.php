{{-- resources/views/home.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>C0DiA</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Segoe UI', Arial, sans-serif;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50%       { transform: translateY(-10px); }
        }
        @keyframes blink {
            0%, 100% { opacity: 1; }
            50%       { opacity: 0; }
        }
        @keyframes slideIn {
            from { opacity: 0; transform: translateX(20px); }
            to   { opacity: 1; transform: translateX(0); }
        }

        .main {
            display: flex;
            width: 100%;
            height: 100vh;
            min-height: 600px;
        }

        /* ── LEFT PANEL ── */
        .welcome {
            width: 52%;
            padding: 60px 52px;
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            padding-top: 72px;
            background: #800020;
        }

        /* grid overlay */
        .welcome::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(255,255,255,0.06) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.06) 1px, transparent 1px);
            background-size: 36px 36px;
            pointer-events: none;
        }

        /* top-right circle */
        .welcome::after {
            content: '';
            position: absolute;
            right: -80px;
            top: -80px;
            width: 320px;
            height: 320px;
            border-radius: 50%;
            background: rgba(255,255,255,0.05);
            pointer-events: none;
        }

        /* bottom-left circle */
        .circle-bottom {
            position: absolute;
            left: -60px;
            bottom: -60px;
            width: 260px;
            height: 260px;
            border-radius: 50%;
            background: rgba(255,255,255,0.04);
            pointer-events: none;
        }

        .welcome > * { position: relative; z-index: 1; }

        .welcome h1 {
            font-size: 52px;
            font-weight: 800;
            line-height: 1.1;
            color: #ffffff;
            animation: fadeInUp 0.6s ease 0.05s both;
        }

        .welcome h1 span { color: #ffd6df; }

        .typing-line {
            font-family: 'Courier New', monospace;
            font-size: 14px;
            color: rgba(255,255,255,0.65);
            margin-top: 18px;
            animation: fadeInUp 0.6s ease 0.15s both;
        }

        .typing-line .cursor { animation: blink 1s step-end infinite; }

        .tagline {
            font-size: 14px;
            color: rgba(255,255,255,0.55);
            margin-top: 16px;
            line-height: 1.75;
            max-width: 420px;
            animation: fadeInUp 0.6s ease 0.25s both;
        }

        .stats {
            display: flex;
            gap: 36px;
            margin-top: 36px;
            animation: fadeInUp 0.6s ease 0.35s both;
        }

        .stat-num {
            font-size: 24px;
            font-weight: 800;
            color: #ffd6df;
        }

        .stat-lbl {
            font-size: 10px;
            color: rgba(255,255,255,0.4);
            letter-spacing: 0.08em;
            margin-top: 3px;
        }

        .rocket {
            position: absolute;
            right: 48px;
            bottom: 48px;
            font-size: 64px;
            animation: float 4s ease-in-out infinite;
            z-index: 1;
            opacity: 0.45;
        }

        /* ── RIGHT PANEL ── */
        .login {
            width: 48%;
            background: #ffffff;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 48px 40px;
        }

        .form-box {
            width: 100%;
            max-width: 320px;
            animation: slideIn 0.5s ease 0.2s both;
            opacity: 0;
        }

        .form-box h2 {
            font-size: 24px;
            font-weight: 700;
            color: #1e293b;
        }

        .form-subtitle {
            font-size: 13px;
            color: #64748b;
            margin-top: 4px;
            margin-bottom: 26px;
        }

        /* ── FIELDS ── */
        .field { margin-bottom: 16px; }

        .field label {
            display: block;
            font-size: 11px;
            font-weight: 600;
            color: #64748b;
            letter-spacing: 0.05em;
            margin-bottom: 7px;
        }

        .field-wrap { position: relative; display: flex; align-items: center; }

        .field-wrap .field-icon {
            position: absolute;
            left: 13px;
            color: #94a3b8;
            font-size: 14px;
            pointer-events: none;
            display: flex;
            align-items: center;
        }

        .field-wrap input {
            width: 100%;
            padding: 12px 14px 12px 42px;
            border: 1.5px solid #e2e8f0;
            border-radius: 8px;
            background: #f8fafc;
            color: #0f172a;
            font-size: 14px;
            outline: none;
            transition: all 0.2s;
        }

        .field-wrap input:focus {
            border-color: #800020;
            box-shadow: 0 0 0 3px rgba(128,0,32,0.1);
            background: #ffffff;
        }

        .field-wrap input::placeholder { color: #94a3b8; }

        .show-pw {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            color: #64748b;
            cursor: pointer;
            margin-top: 8px;
        }

        .show-pw input[type="checkbox"] { accent-color: #800020; }

        /* ── OPTIONS ── */
        .options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 12px 0 18px;
        }

        .remember {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            color: #475569;
            cursor: pointer;
        }

        .remember input[type="checkbox"] { accent-color: #800020; }

        .forgot a {
            font-size: 13px;
            color: #800020;
            text-decoration: none;
            transition: color 0.2s;
        }

        .forgot a:hover { color: #a00028; }

        /* ── LOGIN BUTTON ── */
        .btn-login {
            width: 100%;
            padding: 13px;
            background: #800020;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-login:hover {
            background: #9a0025;
            transform: translateY(-1px);
            box-shadow: 0 5px 18px rgba(128,0,32,0.28);
        }

        .btn-login:active { transform: translateY(0); }

        /* ── DIVIDER ── */
        .divider {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 18px 0;
        }

        .divider-line { flex: 1; height: 1px; background: #e9ecef; }
        .divider-text { font-size: 11px; color: #94a3b8; white-space: nowrap; }

        /* ── SOCIAL BUTTONS ── */
        .social-row {
            display: flex;
            gap: 8px;
            margin-bottom: 14px;
        }

        .social-btn {
            flex: 1;
            padding: 11px 4px;
            border: 1.5px solid #e2e8f0;
            border-radius: 8px;
            background: #ffffff;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            font-size: 12px;
            font-weight: 500;
            color: #475569;
            transition: all 0.2s;
            text-decoration: none;
        }

        .social-btn:hover {
            border-color: #800020;
            color: #800020;
            transform: translateY(-1px);
        }

        .social-btn i { font-size: 14px; }
        .social-btn .fa-google     { color: #EA4335; }
        .social-btn .fa-github     { color: #1e293b; }
        .social-btn .fa-facebook-f { color: #1877F2; }

        /* ── CREATE ACCOUNT ── */
        .btn-signup {
            width: 100%;
            padding: 12px;
            background: transparent;
            border: 1.5px solid #e2e8f0;
            border-radius: 8px;
            font-size: 14px;
            color: #475569;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-signup:hover {
            border-color: #800020;
            color: #800020;
        }

        /* ── ERROR MESSAGE ── */
        .error-msg {
            font-size: 13px;
            color: #800020;
            background: rgba(128,0,32,0.07);
            border: 1px solid rgba(128,0,32,0.2);
            border-radius: 6px;
            padding: 8px 12px;
            margin-bottom: 16px;
        }

        /* ── RESPONSIVE ── */
        @media (max-width: 768px) {
            .main { flex-direction: column; height: auto; min-height: 100vh; }
            .welcome { width: 100%; padding: 48px 28px; min-height: 280px; }
            .login { width: 100%; padding: 40px 28px; }
            .welcome h1 { font-size: 36px; }
            .stats { gap: 20px; }
            .rocket { font-size: 44px; right: 28px; bottom: 28px; }
        }
    </style>
</head>
<body>

<div class="main">

    {{-- ── LEFT PANEL ── --}}
    <div class="welcome">
        <h1>Welcome to<br><span>C0DiA</span></h1>
        <div class="typing-line">&gt; learn.build.grow();<span class="cursor">_</span></div>
        <p class="tagline">
            Every great dev started with a single line of code.<br>
            Learn, socialize, and level up with the pros.
        </p>
        <div class="stats">
            <div>
                <div class="stat-num">100+</div>
                <div class="stat-lbl">LESSONS</div>
            </div>
            <div>
                <div class="stat-num">50+</div>
                <div class="stat-lbl">PROJECTS</div>
            </div>
            <div>
                <div class="stat-num">24/7</div>
                <div class="stat-lbl">COMMUNITY</div>
            </div>
        </div>
        <div class="rocket">🚀</div>
    </div>

    {{-- ── RIGHT PANEL ── --}}
    <div class="login">
        <div class="form-box">

            <h2>Sign in</h2>
            <p class="form-subtitle">Continue your coding journey</p>

            {{-- SESSION error --}}
            @if(session('error'))
                <div class="error-msg">{{ session('error') }}</div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf

                {{-- USERNAME --}}
                <div class="field">
                    <label>USERNAME OR EMAIL</label>
                    <div class="field-wrap">
                        <span class="field-icon"><i class="fas fa-user"></i></span>
                        <input type="text" name="username" placeholder="Enter your username or email"
                               value="{{ old('username') }}" required>
                    </div>
                </div>

                {{-- PASSWORD --}}
                <div class="field">
                    <label>PASSWORD</label>
                    <div class="field-wrap">
                        <span class="field-icon"><i class="fas fa-lock"></i></span>
                        <input type="password" id="password" name="password"
                               placeholder="Enter your password" required>
                    </div>
                    <label class="show-pw">
                        <input type="checkbox" id="showPassword"> Show password
                    </label>
                </div>

                {{-- OPTIONS --}}
                <div class="options">
                    <label class="remember">
                        <input type="checkbox" name="remember"> Remember me
                    </label>
                    <div class="forgot">
                        <a href="{{ route('password.request') }}">Forgot password?</a>
                    </div>
                </div>

                {{-- LOGIN BUTTON --}}
                <button type="submit" class="btn-login">
                    Login <i class="fas fa-arrow-right"></i>
                </button>

            </form>

            {{-- DIVIDER --}}
            <div class="divider">
                <div class="divider-line"></div>
                <span class="divider-text">or sign in with</span>
                <div class="divider-line"></div>
            </div>

            {{-- SOCIAL LOGIN --}}
            <div class="social-row">
                <a href="{{ route('auth.google') }}" class="social-btn">
                    <i class="fab fa-google"></i> Google
                </a>
                <a href="{{ route('auth.github') }}" class="social-btn">
                    <i class="fab fa-github"></i> GitHub
                </a>
                <a href="{{ route('auth.facebook') }}" class="social-btn">
                    <i class="fab fa-facebook-f"></i> Facebook
                </a>
            </div>

            {{-- CREATE ACCOUNT --}}
            <button type="button" class="btn-signup"
                    onclick="location.href='{{ route('signup') }}'">
                Create an account
            </button>

        </div>
    </div>

</div>

<script>
    document.getElementById('showPassword').addEventListener('change', function () {
        document.getElementById('password').type = this.checked ? 'text' : 'password';
    });
</script>

</body>
</html>
