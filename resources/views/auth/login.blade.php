<!DOCTYPE html>
<html>
<head>
    <title>Login - Roxas Memorial Provincial Hospital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(120deg, #2980b9, #8e44ad);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            width: 100%;
            max-width: 400px;
            padding: 30px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }
        .btn-primary {
            background-color: #2980b9;
            border: none;
        }
        .btn-primary:hover {
            background-color: #2573a7;
        }
    </style>
</head>
<body>

    <div class="login-card">
        <div class="text-center mb-4">
            <div style="font-size: 3rem;">🏥</div>
            <h4 class="mt-2 text-dark font-weight-bold">Supply Inventory</h4>
            <p class="text-muted small">Roxas Memorial Provincial Hospital</p>
        </div>

        @if (session('status'))
            <div class="alert alert-success small mb-3">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger small mb-3">
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label text-muted small fw-bold">EMAIL ADDRESS</label>
                <input type="email" id="email" name="email" class="form-control" 
                       value="{{ old('email') }}" required autofocus placeholder="name@hospital.com">
            </div>

            <div class="mb-3">
                <label for="password" class="form-label text-muted small fw-bold">PASSWORD</label>
                <input type="password" id="password" name="password" class="form-control" 
                       required autocomplete="current-password" placeholder="••••••••">
            </div>

            <div class="form-check mb-3">
                <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                <label for="remember_me" class="form-check-label small text-muted">
                    Remember me
                </label>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary py-2 fw-bold">
                    LOG IN
                </button>
            </div>

            <div class="text-center mt-3">
                @if (Route::has('password.request'))
                    <a class="small text-decoration-none text-muted" href="{{ route('password.request') }}">
                        Forgot your password?
                    </a>
                @endif
            </div>
        </form>
    </div>

</body>
</html>