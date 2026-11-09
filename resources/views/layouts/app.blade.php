
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title') - Class Task Tracker</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: #f8fafc;
            color: #1e293b;
            min-height: 100vh;
        }

        /* NAVBAR */
        .navbar {
            background: #0f172a;
            color: white;
            padding: 0 32px;
            min-height: 70px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            box-shadow: 0 3px 12px rgba(15, 23, 42, 0.12);
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: white;
        }

        .brand-icon {
            width: 39px;
            height: 39px;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #2563eb;
            border-radius: 11px;
            font-size: 19px;
            font-weight: 700;
        }

        .brand-text h2 {
            margin: 0;
            font-size: 17px;
            font-weight: 700;
            letter-spacing: 0.2px;
        }

        .brand-text span {
            display: block;
            margin-top: 3px;
            font-size: 11px;
            color: #94a3b8;
        }

        .navbar-right {
            display: flex;
            align-items: center;
            gap: 18px;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #334155;
            border-radius: 50%;
            color: #bfdbfe;
            font-size: 14px;
            font-weight: 700;
        }

        .user-details {
            display: flex;
            flex-direction: column;
            gap: 3px;
        }

        .user-name {
            color: white;
            font-size: 13px;
            font-weight: 600;
        }

        .user-role {
            color: #94a3b8;
            font-size: 11px;
            text-transform: capitalize;
        }

        .logout-form {
            margin: 0;
        }

        .logout-btn {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: #334155;
            color: white;
            border: 1px solid #475569;
            padding: 9px 14px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 12px;
            font-weight: 600;
            transition: 0.2s;
        }

        .logout-btn:hover {
            background: #dc2626;
            border-color: #dc2626;
        }

        /* MAIN CONTENT */
        .container {
            max-width: 1200px;
            width: 100%;
            margin: 35px auto;
            padding: 0 24px;
            min-height: calc(100vh - 140px);
        }

        /* GENERAL CARD */
        .card {
            background: white;
            padding: 25px;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            box-shadow: 0 3px 12px rgba(15, 23, 42, 0.04);
        }

        .role {
            display: inline-block;
            background: #dbeafe;
            color: #1d4ed8;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        /* FOOTER */
        .footer {
            padding: 18px 24px;
            text-align: center;
            color: #94a3b8;
            font-size: 12px;
            border-top: 1px solid #e2e8f0;
            background: white;
        }

        /* RESPONSIVE */
        @media (max-width: 600px) {
            .navbar {
                padding: 13px 18px;
                min-height: 65px;
            }

            .brand-text h2 {
                font-size: 14px;
            }

            .brand-text span {
                font-size: 10px;
            }

            .navbar-right {
                gap: 10px;
            }

            .user-details {
                display: none;
            }

            .user-avatar {
                width: 33px;
                height: 33px;
            }

            .logout-btn {
                padding: 8px 10px;
                font-size: 11px;
            }

            .container {
                margin: 25px auto;
                padding: 0 15px;
            }
        }

        @media (max-width: 360px) {
            .brand-text span {
                display: none;
            }

            .navbar {
                padding: 12px;
            }
        }
    </style>
</head>

<body>

    {{-- NAVBAR --}}
    <nav class="navbar">

        <a href="{{ url('/dashboard') }}" class="navbar-brand">

            <div class="brand-icon">
                C
            </div>

            <div class="brand-text">
                <h2>Class Task Tracker</h2>
                <span>Learning Task Management</span>
            </div>

        </a>

        <div class="navbar-right">

            @auth
                <div class="user-info">

                    <div class="user-avatar">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>

                    <div class="user-details">
                        <span class="user-name">
                            {{ auth()->user()->name }}
                        </span>

                        <span class="user-role">
                            {{ auth()->user()->role }}
                        </span>
                    </div>

                </div>

                <form action="{{ url('/logout') }}" method="POST" class="logout-form">
                    @csrf

                    <button type="submit" class="logout-btn">
                        <span>↪</span>
                        Logout
                    </button>
                </form>
            @endauth

        </div>

    </nav>

    {{-- MAIN CONTENT --}}
    <main class="container">
        @yield('content')
    </main>

    {{-- FOOTER --}}
    <footer class="footer">
        &copy; {{ date('Y') }} Class Task Tracker. All rights reserved.
    </footer>

</body>
</html>
