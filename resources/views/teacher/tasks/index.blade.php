@extends('layouts.app')

@section('title', 'Daftar Tugas')

@section('content')

<div class="card">

    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1>Daftar Tugas</h1>
            <p>Kelola tugas yang diberikan kepada siswa.</p>
        </div>

        <a href="{{ route('teacher.tasks.create') }}"
           style="background: #2563eb; color: white; padding: 10px 16px; border-radius: 6px; text-decoration: none;">
            + Tambah Tugas
        </a>
    </div>

    <hr>

    @if (session('success'))
        <div style="background: #dcfce7; color: #166534; padding: 12px; border-radius: 6px; margin-bottom: 15px;">
            {{ session('success') }}
        </div>
    @endif

    @if ($tasks->isEmpty())
        <p>Belum ada tugas yang dibuat.</p>
    @else

        <div style="overflow-x: auto;">
            <table width="100%" cellpadding="12" cellspacing="0" style="border-collapse: collapse;">
                <thead>
                    <tr style="background: #f1f5f9; text-align: left;">
                        <th>No</th>
                        <th>Judul Tugas</th>
                        <th>Kelas</th>
                        <th>Batas Waktu</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($tasks as $task)
                        <tr style="border-bottom: 1px solid #e5e7eb;">
                            <td>{{ $tasks->firstItem() + $loop->index }}</td>

                            <td>{{ $task->title }}</td>

                            <td>{{ $task->classroom->name }}</td>

                            <td>{{ $task->due_date->format('d-m-Y H:i') }}</td>

                            <td>
                                <a href="{{ route('teacher.tasks.edit', $task->id) }}">
                                    Edit
                                </a>

                                <form action="{{ route('teacher.tasks.destroy', $task->id) }}"
                                      method="POST"
                                      style="display: inline;"
                                      onsubmit="return confirm('Yakin ingin menghapus tugas ini?')">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            style="background: #ef4444; color: white; border: none; padding: 6px 10px; border-radius: 4px; cursor: pointer;">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div style="margin-top: 20px;">
            {{ $tasks->links() }}
        </div>

    @endif

    <div style="margin-top: 20px;">
        <a href="{{ url('/teacher/dashboard') }}">Kembali ke Dashboard</a>
    </div>

</div>

@endsection