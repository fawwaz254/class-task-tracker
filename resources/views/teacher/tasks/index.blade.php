
@extends('layouts.app')

@section('title', 'Daftar Tugas')

@section('content')

<style>
    .teacher-tasks {
        max-width: 1200px;
        margin: 0 auto;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        flex-wrap: wrap;
        margin-bottom: 24px;
    }

    .page-header h1 {
        color: #0f172a;
        font-size: 26px;
        margin-bottom: 7px;
    }

    .page-header p {
        color: #64748b;
        font-size: 14px;
    }

    .add-button {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 17px;
        background: #2563eb;
        color: white;
        border-radius: 9px;
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
        transition: 0.2s;
    }

    .add-button:hover {
        background: #1d4ed8;
        transform: translateY(-2px);
    }

    .alert-success {
        background: #dcfce7;
        color: #166534;
        border: 1px solid #bbf7d0;
        padding: 13px 16px;
        border-radius: 9px;
        margin-bottom: 20px;
        font-size: 14px;
    }

    .table-card {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 13px;
        overflow: hidden;
    }

    .table-heading {
        padding: 19px 21px;
        border-bottom: 1px solid #e2e8f0;
    }

    .table-heading h2 {
        color: #0f172a;
        font-size: 16px;
        margin-bottom: 5px;
    }

    .table-heading p {
        color: #64748b;
        font-size: 12px;
    }

    .table-responsive {
        width: 100%;
        overflow-x: auto;
    }

    .tasks-table {
        width: 100%;
        min-width: 650px;
        border-collapse: collapse;
    }

    .tasks-table th {
        background: #f8fafc;
        color: #475569;
        text-align: left;
        padding: 14px 16px;
        font-size: 12px;
        font-weight: 700;
        white-space: nowrap;
    }

    .tasks-table td {
        padding: 15px 16px;
        border-top: 1px solid #f1f5f9;
        color: #475569;
        font-size: 13px;
        vertical-align: middle;
    }

    .tasks-table tbody tr:hover {
        background: #f8fafc;
    }

    .task-title {
        color: #0f172a;
        font-weight: 600;
    }

    .class-badge {
        display: inline-block;
        padding: 6px 10px;
        background: #eff6ff;
        color: #1d4ed8;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        white-space: nowrap;
    }

    .action-group {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .edit-button {
        display: inline-block;
        padding: 8px 12px;
        background: #eff6ff;
        color: #2563eb;
        border-radius: 7px;
        text-decoration: none;
        font-size: 12px;
        font-weight: 600;
        transition: 0.2s;
    }

    .edit-button:hover {
        background: #dbeafe;
    }

    .delete-button {
        padding: 8px 12px;
        background: #fee2e2;
        color: #dc2626;
        border: none;
        border-radius: 7px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: 0.2s;
    }

    .delete-button:hover {
        background: #fecaca;
    }

    .delete-form {
        margin: 0;
    }

    .empty-state {
        text-align: center;
        padding: 55px 20px;
    }

    .empty-icon {
        font-size: 38px;
        margin-bottom: 13px;
    }

    .empty-state h3 {
        color: #334155;
        font-size: 16px;
        margin-bottom: 7px;
    }

    .empty-state p {
        color: #94a3b8;
        font-size: 13px;
        margin-bottom: 18px;
    }

    .pagination-wrapper {
        padding: 18px 20px;
        border-top: 1px solid #e2e8f0;
    }

    .back-link {
        display: inline-block;
        margin-top: 20px;
        color: #2563eb;
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
    }

    .back-link:hover {
        text-decoration: underline;
    }

    @media (max-width: 600px) {
        .page-header h1 {
            font-size: 23px;
        }

        .add-button {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<div class="teacher-tasks">

    {{-- Page Header --}}
    <div class="page-header">

        <div>
            <h1>Daftar Tugas</h1>
            <p>Kelola tugas pembelajaran yang diberikan kepada siswa.</p>
        </div>

        <a href="{{ route('teacher.tasks.create') }}" class="add-button">
            <span>+</span>
            Tambah Tugas
        </a>

    </div>

    {{-- Success Message --}}
    @if (session('success'))
        <div class="alert-success">
            ✓ {{ session('success') }}
        </div>
    @endif

    {{-- Task List --}}
    <div class="table-card">

        <div class="table-heading">
            <h2>Daftar Tugas Saya</h2>
            <p>Informasi tugas yang telah dibuat untuk kelas.</p>
        </div>

        @if ($tasks->isEmpty())

            <div class="empty-state">

                <div class="empty-icon">📋</div>

                <h3>Belum Ada Tugas</h3>

                <p>
                    Kamu belum membuat tugas pembelajaran.
                    Mulai dengan menambahkan tugas baru.
                </p>

                <a href="{{ route('teacher.tasks.create') }}" class="add-button">
                    + Tambah Tugas
                </a>

            </div>

        @else

            <div class="table-responsive">

                <table class="tasks-table">

                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Judul Tugas</th>
                            <th>Kelas</th>
                            <th>Batas Waktu</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach ($tasks as $task)

                            <tr>

                                <td>
                                    {{ $tasks->firstItem() + $loop->index }}
                                </td>

                                <td>
                                    <span class="task-title">
                                        {{ $task->title }}
                                    </span>
                                </td>

                                <td>
                                    <span class="class-badge">
                                        {{ $task->classroom->name }}
                                    </span>
                                </td>

                                <td>
                                    {{ $task->due_date->format('d-m-Y H:i') }}
                                </td>

                                <td>

                                    <div class="action-group">

                                        <a
                                            href="{{ route('teacher.tasks.edit', $task->id) }}"
                                            class="edit-button"
                                        >
                                            Edit
                                        </a>

                                        <form
                                            action="{{ route('teacher.tasks.destroy', $task->id) }}"
                                            method="POST"
                                            class="delete-form"
                                            onsubmit="return confirm('Yakin ingin menghapus tugas ini?')"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="delete-button">
                                                Hapus
                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

            {{-- Pagination --}}
            <div class="pagination-wrapper">
                {{ $tasks->links() }}
            </div>

        @endif

    </div>

    {{-- Back to Dashboard --}}
    <a href="{{ url('/teacher/dashboard') }}" class="back-link">
        ← Kembali ke Dashboard
    </a>

</div>

@endsection
