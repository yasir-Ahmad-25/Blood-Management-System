<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Blood Bank Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(120deg, #000 60%, #fff 100%);
            min-height: 100vh;
        }
        .login-box {
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.13);
            width: 450px;
            margin: auto;
            padding: 2.5rem 2rem;
            position: relative;
            /* top: 50%; */
            /* transform: translateY(15%); */
        }
        .login-title {
            font-weight: bold;
            color: #111;
        }
        .form-control:focus {
            border-color: #222;
            box-shadow: 0 0 0 0.15rem rgba(0,0,0,0.18);
        }
        .btn-login {
            background: #000;
            color: #fff;
            font-weight: 600;
            border-radius: 10px;
            transition: background .2s;
        }
        /* .btn-login:hover {
            background: #111;
            color: #fff;
        } */
        .login-box .logo-circle {
            width: 58px;
            height: 58px;
            background: #000;
            color: #fff;
            border-radius: 50%;
            margin: 0 auto 1.5rem auto;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.1rem;
            box-shadow: 0 4px 14px rgba(0,0,0,0.13);
        }
        .login-box .forgot-link {
            color: #000;
            text-decoration: underline;
            font-size: 0.98rem;
        }
        /* .login-box .forgot-link:hover {
            color: #444;
        } */
    </style>
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="login-box">
            <div class="logo-circle mb-3">
                <i class="bi bi-droplet"></i>
            </div>
            <h2 class="login-title text-center mb-4">Blood Bank Login</h2>
            @if(session('error'))
                <div class="alert alert-danger d-flex align-items-center" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    {{ session('error') }}
                </div>
            @endif
            
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <form method="POST" action="{{ route('auth.authenticate') }}">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" required autocomplete="false" placeholder="Enter your email" value="{{ old('email') }}">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label fw-semibold">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required autocomplete="false" placeholder="Enter password">
                </div>
                <div class="mb-3 d-flex justify-content-between align-items-center">
                    <div>
                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                        <label class="form-check-label" for="remember">Remember me</label>
                    </div>
                    <a href="#" class="forgot-link">Forgot Password?</a>
                </div>
                <button type="submit" class="btn btn-login w-100 mt-1 mb-3">Login</button>
            </form>
            <p class="text-center text-muted mb-0" style="font-size: 0.96rem;">
                &copy; {{ date('Y') }} Blood Bank Management System
            </p>
        </div>
    </div>
    <!-- Bootstrap 5 + Icons JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <!-- Animate.css for subtle fade in -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
</body>
</html>
