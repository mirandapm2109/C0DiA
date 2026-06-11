{{-- resources/views/signup.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sign Up - C0DiA</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    body { font-family: 'Segoe UI', Arial, sans-serif; }

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
        min-height: 100vh;
    }

    /* ── LEFT PANEL ── */
    .welcome {
        width: 44%;
        padding: 60px 48px;
        position: relative;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        background: #800020;
    }

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

    .welcome::after {
        content: '';
        position: absolute;
        right: -80px;
        top: -80px;
        width: 300px;
        height: 300px;
        border-radius: 50%;
        background: rgba(255,255,255,0.05);
        pointer-events: none;
    }

    .circle-bottom {
        position: absolute;
        left: -60px;
        bottom: -60px;
        width: 240px;
        height: 240px;
        border-radius: 50%;
        background: rgba(255,255,255,0.04);
        pointer-events: none;
    }

    .welcome > * { position: relative; z-index: 1; }

    .welcome h1 {
        font-size: 48px;
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
        max-width: 360px;
        animation: fadeInUp 0.6s ease 0.25s both;
    }

    .stats {
        display: flex;
        gap: 28px;
        margin-top: 32px;
        animation: fadeInUp 0.6s ease 0.35s both;
    }

    .stat-num { font-size: 22px; font-weight: 800; color: #ffd6df; }
    .stat-lbl { font-size: 10px; color: rgba(255,255,255,0.4); letter-spacing: 0.08em; margin-top: 3px; }

    .rocket {
        position: absolute;
        right: 44px;
        bottom: 44px;
        font-size: 60px;
        animation: float 4s ease-in-out infinite;
        z-index: 1;
        opacity: 0.4;
    }

    /* ── RIGHT PANEL ── */
    .signup-panel {
        width: 56%;
        background: #ffffff;
        display: flex;
        justify-content: center;
        align-items: flex-start;
        padding: 48px 48px;
        overflow-y: auto;
    }

    .form-box {
        width: 100%;
        max-width: 380px;
        animation: slideIn 0.5s ease 0.2s both;
        opacity: 0;
    }

    .form-box h2 { font-size: 24px; font-weight: 700; color: #1e293b; }

    .form-subtitle {
        font-size: 13px;
        color: #64748b;
        margin-top: 4px;
        margin-bottom: 24px;
    }

    /* ── TWO COLUMN ── */
    .two-col { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }

    /* ── FIELDS ── */
    .field { margin-bottom: 14px; }

    .field label {
        display: block;
        font-size: 11px;
        font-weight: 600;
        color: #64748b;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        margin-bottom: 6px;
    }

    .field-wrap { position: relative; display: flex; align-items: center; }

    .field-wrap .field-icon {
        position: absolute;
        left: 13px;
        color: #94a3b8;
        font-size: 14px;
        pointer-events: none;
    }

    .field-wrap input {
        width: 100%;
        padding: 11px 40px 11px 40px;
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

    /* ── SHOW PASSWORD TOGGLE ── */
    .toggle-pw {
        position: absolute;
        right: 12px;
        background: none;
        border: none;
        cursor: pointer;
        color: #94a3b8;
        font-size: 15px;
        padding: 0;
        display: flex;
        align-items: center;
        transition: color 0.2s;
    }

    .toggle-pw:hover { color: #800020; }

    /* ── PASSWORD HINT ── */
    .pw-hint {
        display: none;
        margin-bottom: 14px;
        font-size: 12px;
        background: #fff8f8;
        border: 1px solid rgba(128,0,32,0.15);
        border-radius: 8px;
        padding: 12px 14px;
    }

    .pw-hint.visible { display: block; }

    .pw-hint p {
        font-weight: 600;
        color: #800020;
        font-size: 12px;
        margin-bottom: 10px;
    }

    .req-list {
        list-style: none;
        padding: 0;
        margin: 0;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 5px 12px;
    }

    .req-list li {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 12px;
        color: #cc0000;
    }

    .req-list li.valid { color: #2d8a2d; }
    .req-list li::before { content: "✖"; font-size: 11px; flex-shrink: 0; }
    .req-list li.valid::before { content: "✔"; }

    /* ── SUBMIT BUTTON ── */
    .btn-submit {
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
        margin-top: 4px;
    }

    .btn-submit:hover:not(:disabled) {
        background: #9a0025;
        transform: translateY(-1px);
        box-shadow: 0 5px 18px rgba(128,0,32,0.28);
    }

    .btn-submit:disabled {
        background: #ffa5a5;
        cursor: not-allowed;
    }

    /* ── LOGIN LINK ── */
    .login-link {
        text-align: center;
        margin-top: 14px;
        font-size: 13px;
        color: #64748b;
    }

    .login-link a {
        color: #800020;
        text-decoration: none;
        font-weight: 600;
    }

    .login-link a:hover { text-decoration: underline; }

    /* ── ERROR ── */
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
        .main { flex-direction: column; }
        .welcome { width: 100%; padding: 40px 28px; min-height: 260px; }
        .signup-panel { width: 100%; padding: 36px 24px; }
        .welcome h1 { font-size: 34px; }
        .two-col { grid-template-columns: 1fr; }
        .rocket { font-size: 42px; right: 24px; bottom: 24px; }
    }
</style>
</head>
<body>

<div class="main">

    {{-- ── LEFT PANEL ── --}}
    <div class="welcome">
        <h1>Join<br><span>C0DiA</span></h1>
        <div class="typing-line">&gt; signup.start();<span class="cursor">_</span></div>
        <p class="tagline">
            Every great dev started with a single line of code.<br>
            Create your account and start your journey today.
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
        <div class="circle-bottom"></div>
        <div class="rocket">🚀</div>
    </div>

    {{-- ── RIGHT PANEL ── --}}
    <div class="signup-panel">
        <div class="form-box">

            <h2>Create your account</h2>
            <p class="form-subtitle">Start your coding journey today</p>

            @if ($errors->any())
                <div class="error-msg">
                    <ul style="padding-left:16px;margin:0;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('signup.post') }}" method="POST">
                @csrf

                {{-- NAME ROW --}}
                <div class="two-col">
                    <div class="field">
                        <label>First Name</label>
                        <div class="field-wrap">
                            <span class="field-icon"><i class="fas fa-user"></i></span>
                            <input type="text" name="first" placeholder="Juan"
                                   maxlength="50" value="{{ old('first') }}" required>
                        </div>
                    </div>
                    <div class="field">
                        <label>Last Name</label>
                        <div class="field-wrap">
                            <span class="field-icon"><i class="fas fa-user"></i></span>
                            <input type="text" name="last" placeholder="Dela Cruz"
                                   maxlength="50" value="{{ old('last') }}" required>
                        </div>
                    </div>
                </div>

                {{-- USERNAME --}}
                <div class="field">
                    <label>Username</label>
                    <div class="field-wrap">
                        <span class="field-icon"><i class="fas fa-at"></i></span>
                        <input type="text" name="username" placeholder="juandelacruz"
                               maxlength="30" value="{{ old('username') }}" required>
                    </div>
                </div>

                {{-- EMAIL --}}
                <div class="field">
                    <label>Email</label>
                    <div class="field-wrap">
                        <span class="field-icon"><i class="fas fa-envelope"></i></span>
                        <input type="email" name="email" placeholder="juan@email.com"
                               maxlength="100" value="{{ old('email') }}" required>
                    </div>
                </div>

                {{-- PASSWORD --}}
                <div class="field">
                    <label>Password</label>
                    <div class="field-wrap">
                        <span class="field-icon"><i class="fas fa-lock"></i></span>
                        <input type="password" id="password" name="password"
                               placeholder="Create a password" maxlength="100" required>
                        <button type="button" class="toggle-pw" id="toggle-pw" aria-label="Show password">
                            <i class="fas fa-eye" id="toggle-pw-icon"></i>
                        </button>
                    </div>
                </div>

                {{-- CONFIRM PASSWORD --}}
                <div class="field">
                    <label>Confirm Password</label>
                    <div class="field-wrap">
                        <span class="field-icon"><i class="fas fa-lock"></i></span>
                        <input type="password" id="confirm_password" name="confirm_password"
                               placeholder="Repeat your password" maxlength="100" required>
                        <button type="button" class="toggle-pw" id="toggle-pw2" aria-label="Show confirm password">
                            <i class="fas fa-eye" id="toggle-pw2-icon"></i>
                        </button>
                    </div>
                </div>

                {{-- PASSWORD REQUIREMENTS --}}
                <div class="pw-hint" id="pw-hint">
                    <p>Password must include:</p>
                    <ul class="req-list">
                        <li id="r-len" class="invalid">8+ characters</li>
                        <li id="r-upper" class="invalid">Uppercase letter</li>
                        <li id="r-lower" class="invalid">Lowercase letter</li>
                        <li id="r-num" class="invalid">A number</li>
                        <li id="r-special" class="invalid">Special character</li>
                        <li id="r-match" class="invalid">Passwords match</li>
                    </ul>
                </div>

                {{-- SUBMIT --}}
                <button type="submit" class="btn-submit" id="submit-btn" disabled>
                    Create Account <i class="fas fa-arrow-right"></i>
                </button>

            </form>

            <div class="login-link">
                Already have an account? <a href="{{ route('home') }}">Sign in</a>
            </div>

        </div>
    </div>

</div>

<script>
    const pw     = document.getElementById('password');
    const pwc    = document.getElementById('confirm_password');
    const hint   = document.getElementById('pw-hint');
    const btn    = document.getElementById('submit-btn');

    const reqs = {
        len:     document.getElementById('r-len'),
        upper:   document.getElementById('r-upper'),
        lower:   document.getElementById('r-lower'),
        num:     document.getElementById('r-num'),
        special: document.getElementById('r-special'),
        match:   document.getElementById('r-match'),
    };

    function setReq(el, valid) {
        el.classList.toggle('valid', valid);
        el.classList.toggle('invalid', !valid);
    }

    function validate() {
        const p = pw.value, c = pwc.value;
        const checks = {
            len:     p.length >= 8,
            upper:   /[A-Z]/.test(p),
            lower:   /[a-z]/.test(p),
            num:     /\d/.test(p),
            special: /[\W_]/.test(p),
            match:   p !== '' && p === c,
        };
        Object.keys(checks).forEach(k => setReq(reqs[k], checks[k]));
        btn.disabled = !Object.values(checks).every(Boolean);
    }

    function showHint() {
        const active = document.activeElement === pw || document.activeElement === pwc;
        hint.classList.toggle('visible', active || pw.value.length > 0 || pwc.value.length > 0);
    }

    pw.addEventListener('input',  () => { validate(); showHint(); });
    pwc.addEventListener('input', () => { validate(); showHint(); });
    pw.addEventListener('focus',  showHint);
    pwc.addEventListener('focus', showHint);
    pw.addEventListener('blur',   () => setTimeout(showHint, 100));
    pwc.addEventListener('blur',  () => setTimeout(showHint, 100));

    // Show/hide password toggles
    document.getElementById('toggle-pw').addEventListener('click', function () {
        const isText = pw.type === 'text';
        pw.type = isText ? 'password' : 'text';
        document.getElementById('toggle-pw-icon').className = isText ? 'fas fa-eye' : 'fas fa-eye-slash';
    });

    document.getElementById('toggle-pw2').addEventListener('click', function () {
        const isText = pwc.type === 'text';
        pwc.type = isText ? 'password' : 'text';
        document.getElementById('toggle-pw2-icon').className = isText ? 'fas fa-eye' : 'fas fa-eye-slash';
    });

    window.addEventListener('load', () => { validate(); showHint(); });
</script>

</body>
</html>
