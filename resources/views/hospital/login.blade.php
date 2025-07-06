<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Hospital Login - Blood Bank Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <style>
        body {
            background: linear-gradient(120deg, #e52d27 60%, #fff 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', 'Arial', sans-serif;
        }
        .login-box {
            background: #fff;
            border-radius: 22px;
            box-shadow: 0 10px 32px rgba(229,45,39,0.13), 0 2px 8px rgba(0,0,0,0.06);
            width: 420px;
            margin: auto;
            padding: 2.7rem 2.2rem 2rem 2.2rem;
            position: relative;
            animation: fadeInDown 1s;
        }
        @keyframes fadeInDown {
            0% { opacity: 0; transform: translateY(-40px);}
            100% { opacity: 1; transform: translateY(0);}
        }
        .hospital-logo {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #e52d27 60%, #b31217 100%);
            color: #fff;
            border-radius: 50%;
            margin: 0 auto 1.2rem auto;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            box-shadow: 0 4px 18px rgba(229,45,39,0.18);
            border: 4px solid #fff;
        }
        .login-title {
            font-weight: bold;
            color: #e52d27;
            letter-spacing: 1px;
        }
        .form-control:focus {
            border-color: #e52d27;
            box-shadow: 0 0 0 0.15rem rgba(229,45,39,0.15);
        }
        .btn-login {
            background: linear-gradient(90deg, #e52d27 60%, #b31217 100%);
            color: #fff;
            font-weight: 600;
            border-radius: 12px;
            transition: background .2s, transform .1s;
            box-shadow: 0 2px 8px rgba(229,45,39,0.10);
        }
        .btn-login:hover {
            background: linear-gradient(90deg, #b31217 60%, #e52d27 100%);
            transform: translateY(-2px) scale(1.03);
        }
        .forgot-link {
            color: #e52d27;
            text-decoration: underline;
            font-size: 0.98rem;
            transition: color .2s;
        }
        .forgot-link:hover {
            color: #b31217;
        }
        .form-floating label {
            color: #b31217;
        }
        .input-group-text {
            background: #f8d7da;
            color: #e52d27;
            border: none;
        }
        .alert {
            animation: fadeIn .7s;
        }
        .switch-role {
            font-size: 0.97rem;
            color: #888;
        }
        .switch-role a {
            color: #e52d27;
            text-decoration: none;
            font-weight: 500;
        }
        .switch-role a:hover {
            text-decoration: underline;
        }
        .show-password {
            cursor: pointer;
            color: #b31217;
            font-size: 1.1rem;
        }
    </style>
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="login-box shadow-lg animate__animated animate__fadeInDown">
            <div class="hospital-logo animate__animated animate__pulse animate__infinite">
                <i class="bi bi-hospital"></i>
            </div>
            <h2 class="login-title text-center mb-2">Hospital Login</h2>
            <p class="text-center mb-4 text-muted" style="font-size:1.04rem;">Access your hospital dashboard and manage blood requests efficiently.</p>
            @if(session('error'))
                <div class="alert alert-danger d-flex align-items-center" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    {{ session('error') }}
                </div>
            @endif
            @if(session('success'))
                <div class="alert alert-success d-flex align-items-center" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    {{ session('success') }}
                </div>
            @endif
            <form method="POST" action="{{ route('hospital.hospitalAuthenticate') }}" autocomplete="off" id="hospitalLoginForm">
                @csrf
                <div class="mb-3">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="username" name="username" required placeholder="Username" value="{{ old('username') }}">
                        <label for="username"><i class="bi bi-person me-1"></i>Username</label>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="input-group">
                        <div class="form-floating flex-grow-1">
                            <input type="password" class="form-control" id="password" name="password" required placeholder="Password">
                            <label for="password"><i class="bi bi-lock me-1"></i>Password</label>
                        </div>
                        <span class="input-group-text show-password" id="togglePassword" title="Show/Hide Password">
                            <i class="bi bi-eye-slash" id="eyeIcon"></i>
                        </span>
                    </div>
                </div>

                <button type="submit" class="btn btn-login w-100 mt-1 mb-3 animate__animated animate__pulse animate__infinite animate__slower">Login</button>
            </form>
            <p class="text-center text-muted mt-4 mb-0" style="font-size: 0.96rem;">
                &copy; {{ date('Y') }} Blood Bank Management System
            </p>
        </div>
    </div>
    <!-- Bootstrap 5 + Icons JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Show/hide password
        document.getElementById('togglePassword').addEventListener('click', function() {
            const pwd = document.getElementById('password');
            const eye = document.getElementById('eyeIcon');
            if (pwd.type === 'password') {
                pwd.type = 'text';
                eye.classList.remove('bi-eye-slash');
                eye.classList.add('bi-eye');
            } else {
                pwd.type = 'password';
                eye.classList.remove('bi-eye');
                eye.classList.add('bi-eye-slash');
            }
        });

        // Interactive forgot password (demo only)
        document.getElementById('forgotPasswordLink').addEventListener('click', function(e) {
            e.preventDefault();
            alert('Please contact the hospital admin to reset your password.');
        });

        // Animate login button on submit
        document.getElementById('hospitalLoginForm').addEventListener('submit', function() {
            document.querySelector('.btn-login').classList.add('animate__heartBeat');
        });
    </script>
</body>
</html>
