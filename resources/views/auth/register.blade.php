<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Class Task Tracker</title>
</head>
<body>

    <h1>Class Task Tracker</h1>
    <h2>Register Siswa</h2>

    @if ($errors->any())
        <div style="color: red;">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form action="{{ url('/register') }}" method="POST">
        @csrf

        <div>
            <label>Nama</label>
            <input
                type="text"
                name="name"
                value="{{ old('name') }}"
                required
            >
        </div>

        <br>

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

        <div>
            <label>Konfirmasi Password</label>
            <input
                type="password"
                name="password_confirmation"
                required
            >
        </div>

        <br>

        <button type="submit">Daftar</button>
    </form>

    <p>
        Sudah punya akun?
        <a href="{{ url('/login') }}">Login</a>
    </p>

</body>
</html>