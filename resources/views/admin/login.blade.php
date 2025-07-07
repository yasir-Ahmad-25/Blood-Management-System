<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Blood Bank Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(120deg, #1a1a1a 0%, #b91c1c 100%);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            backdrop-filter: blur(6px);
            background: rgba(255,255,255,0.96);
            box-shadow: 0 8px 32px 0 rgba(34, 34, 34, 0.17);
            border-radius: 28px;
            padding: 2.5rem 2rem;
            width: 480px;
        }
        .blood-icon {
            width: 82px;
            height: 82px;
            display: block;
            margin: 0 auto 1rem auto;
            background: linear-gradient(135deg, #fff 55%, #d32f2f 100%);
            border-radius: 50%;
            box-shadow: 0 2px 20px #d32f2f20;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.4rem;
            animation: dropFloat 1.7s ease-in-out infinite alternate;
        }
        @keyframes dropFloat {
            0% { transform: translateY(0);}
            100% { transform: translateY(6px);}
        }
        .form-label {
            font-weight: 600;
        }
        .form-control {
            border-radius: 12px;
            border: 1.5px solid #eee;
            background: #fafbfc;
            transition: border .15s, box-shadow .15s;
        }
        .form-control:focus {
            border: 1.5px solid #b91c1c;
            box-shadow: 0 2px 8px #b91c1c11;
        }
        .login-btn {
            border-radius: 12px;
            background: linear-gradient(120deg,#b91c1c 70%, #a20d0d 100%);
            color: #fff;
            font-weight: bold;
            font-size: 1.1em;
            letter-spacing: 1px;
            transition: background .22s, transform .13s;
            box-shadow: 0 2px 10px #b91c1c20;
        }
        .login-btn:hover, .login-btn:focus {
            background: linear-gradient(110deg,#a20d0d 70%, #b91c1c 100%);
            transform: translateY(-2px) scale(1.02);
        }
        .login-title {
            font-weight: 800;
            font-size: 2em;
            text-align: center;
            margin-bottom: .5rem;
            color: #1a1a1a;
        }
        .login-footer {
            font-size: .98em;
            text-align: center;
            color: #575757;
            margin-top: 2.3rem;
        }
        .forgot-link {
            font-size: .98em;
            color: #b91c1c;
            text-decoration: none;
        }
        .forgot-link:hover {
            text-decoration: underline;
        }
        @media (max-width:500px) {
            .login-card { padding: 2rem 0.8rem; min-width: 99vw; border-radius: 0; }
        }
    </style>
</head>
<body>
    <div class="login-card mx-auto">
        <span class="blood-icon mb-2">
            <i class="bi bi-droplet-half" style="color:#b91c1c;"></i>
        </span>
        <div class="login-title">Blood Bank Login</div>
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
                <label for="email" class="form-label">Email address</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email" required autofocus>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label d-flex justify-content-between align-items-center">
                    <span>Password</span>
                    {{-- <a href="#" class="forgot-link">Forgot Password?</a> --}}
                </label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Enter password" required>
            </div>
            {{-- <div class="mb-3 form-check mb-4">
                <input type="checkbox" class="form-check-input" name="remember" id="remember">
                <label class="form-check-label" for="remember" style="font-size:.98em;">Remember me</label>
            </div> --}}
            <button type="submit" class="btn login-btn w-100 mt-1 mb-1">Login</button>
        </form>
        <div class="login-footer">
            &copy; {{ date('Y') }} Blood Bank Management System
        </div>
    </div>
</body>
</html>
