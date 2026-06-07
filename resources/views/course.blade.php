@php
    use Illuminate\Support\Facades\DB;

    $user = session('username'); // get logged-in username

    // get courses if needed (optional, depends on your design)
    $courses = DB::table('user_courses')->where('username', $user)->get();
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>C0DiA Courses</title>
    <style>
        body{
    margin:0;
    font-family:'Segoe UI',sans-serif;
    background:#f8fafc;
    color:#1e293b;
    display:flex;
}

/* SIDEBAR */
.sidebar{
    width:240px;
    background:#ffffff;
    height:100vh;
    padding:20px;
    border-right:1px solid #e2e8f0;
}

.sidebar h2{
    color:#b91c1c; /* changed from blue to red */
    margin-bottom:30px;
}

.sidebar a{
    display:block;
    padding:10px;
    margin-bottom:10px;
    text-decoration:none;
    color:#475569;
    border-radius:8px;
    transition:0.2s;
}

.sidebar a:hover{
    background:#fee2e2; /* light red hover */
    color:#b91c1c; /* red text on hover */
}

/* MAIN CONTENT */
.main{
    flex:1;
}

.header{
    padding:20px;
    font-size:24px;
    font-weight:bold;
    color:#0f172a;
}

/* CONTAINER */
.container{
    padding:20px;
}

/* GRID */
.course-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit, minmax(250px,1fr));
    gap:20px;
}

/* COURSE CARD */
.course-card{
    background:#ffffff;
    padding:20px;
    border-radius:12px;
    transition:0.3s;
    box-shadow:0 5px 15px rgba(0,0,0,0.05);
}

.course-card:hover{
    transform:translateY(-5px);
    box-shadow:0 10px 25px rgba(0,0,0,0.08);
}

.course-card h3{
    margin-top:0;
    color:#0f172a;
}

.course-card p{
    color:#64748b;
    font-size:14px;
}

/* BUTTON */
.enroll-btn{
    display:inline-block;
    margin-top:15px;
    padding:10px 15px;
    background:#b91c1c; /* red button */
    color:white;
    text-decoration:none;
    border-radius:8px;
    transition:0.3s;
}

.enroll-btn:hover{
    background:#991b1b; /* darker red on hover */
}
</style>
<body>

    <!-- SIDEBAR -->
    <div class="sidebar">
        <h2>C0DiA</h2>
        <a href="{{ route('dashboard') }}">🏠 Home</a>
        <a href="{{ route('profile') }}">👤 Profile</a>
        <a href="{{ route('course') }}">📚 Courses</a>
        <a href="{{ route('certificate.show') }}">🏆 Certificates</a>
        <a href="{{ route('logout') }}">🚪 Logout</a>
    </div>

    <!-- MAIN -->
    <div class="main">

        <div class="header">📚 Courses</div>

        <div class="container">

            <div class="course-grid">

                <div class="course-card">
                    <h3>C Programming</h3>
                    <p>Learn the fundamentals of C and low-level programming.</p>
                    <a href="{{ route('c.course') }}" class="enroll-btn">Enroll Now</a>
                </div>

                <div class="course-card">
                    <h3>C++ Programming</h3>
                    <p>Master object-oriented programming with C++.</p>
                    <a href="{{ route('cpp.course') }}" class="enroll-btn">Enroll Now</a>
                </div>

                <div class="course-card">
                    <h3>Java Programming</h3>
                    <p>Build powerful applications using Java.</p>
                    <a href="{{ route('java.course') }}" class="enroll-btn">Enroll Now</a>
                </div>

                <div class="course-card">
                    <h3>Python Programming</h3>
                    <p>Explore Python for web, data science, and more.</p>
                    <a href="{{ route('py.course') }}" class="enroll-btn">Enroll Now</a>
                </div>

                <div class="course-card">
                    <h3>Web Development</h3>
                    <p>Learn HTML, CSS, and JavaScript to build websites.</p>
                    <a href="{{ route('html.course') }}" class="enroll-btn">Enroll Now</a>
                </div>
            </div>

        </div>

    </div>

</body>

</html>
