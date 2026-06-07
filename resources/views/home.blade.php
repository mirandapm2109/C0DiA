{{-- resources/views/home.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>C0DiA</title>
    <style>
        body{
    margin:0;
    font-family: Arial, sans-serif;
    background:#f8fafc; /* light background */
    color:#1e293b; /* dark text */
}

.main{
    display:flex;
    height:100vh;
}

/* LEFT SIDE (WELCOME) */
.welcome{
    width:50%;
    padding:80px;
    background:linear-gradient(135deg, #ffe5e5, #fff0f0); /* soft red gradient */
}

.hello{
    font-family: monospace;
    font-size:20px;
    color:#e60000; /* red */
    margin-bottom:10px;
}

.welcome h1{
    font-size:50px;
    margin:0;
    color:#0f172a;
}

.tagline{
    font-size:22px;
    margin-top:20px;
    color:#334155;
}

.motivation{
    margin-top:30px;
    color:#475569;
}

.motivation2{
    margin-top:10px;
    color:#64748b;
}

.start{
    margin-top:20px;
    font-weight:bold;
    color:#e60000; /* red */
}

/* RIGHT SIDE (LOGIN) */
.login{
    width:50%;
    display:flex;
    justify-content:center;
    align-items:center;
    background:#ffffff;
}

/* FORM */
form{
    width:320px;
    padding:30px;
    background:white;
    border-radius:12px;
    box-shadow:0 10px 25px rgba(0,0,0,0.08);
}

/* INPUT */
.box input{
    width:90%;
    padding:12px;
    margin-top:10px;
    border:1px solid #fca5a5; /* soft red border */
    border-radius:6px;
    outline:none;
    transition:0.2s;
}

.box input:focus{
    border-color:#e60000; /* red focus */
    box-shadow:0 0 0 2px rgba(230,0,0,0.2); /* red glow */
}

/* LOGIN BUTTON */
button{
    width:100%;
    padding:12px;
    margin-top:15px;
    background:#e60000; /* red */
    border:none;
    color:white;
    border-radius:6px;
    cursor:pointer;
    transition:0.3s;
}

button:hover{
    background:#ff3333; /* lighter red on hover */
}

/* OPTIONS */
.options{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-top:10px;
}

.remember{
    display:flex;
    align-items:center;
    gap:5px;
}

/* FORGOT PASSWORD */
.forgot a{
    text-decoration:none;
    color:#e60000; /* red link */
    font-size:14px;
}

.forgot a:hover{
    color:#ff3333; /* lighter red */
}

/* CREATE ACCOUNT BUTTON */
.create button{
    width:100%;
    padding:12px;
    margin-top:10px;
    background:transparent;
    border:2px solid #e60000; /* red border */
    color:#e60000; /* red text */
    border-radius:6px;
    cursor:pointer;
    transition:0.3s;
}

.create button:hover{
    background:#e60000; /* red background on hover */
    color:white;
}

/* SEARCH (if used) */
.search input {
    padding: 8px;
    border-radius: 5px;
    border: 1px solid #fca5a5; /* soft red border */
}

.search button {
    padding: 8px 12px;
    background: #e60000; /* red */
    color:white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

    </style>
</head>
<body>

<div class="main">

    <div class="welcome">

        <p class="hello">Hello World!</p>

        <h1>Welcome to C0DiA 👋</h1>

        <p class="tagline">
            Learn. Build. Become a Developer.
        </p>

        <p class="motivation">
            Every great programmer started with a single line of code.
            Let's discover our potential and unlock what we are capable of.
        </p>

        <p class="motivation2">
            Here in C0DiA, you can learn, socialize, and interact with the pros.
        </p>

        <p class="start">
            Your coding journey starts today. 🚀
        </p>

    </div> <!-- end welcome -->

    <div class="login">

        <form action="{{ route('login') }}" method="POST">
            @csrf

            <h2>Login to Continue</h2>

            {{-- SESSION error message --}}
            @if(session('error'))
                <div id="error-message" style="color:#ff6b6b; font-size:14px; margin-top:10px;">
                    {{ session('error') }}
                </div>
            @else
                <div id="error-message" style="color:#ff6b6b; font-size:14px; margin-top:10px;"></div>
            @endif

            <div class="box">
                <input type="text" name="username" placeholder="Username or Email" required>
            </div>

            <div class="box">
                <input type="password" id="password" name="password" placeholder="Password" required>
            </div>

            <div style="margin-top:5px;">
                <input type="checkbox" id="showPassword">
                <label for="showPassword">Show Password</label>
            </div>

            <div class="options">

                <div class="remember">
                    <input type="checkbox" id="remember" name="remember">
                    <label for="remember">Remember Me</label>
                </div>

                <div class="forgot">
                    <a href="#">Forgot Password?</a>
                </div>

            </div>

            <div class="btn">
                <button type="submit">Login</button>
            </div>

            <div class="create">
                <button type="button" onclick="location.href='{{ route('signup') }}'">Create Account</button>
            </div>

        </form>

    </div> <!-- end login -->

</div> <!-- end main -->

<script>
    // Show/hide password toggle
    const toggle = document.getElementById("showPassword");
    const password = document.getElementById("password");

    toggle.addEventListener("change", function(){
        if(this.checked){
            password.type = "text";
        } else {
            password.type = "password";
        }
    });
</script>

</body>
</html>
