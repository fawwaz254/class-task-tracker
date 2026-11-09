<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Class Task Tracker</title>
</head>
<body>

    <h1>Class Task Tracker</h1>
    <h2>Login</h2>

    @if ($errors->any())
        <div style="color: red;">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form action="{{ url('/login') }}" method="POST">
        @csrf

        <div>
            <label>Email</label>
            <input
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
            >
        </div>

        <br>

        <div>
            <label>Password</label>
            <input
                type="password"
                name="password"
                required
            >
        </div>

        <br>

        <button type="submit">Login</button>
    </form>

    <p>
        Belum punya akun?
        <a href="{{ url('/register') }}">Daftar sekarang</a>
    </p>

</body>
</html>