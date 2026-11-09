@extends('layouts.app')

@section('title', 'Dashboard Guru')

@section('content')

    <div class="card">
        <h1>Dashboard Guru</h1>

        <p>Selamat datang, <strong>{{ auth()->user()->name }}</strong>!</p>

        <span class="role">Guru</span>

        <hr>

        <h3>Selamat datang di Class Task Tracker</h3>

        <p>
            Melalui dashboard ini, guru dapat mengelola kelas,
            membuat tugas, dan memantau penyelesaian tugas siswa.
        </p>

        <a href="{{ route('teacher.tasks.index') }}"
        style="display: inline-block; background: #2563eb; color: white; padding: 10px 16px; border-radius: 6px; text-decoration: none;">
            Kelola Tugas
        </a>
    </div>

@endsection