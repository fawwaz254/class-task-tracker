@extends('layouts.app')

@section('title', 'Dashboard Siswa')

@section('content')

    <div class="card">
        <h1>Dashboard Siswa</h1>

        <p>Selamat datang, <strong>{{ auth()->user()->name }}</strong>!</p>

        <span class="role">Siswa</span>

        <hr>

        <h3>Selamat datang di Class Task Tracker</h3>

        <p>
            Melalui dashboard ini, siswa dapat melihat daftar tugas
            dari guru dan memperbarui status penyelesaian tugas.
        </p>

        <p>Fitur daftar dan penyelesaian tugas akan tersedia pada tahap berikutnya.</p>
    </div>

@endsection