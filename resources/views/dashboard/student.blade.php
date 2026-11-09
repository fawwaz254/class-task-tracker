
@extends('layouts.app')

@section('title', 'Dashboard Siswa')

@section('content')

<style>
    .student-dashboard {
        max-width: 1100px;
        margin: 0 auto;
    }

    .welcome-card {
        position: relative;
        overflow: hidden;
        padding: 35px;
        border-radius: 18px;
        background: linear-gradient(120deg, #1d4ed8, #2563eb, #3b82f6);
        color: white;
        margin-bottom: 28px;
        box-shadow: 0 12px 28px rgba(37, 99, 235, 0.15);
    }

    .welcome-card::after {
        content: "";
        position: absolute;
        width: 220px;
        height: 220px;
        right: -65px;
        top: -85px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.09);
    }

    .welcome-card::before {
        content: "";
        position: absolute;
        width: 140px;
        height: 140px;
        right: 95px;
        bottom: -100px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.08);
    }

    .welcome-content {
        position: relative;
        z-index: 1;
    }

    .welcome-label {
        display: inline-block;
        padding: 6px 12px;
        background: rgba(255, 255, 255, 0.16);
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        letter-spacing: 0.5px;
        margin-bottom: 18px;
    }

    .welcome-card h1 {
        font-size: 28px;
        margin-bottom: 10px;
        font-weight: 700;
    }

    .welcome-card p {
        font-size: 15px;
        line-height: 1.7;
        color: rgba(255, 255, 255, 0.9);
        max-width: 600px;
        margin-bottom: 23px;
    }

    .welcome-button {
        display: inline-flex;
        align-items: center;
        gap: 9px;
        padding: 12px 19px;
        background: white;
        color: #2563eb;
        border-radius: 9px;
        text-decoration: none;
        font-size: 14px;
        font-weight: 700;
        transition: 0.2s;
    }

    .welcome-button:hover {
        background: #eff6ff;
        transform: translateY(-2px);
    }

    .dashboard-section {
        margin-bottom: 20px;
    }

    .section-heading {
        margin-bottom: 17px;
    }

    .section-heading h2 {
        color: #0f172a;
        font-size: 19px;
        margin-bottom: 6px;
    }

    .section-heading p {
        color: #64748b;
        font-size: 14px;
    }

    .feature-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 18px;
    }

    .feature-card {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 23px;
        transition: 0.2s;
    }

    .feature-card:hover {
        border-color: #bfdbfe;
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(15, 23, 42, 0.05);
    }

    .feature-icon {
        width: 44px;
        height: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #eff6ff;
        color: #2563eb;
        border-radius: 11px;
        font-size: 21px;
        margin-bottom: 16px;
    }

    .feature-card h3 {
        color: #0f172a;
        font-size: 16px;
        margin-bottom: 8px;
    }

    .feature-card p {
        color: #64748b;
        font-size: 13px;
        line-height: 1.7;
    }

    .info-card {
        padding: 20px 22px;
        background: #eff6ff;
        border: 1px solid #dbeafe;
        border-radius: 13px;
        display: flex;
        align-items: flex-start;
        gap: 13px;
        margin-top: 22px;
    }

    .info-icon {
        color: #2563eb;
        font-size: 19px;
    }

    .info-card h3 {
        color: #1e40af;
        font-size: 14px;
        margin-bottom: 5px;
    }

    .info-card p {
        color: #475569;
        font-size: 13px;
        line-height: 1.6;
    }

    @media (max-width: 600px) {
        .welcome-card {
            padding: 25px 21px;
        }

        .welcome-card h1 {
            font-size: 23px;
        }

        .welcome-card p {
            font-size: 14px;
        }

        .feature-grid {
            grid-template-columns: 1fr;
        }

        .feature-card {
            padding: 20px;
        }
    }
</style>

<div class="student-dashboard">

    {{-- Welcome Section --}}
    <div class="welcome-card">
        <div class="welcome-content">

            <span class="welcome-label">
                STUDENT DASHBOARD
            </span>

            <h1>
                Halo, {{ auth()->user()->name }}!
            </h1>

            <p>
                Selamat datang di Class Task Tracker.
                Pantau tugas dari guru, kelola aktivitas belajar,
                dan pastikan semua tugas selesai tepat waktu.
            </p>

            <a href="{{ route('student.tasks.index') }}" class="welcome-button">
                Lihat Daftar Tugas
                <span>→</span>
            </a>

        </div>
    </div>

    {{-- Feature Section --}}
    <div class="dashboard-section">

        <div class="section-heading">
            <h2>Aktivitas Pembelajaran</h2>
            <p>Fitur yang dapat kamu gunakan melalui dashboard ini.</p>
        </div>

        <div class="feature-grid">

            <div class="feature-card">
                <div class="feature-icon">
                    ☑
                </div>

                <h3>Daftar Tugas</h3>

                <p>
                    Lihat seluruh tugas yang diberikan guru
                    dari kelas yang kamu ikuti.
                </p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    ✓
                </div>

                <h3>Status Penyelesaian</h3>

                <p>
                    Perbarui status tugas setelah selesai
                    dan pantau pekerjaan yang masih tertunda.
                </p>
            </div>

        </div>

    </div>

    {{-- Information Section --}}
    <div class="info-card">
        <div class="info-icon">ⓘ</div>

        <div>
            <h3>Informasi Siswa</h3>
            <p>
                Pastikan kamu memeriksa daftar tugas secara berkala
                agar tidak melewatkan tugas dan tenggat waktu
                yang diberikan oleh guru.
            </p>
        </div>
    </div>

</div>

@endsection
