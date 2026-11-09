
@extends('layouts.app')

@section('title', 'Daftar Tugas Siswa')

@section('content')

<style>
    .tasks-container {
        max-width: 1200px;
        margin: 0 auto;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        margin-bottom: 25px;
        flex-wrap: wrap;
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

    .back-button {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 10px 15px;
        border: 1px solid #e2e8f0;
        border-radius: 9px;
        color: #475569;
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
        background: white;
        transition: 0.2s;
    }

    .back-button:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
    }

    .alert {
        padding: 13px 16px;
        border-radius: 9px;
        margin-bottom: 18px;
        font-size: 14px;
    }

    .alert-success {
        background: #dcfce7;
        color: #166534;
        border: 1px solid #bbf7d0;
    }

    .alert-error {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }

    .filter-card {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 13px;
        padding: 20px;
        margin-bottom: 22px;
    }

    .filter-card h3 {
        font-size: 15px;
        color: #0f172a;
        margin-bottom: 14px;
    }

    .filter-form {
        display: grid;
        grid-template-columns: minmax(180px, 1fr) minmax(160px, 220px) auto auto;
        gap: 10px;
        align-items: center;
    }

    .filter-form input,
    .filter-form select {
        width: 100%;
        padding: 11px 12px;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        background: white;
        color: #334155;
        font-size: 13px;
        outline: none;
    }

    .filter-form input:focus,
    .filter-form select:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .search-button {
        padding: 11px 17px;
        background: #2563eb;
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: 0.2s;
    }

    .search-button:hover {
        background: #1d4ed8;
    }

    .reset-button {
        padding: 11px 15px;
        color: #475569;
        background: #f1f5f9;
        border-radius: 8px;
        text-decoration: none;
        text-align: center;
        font-size: 13px;
        font-weight: 600;
    }

    .reset-button:hover {
        background: #e2e8f0;
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
        font-size: 16px;
        color: #0f172a;
        margin-bottom: 5px;
    }

    .table-heading p {
        font-size: 12px;
        color: #64748b;
    }

    .table-responsive {
        width: 100%;
        overflow-x: auto;
    }

    .tasks-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 850px;
    }

    .tasks-table th {
        padding: 14px 15px;
        text-align: left;
        background: #f8fafc;
        color: #475569;
        font-size: 12px;
        font-weight: 700;
        white-space: nowrap;
    }

    .tasks-table td {
        padding: 15px;
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

    .task-description {
        max-width: 220px;
        line-height: 1.5;
    }

    .status-badge {
        display: inline-block;
        padding: 6px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        white-space: nowrap;
    }

    .status-completed {
        background: #dcfce7;
        color: #15803d;
    }

    .status-pending {
        background: #fef3c7;
        color: #b45309;
    }

    .complete-button {
        padding: 9px 12px;
        border: none;
        border-radius: 7px;
        background: #2563eb;
        color: white;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        white-space: nowrap;
        transition: 0.2s;
    }

    .complete-button:hover {
        background: #1d4ed8;
    }

    .completed-text {
        color: #15803d;
        font-size: 12px;
        font-weight: 600;
        white-space: nowrap;
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
    }

    .pagination-wrapper {
        padding: 18px 20px;
        border-top: 1px solid #e2e8f0;
    }

    @media (max-width: 750px) {
        .filter-form {
            grid-template-columns: 1fr 1fr;
        }

        .filter-form input {
            grid-column: 1 / -1;
        }

        .page-header h1 {
            font-size: 23px;
        }
    }

    @media (max-width: 480px) {
        .filter-form {
            grid-template-columns: 1fr;
        }

        .filter-form input {
            grid-column: auto;
        }

        .search-button,
        .reset-button {
            width: 100%;
        }

        .filter-card {
            padding: 16px;
        }
    }
</style>

<div class="tasks-container">

    {{-- Page Header --}}
    <div class="page-header">
        <div>
            <h1>Daftar Tugas</h1>
            <p>Kelola dan pantau penyelesaian tugas dari kelas yang kamu ikuti.</p>
        </div>

        <a href="{{ url('/student/dashboard') }}" class="back-button">
            ← Kembali ke Dashboard
        </a>
    </div>

    {{-- Success Message --}}
    @if (session('success'))
        <div class="alert alert-success">
            ✓ {{ session('success') }}
        </div>
    @endif

    {{-- Error Message --}}
    @if ($errors->any())
        <div class="alert alert-error">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    {{-- Search and Filter --}}
    <div class="filter-card">
        <h3>Cari dan Filter Tugas</h3>

        <form method="GET" action="{{ route('student.tasks.index') }}" class="filter-form">

            <input
                type="text"
                name="search"
                placeholder="Cari berdasarkan judul tugas..."
                value="{{ request('search') }}"
            >

            <select name="status">
                <option value="">Semua Status</option>

                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>
                    Belum Selesai
                </option>

                <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>
                    Selesai
                </option>
            </select>

            <button type="submit" class="search-button">
                Cari / Filter
            </button>

            <a href="{{ route('student.tasks.index') }}" class="reset-button">
                Reset
            </a>

        </form>
    </div>

    {{-- Task List --}}
    <div class="table-card">

        <div class="table-heading">
            <h2>Daftar Tugas Saya</h2>
            <p>Tugas yang diberikan oleh guru kepada kelasmu.</p>
        </div>

        @if ($tasks->isEmpty())

            <div class="empty-state">
                <div class="empty-icon">📋</div>
                <h3>Belum Ada Tugas</h3>
                <p>Belum ada tugas yang ditemukan. Coba ubah pencarian atau filter status.</p>
            </div>

        @else

            <div class="table-responsive">
                <table class="tasks-table">

                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Judul Tugas</th>
                            <th>Kelas</th>
                            <th>Deskripsi</th>
                            <th>Batas Waktu</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($tasks as $index => $task)

                            @php
                                $completion = $task->completions->first();
                                $isCompleted = $completion && $completion->completed_at;
                            @endphp

                            <tr>
                                <td>{{ $tasks->firstItem() + $index }}</td>

                                <td>
                                    <span class="task-title">
                                        {{ $task->title }}
                                    </span>
                                </td>

                                <td>{{ $task->classroom->name }}</td>

                                <td>
                                    <div class="task-description">
                                        {{ $task->description ?? '-' }}
                                    </div>
                                </td>

                                <td>
                                    {{ $task->due_date->format('d-m-Y H:i') }}
                                </td>

                                <td>
                                    @if ($isCompleted)
                                        <span class="status-badge status-completed">
                                            ✓ Selesai
                                        </span>
                                    @else
                                        <span class="status-badge status-pending">
                                            Belum Selesai
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    @if (!$isCompleted)

                                        <form
                                            method="POST"
                                            action="{{ route('student.tasks.complete', $task->id) }}"
                                            onsubmit="return confirm('Tandai tugas ini sebagai selesai?')"
                                        >
                                            @csrf

                                            <button type="submit" class="complete-button">
                                                Tandai Selesai
                                            </button>
                                        </form>

                                    @else

                                        <span class="completed-text">
                                            ✓ Sudah Dikumpulkan
                                        </span>

                                    @endif
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

</div>

@endsection
