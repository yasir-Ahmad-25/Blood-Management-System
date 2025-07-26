<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Forgot Password - Blood Bank</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        body { background: linear-gradient(120deg, #1a1a1a 0%, #b91c1c 100%); min-height: 100vh; }
        .forgot-card { margin: 5% auto; background: #fff; border-radius: 18px; max-width: 420px; box-shadow: 0 8px 32px 0 #b91c1c20; padding: 2.3rem 2rem; }
        .forgot-title { font-weight: 800; font-size: 1.4em; text-align: center; color: #b91c1c; }
    </style>
</head>
<body>
    <div class="forgot-card">
        <div class="forgot-title mb-4">
            <i class="bi bi-lock-fill me-2"></i>Forgot Password
        </div>
        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif
        <form method="POST" action="{{ route('admin.send_reset_link') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-semibold">Email address</label>
                <input type="email" class="form-control" name="email" required>
                @error('email')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
            <button class="btn btn-danger w-100 fw-bold" type="submit">Send Reset Link</button>
        </form>
        <div class="mt-3 text-center">
            <a href="{{ route('auth.login') }}" class="text-decoration-none">Back to Login</a>
        </div>
    </div>
</body>
</html>
