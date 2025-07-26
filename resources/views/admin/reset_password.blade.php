<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Reset Password - Blood Bank</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(120deg, #1a1a1a 0%, #b91c1c 100%); min-height: 100vh; }
        .reset-card { margin: 7% auto; background: #fff; border-radius: 18px; max-width: 420px; box-shadow: 0 8px 32px 0 #b91c1c20; padding: 2.2rem 2rem; }
        .reset-title { font-weight: 800; font-size: 1.35em; text-align: center; color: #b91c1c; }
    </style>
</head>
<body>
    <div class="reset-card">
        <div class="reset-title mb-4"><i class="bi bi-shield-lock me-2"></i>Reset Password</div>
        <form method="POST" action="{{ route('admin.reset_password_post') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <input type="hidden" name="email" value="{{ $email ?? old('email') }}">
            {{-- Optional read-only display --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">Email address</label>
                <input type="email" class="form-control" value="{{ $email ?? old('email') }}" readonly>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">New Password</label>
                <input type="password" class="form-control" name="password" required>
                @error('password')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Confirm Password</label>
                <input type="password" class="form-control" name="password_confirmation" required>
            </div>
            <button class="btn btn-danger w-100 fw-bold" type="submit">Reset Password</button>
        </form>

    </div>
</body>
</html>
