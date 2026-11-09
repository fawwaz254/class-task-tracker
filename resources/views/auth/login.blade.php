
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Class Task Tracker</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Arial, sans-serif;
        }

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f1f5f9;
            padding: 24px;
        }

        .auth-container {
            width: 100%;
            max-width: 430px;
        }

        .brand {
            text-align: center;
            margin-bottom: 28px;
        }

        .brand-icon {
            width: 54px;
            height: 54px;
            margin: 0 auto 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 16px;
            background: #2563eb;
            color: white;
            font-size: 25px;
            font-weight: bold;
            box-shadow: 0 8px 20px rgba(37, 99, 235, 0.2);
        }

        .brand h1 {
            font-size: 25px;
            color: #0f172a;
            font-weight: 700;
        }

        .brand p {
            color: #64748b;
            font-size: 14px;
            margin-top: 7px;
        }

        .auth-card {
            background: white;
            padding: 35px;
            border-radius: 18px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 15px 40px rgba(15, 23, 42, 0.06);
        }

        .auth-header {
            margin-bottom: 27px;
        }

        .auth-header h2 {
            font-size: 23px;
            color: #0f172a;
            margin-bottom: 8px;
        }

        .auth-header p {
            font-size: 14px;
            color: #64748b;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #334155;
            margin-bottom: 9px;
        }

        .form-group input {
            width: 100%;
            padding: 13px 14px;
            border: 1px solid #cbd5e1;
            border-radius: 9px;
            font-size: 14px;
            color: #0f172a;
            outline: none;
            transition: 0.2s;
        }

        .form-group input:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .error-box {
            background: #fef2f2;
            color: #b91c1c;
            border: 1px solid #fecaca;
            padding: 13px 15px;
            border-radius: 9px;
            font-size: 13px;
            margin-bottom: 20px;
        }

        .error-box ul {
            padding-left: 18px;
        }

        .error-box li + li {
            margin-top: 5px;
        }

        .btn-submit {
            width: 100%;
            padding: 14px;
            background: #2563eb;
            border: none;
            border-radius: 9px;
            color: white;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.2s;
        }

        .btn-submit:hover {
            background: #1d4ed8;
            transform: translateY(-1px);
        }

        .auth-footer {
            text-align: center;
            margin-top: 24px;
            font-size: 14px;
            color: #64748b;
        }

        .auth-footer a {
            color: #2563eb;
            text-decoration: none;
            font-weight: 600;
        }

        .auth-footer a:hover {
            text-decoration: underline;
        }

        .copyright {
            text-align: center;
            margin-top: 25px;
            color: #94a3b8;
            font-size: 12px;
        }

        @media (max-width: 480px) {
            body {
                padding: 16px;
            }

            .auth-card {
                padding: 25px 20px;
            }

            .brand h1 {
                font-size: 22px;
            }
        }
    </style>
</head>
<body>

    <div class="auth-container">

        <div class="brand">
            <div class="brand-icon">C</div>
            <h1>Class Task Tracker</h1>
            <p>Manage your classroom tasks efficiently.</p>
        </div>

        <div class="auth-card">

            <div class="auth-header">
                <h2>Welcome Back!</h2>
                <p>Silakan login untuk melanjutkan ke akun Anda.</p>
            </div>

            @if ($errors->any())
                <div class="error-box">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ url('/login') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="Masukkan email Anda"
                        required
                        autocomplete="email"
                    >
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Masukkan password Anda"
                        required
                        autocomplete="current-password"
                    >
                </div>

                <button type="submit" class="btn-submit">
                    Login to Account
                </button>
            </form>

            <div class="auth-footer">
                Belum punya akun?
                <a href="{{ url('/register') }}">Daftar sekarang</a>
            </div>

        </div>

        <div class="copyright">
            &copy; {{ date('Y') }} Class Task Tracker. All rights reserved.
        </div>

    </div>

</body>
</html>
