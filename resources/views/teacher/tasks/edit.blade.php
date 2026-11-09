
@extends('layouts.app')

@section('title', 'Edit Tugas')

@section('content')

<style>
    .form-container {
        max-width: 850px;
        margin: 0 auto;
    }

    .page-header {
        margin-bottom: 23px;
    }

    .page-header h1 {
        color: #0f172a;
        font-size: 26px;
        margin-bottom: 7px;
    }

    .page-header p {
        color: #64748b;
        font-size: 14px;
        line-height: 1.6;
    }

    .form-card {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        overflow: hidden;
    }

    .form-card-header {
        padding: 20px 25px;
        border-bottom: 1px solid #e2e8f0;
        background: #f8fafc;
    }

    .form-card-header h2 {
        color: #0f172a;
        font-size: 16px;
        margin-bottom: 5px;
    }

    .form-card-header p {
        color: #64748b;
        font-size: 12px;
    }

    .form-body {
        padding: 25px;
    }

    .form-group {
        margin-bottom: 21px;
    }

    .form-group label {
        display: block;
        color: #334155;
        font-size: 13px;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .required {
        color: #dc2626;
    }

    .form-control {
        display: block;
        width: 100%;
        padding: 12px 13px;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        background: white;
        color: #334155;
        font-family: Arial, sans-serif;
        font-size: 13px;
        outline: none;
        transition: 0.2s;
    }

    .form-control:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .form-control::placeholder {
        color: #94a3b8;
    }

    textarea.form-control {
        resize: vertical;
        min-height: 120px;
        line-height: 1.6;
    }

    select.form-control {
        cursor: pointer;
    }

    .form-hint {
        display: block;
        margin-top: 7px;
        color: #94a3b8;
        font-size: 11px;
    }

    .error-box {
        padding: 14px 17px;
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fecaca;
        border-radius: 9px;
        margin-bottom: 22px;
        font-size: 13px;
    }

    .error-box strong {
        display: block;
        margin-bottom: 8px;
    }

    .error-box ul {
        padding-left: 20px;
        margin: 0;
        line-height: 1.7;
    }

    .form-actions {
        display: flex;
        align-items: center;
        gap: 10px;
        padding-top: 20px;
        border-top: 1px solid #f1f5f9;
        flex-wrap: wrap;
    }

    .submit-button {
        padding: 12px 19px;
        background: #2563eb;
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: 0.2s;
    }

    .submit-button:hover {
        background: #1d4ed8;
    }

    .cancel-button {
        display: inline-block;
        padding: 12px 18px;
        background: #f1f5f9;
        color: #475569;
        border-radius: 8px;
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
        transition: 0.2s;
    }

    .cancel-button:hover {
        background: #e2e8f0;
    }

    @media (max-width: 600px) {
        .page-header h1 {
            font-size: 23px;
        }

        .form-body {
            padding: 19px;
        }

        .form-card-header {
            padding: 18px 19px;
        }

        .form-actions {
            flex-direction: column;
            align-items: stretch;
        }

        .submit-button,
        .cancel-button {
            width: 100%;
            text-align: center;
        }
    }
</style>

<div class="form-container">

    {{-- Page Header --}}
    <div class="page-header">
        <h1>Edit Tugas</h1>
        <p>
            Perbarui informasi tugas yang sudah dibuat
            agar tetap sesuai dengan kebutuhan pembelajaran.
        </p>
    </div>

    <div class="form-card">

        <div class="form-card-header">
            <h2>Perbarui Informasi Tugas</h2>
            <p>Ubah informasi yang diperlukan melalui formulir berikut.</p>
        </div>

        <div class="form-body">

            {{-- Validation Errors --}}
            @if ($errors->any())
                <div class="error-box">
                    <strong>Terdapat kesalahan pada formulir:</strong>

                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Edit Task Form --}}
            <form action="{{ route('teacher.tasks.update', $task->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Task Title --}}
                <div class="form-group">
                    <label for="title">
                        Judul Tugas <span class="required">*</span>
                    </label>

                    <input
                        type="text"
                        id="title"
                        name="title"
                        class="form-control"
                        value="{{ old('title', $task->title) }}"
                        placeholder="Contoh: Membuat Website Profil"
                        required
                    >

                    <span class="form-hint">
                        Masukkan judul tugas yang jelas dan mudah dipahami siswa.
                    </span>
                </div>

                {{-- Task Description --}}
                <div class="form-group">
                    <label for="description">
                        Deskripsi Tugas
                    </label>

                    <textarea
                        id="description"
                        name="description"
                        class="form-control"
                        rows="5"
                        placeholder="Tuliskan instruksi atau detail tugas..."
                    >{{ old('description', $task->description) }}</textarea>

                    <span class="form-hint">
                        Perbarui instruksi atau penjelasan mengenai tugas.
                    </span>
                </div>

                {{-- Classroom --}}
                <div class="form-group">
                    <label for="class_id">
                        Kelas <span class="required">*</span>
                    </label>

                    <select
                        id="class_id"
                        name="class_id"
                        class="form-control"
                        required
                    >
                        @foreach ($classes as $class)
                            <option
                                value="{{ $class->id }}"
                                {{ old('class_id', $task->class_id) == $class->id ? 'selected' : '' }}
                            >
                                {{ $class->name }}
                            </option>
                        @endforeach
                    </select>

                    <span class="form-hint">
                        Pilih kelas yang akan menerima tugas ini.
                    </span>
                </div>

                {{-- Due Date --}}
                <div class="form-group">
                    <label for="due_date">
                        Batas Waktu Pengumpulan <span class="required">*</span>
                    </label>

                    <input
                        type="datetime-local"
                        id="due_date"
                        name="due_date"
                        class="form-control"
                        value="{{ old('due_date', $task->due_date->format('Y-m-d\TH:i')) }}"
                        required
                    >

                    <span class="form-hint">
                        Perbarui tanggal dan waktu terakhir pengumpulan tugas.
                    </span>
                </div>

                {{-- Form Actions --}}
                <div class="form-actions">

                    <button type="submit" class="submit-button">
                        Simpan Perubahan
                    </button>

                    <a
                        href="{{ route('teacher.tasks.index') }}"
                        class="cancel-button"
                    >
                        Batal
                    </a>

                </div>

            </form>

        </div>
    </div>

</div>

@endsection
