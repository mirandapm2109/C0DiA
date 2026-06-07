{{-- resources/views/signup.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Signup - C0DiA</title>
<style>
    /* General body */
body {
    margin: 0;
    font-family: Arial, sans-serif;
    background-color: #ffffff; /* light background */
    color: #333333;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
}

/* Wrapper to center everything */
.signup-wrapper {
    text-align: center;
    width: 100%;
    max-width: 400px;
    padding: 20px;
}

/* Motivation section */
.motivation h2 {
    font-size: 26px;
    color: #e60000; /* red heading */
    margin-bottom: 10px;
}

.motivation p {
    color: #ff6666; /* light red text */
    font-size: 16px;
    margin-bottom: 30px;
}

/* Signup form */
.signup-form {
    background-color: #ffffff; /* white form background */
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 0 20px rgba(0,0,0,0.1); /* subtle shadow */
}

/* Form heading */
.signup-form h1 {
    margin-bottom: 20px;
    color: #e60000; /* red */
}

/* Input boxes */
.signup-form .box {
    margin-bottom: 15px;
    margin-right: 10%;
}

.signup-form input {
    width: 100%;
    padding: 12px;
    border-radius: 6px;
    border: 1px solid #e60000; /* red border */
    font-size: 14px;
}

/* Input focus */
.signup-form input:focus {
    border-color: #ff3333;
    outline: none;
    box-shadow: 0 0 5px #ff9999;
}

/* Signup button */
.signup-form .btn button {
    width: 100%;
    padding: 12px;
    font-size: 16px;
    border: none;
    border-radius: 6px;
    background-color: #e60000; /* red button */
    color: white;
    cursor: pointer;
    transition: 0.3s;
}

.signup-form .btn button:hover {
    background-color: #ff3333;
    transform: scale(1.05);
}

/* Create account link */
.signup-form .create {
    margin-top: 15px;
}

.signup-form .create-btn {
    color: #e60000; /* red link */
    text-decoration: none;
    font-size: 14px;
}

.signup-form .create-btn:hover {
    color: #ff6666; /* light red on hover */
    text-decoration: underline;
}

.password-hint {
    display: none;
    text-align: left;
    margin-bottom: 20px;
    font-size: 14px;
    color: #333;
}

.password-hint.visible {
    display: block;
}

.password-hint p {
    margin: 0 0 8px;
}

.requirement-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.requirement-list li {
    display: flex;
    align-items: center;
    margin-bottom: 6px;
    padding-left: 22px;
    position: relative;
}

.requirement-list li::before {
    content: "✖";
    position: absolute;
    left: 0;
    font-size: 16px;
    color: #cc0000;
}

.requirement-list li.valid::before {
    content: "✔";
    color: #2d8a2d;
}

.requirement-list li.valid {
    color: #2d8a2d;
}

.requirement-list li.invalid {
    color: #cc0000;
}

.signup-form .btn button:disabled {
    background-color: #ffa5a5;
    cursor: not-allowed;
}

</style>
</head>
<body>

<div class="signup-wrapper">
    <div class="motivation">
        <h2>Let's see our potential! 🚀</h2>
        <p>Start your coding journey and become the developer you’ve always wanted to be.</p>
    </div>

    <form action="{{ route('signup.post') }}" method="POST" class="signup-form">
        @csrf
        <h1>Create Your Account</h1>

        {{-- Validation errors --}}
        @if ($errors->any())
            <div style="color:#ff6b6b; font-size:14px; margin-bottom:10px;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="box">
            <input type="text" name="first" placeholder="First Name" maxlength="50" value="{{ old('first') }}" required>
        </div>
        <div class="box">
            <input type="text" name="last" placeholder="Last Name" maxlength="50" value="{{ old('last') }}" required>
        </div>
        <div class="box">
            <input type="text" name="username" placeholder="Username" maxlength="30" value="{{ old('username') }}" required>
        </div>
        <div class="box">
            <input type="email" name="email" placeholder="Email" maxlength="100" value="{{ old('email') }}" required>
        </div>
        <div class="box">
            <input type="password" name="password" placeholder="Password" minlength="8" maxlength="100" required>
        </div>
        <div class="box">
            <input type="password" name="confirm_password" placeholder="Confirm Password" minlength="8" maxlength="100" required>
        </div>

        <div class="password-hint">
            <p>Choose a strong password. The password must include:</p>
            <ul class="requirement-list">
                <li id="pw-length" class="invalid">At least 8 characters</li>
                <li id="pw-uppercase" class="invalid">An uppercase letter</li>
                <li id="pw-lowercase" class="invalid">A lowercase letter</li>
                <li id="pw-number" class="invalid">A number</li>
                <li id="pw-special" class="invalid">A special character (e.g. !@#$%^&*)</li>
                <li id="pw-match" class="invalid">Password and confirm password match</li>
            </ul>
        </div>

        <div class="btn">
            <button type="submit" disabled>Sign Up</button>
        </div>

        <div class="create">
            <a href="{{ route('home') }}" class="create-btn">Already have an account? Login</a>
        </div>
    </form>
</div>

<script>
    const passwordInput = document.querySelector('input[name="password"]');
    const confirmInput = document.querySelector('input[name="confirm_password"]');
    const submitButton = document.querySelector('.signup-form button[type="submit"]');

    const requirements = {
        length: document.getElementById('pw-length'),
        uppercase: document.getElementById('pw-uppercase'),
        lowercase: document.getElementById('pw-lowercase'),
        number: document.getElementById('pw-number'),
        special: document.getElementById('pw-special'),
        match: document.getElementById('pw-match'),
    };

    function setRequirement(element, valid) {
        element.classList.toggle('valid', valid);
        element.classList.toggle('invalid', !valid);
    }

    function validatePassword() {
        const password = passwordInput.value;
        const confirm = confirmInput.value;

        const hasLength = password.length >= 8;
        const hasUppercase = /[A-Z]/.test(password);
        const hasLowercase = /[a-z]/.test(password);
        const hasNumber = /\d/.test(password);
        const hasSpecial = /[\W_]/.test(password);
        const passwordsMatch = password !== '' && password === confirm;

        setRequirement(requirements.length, hasLength);
        setRequirement(requirements.uppercase, hasUppercase);
        setRequirement(requirements.lowercase, hasLowercase);
        setRequirement(requirements.number, hasNumber);
        setRequirement(requirements.special, hasSpecial);
        setRequirement(requirements.match, passwordsMatch);

        submitButton.disabled = !(hasLength && hasUppercase && hasLowercase && hasNumber && hasSpecial && passwordsMatch);
    }

    const passwordHint = document.querySelector('.password-hint');

    function updateHintVisibility() {
        const active = document.activeElement === passwordInput || document.activeElement === confirmInput;
        const hasValue = passwordInput.value.length > 0 || confirmInput.value.length > 0;
        passwordHint.classList.toggle('visible', active || hasValue);
    }

    passwordInput.addEventListener('input', () => {
        validatePassword();
        updateHintVisibility();
    });
    confirmInput.addEventListener('input', () => {
        validatePassword();
        updateHintVisibility();
    });
    passwordInput.addEventListener('focus', updateHintVisibility);
    confirmInput.addEventListener('focus', updateHintVisibility);
    passwordInput.addEventListener('blur', () => setTimeout(updateHintVisibility, 0));
    confirmInput.addEventListener('blur', () => setTimeout(updateHintVisibility, 0));
    window.addEventListener('load', () => {
        validatePassword();
        updateHintVisibility();
    });
</script>
</body>
</html>
