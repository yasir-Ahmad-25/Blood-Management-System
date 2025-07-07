<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Hospital Login - Blood Bank Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(120deg, #fff 65%, #ffe7e7 100%);
            min-height: 100vh;
        }
        .login-box {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 8px 36px rgba(223,55,55,0.09), 0 1.5px 5px rgba(0,0,0,0.05);
            max-width: 380px;
            margin: auto;
            padding: 2.5rem 2.2rem;
            position: relative;
            top: 48%;
            transform: translateY(10%);
        }
        .login-logo {
            width: 62px;
            height: 62px;
            background: #f34242;
            color: #fff;
            border-radius: 50%;
            margin: 0 auto 1.4rem auto;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.1rem;
            box-shadow: 0 3px 13px rgba(223,55,55,0.18);
        }
        .login-title {
            font-weight: 700;
            color: #d32f2f;
            margin-bottom: 0.45rem;
        }
        .form-control {
            border-radius: 12px;
            font-size: 1.05rem;
            border: 1.5px solid #eee;
            background: #fcfcfc;
            transition: border 0.2s;
        }
        .form-control:focus {
            border-color: #f34242;
            box-shadow: 0 0 0 0.07rem #f3424236;
        }
        .input-group-text {
            background: #f7eaea;
            border: none;
        }
        .btn-login {
            background: linear-gradient(90deg, #fa5757 60%, #d32f2f 100%);
            color: #fff;
            font-weight: 600;
            border-radius: 10px;
            border: none;
            box-shadow: 0 2px 10px rgba(223,55,55,0.10);
            transition: background .17s;
        }
        .btn-login:hover, .btn-login:focus {
            background: linear-gradient(90deg, #d32f2f 60%, #fa5757 100%);
            color: #fff;
        }
        .text-muted {
            font-size: 0.97em;
        }
        .alert {
            font-size: 0.99em;
        }
    </style>
    <!-- Optionally: Add a hospital icon SVG or FontAwesome -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="login-box animate__animated animate__fadeInDown">
            <div class="login-logo mb-2 shadow">
                <i class="bi bi-hospital"></i>
            </div>
            <h2 class="login-title text-center mb-2">Hospital Login</h2>
            <p class="text-center text-muted mb-3">
                Access your hospital dashboard and manage blood requests efficiently.
            </p>
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <form method="POST" action="{{ route('hospital.hospitalAuthenticate') }}">
                @csrf
                <div class="mb-3">
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                        <input type="text" class="form-control" name="username" required placeholder="Username">
                    </div>
                </div>
                <div class="mb-3">
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input type="password" class="form-control" name="password" required placeholder="Password" id="password">
                        <span class="input-group-text" style="cursor:pointer" onclick="togglePassword()">
                            <i class="bi bi-eye-slash" id="togglePass"></i>
                        </span>
                    </div>
                </div>
                <button type="submit" class="btn btn-login w-100 mb-3 mt-1">Login</button>
            </form>
            <p class="text-center text-muted mb-0">&copy; {{ date('Y') }} Blood Bank Management System</p>
        </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function togglePassword() {
            var pass = document.getElementById("password");
            var icon = document.getElementById("togglePass");
            if (pass.type === "password") {
                pass.type = "text";
                icon.classList.remove("bi-eye-slash");
                icon.classList.add("bi-eye");
            } else {
                pass.type = "password";
                icon.classList.remove("bi-eye");
                icon.classList.add("bi-eye-slash");
            }
        }
    </script>
    <!-- Animate.css for optional subtle fade-in -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
</body>
</html>
