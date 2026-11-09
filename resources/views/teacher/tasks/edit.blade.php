@extends('layouts.app')

@section('title', 'Edit Tugas')

@section('content')

<div class="card">

    <h1>Edit Tugas</h1>
    <p>Perbarui informasi tugas yang sudah dibuat.</p>

    <hr>

    @if ($errors->any())
        <div style="background: #fee2e2; color: #991b1b; padding: 12px; border-radius: 6px; margin-bottom: 15px;">
            <strong>Terdapat kesalahan:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('teacher.tasks.update', $task->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div style="margin-bottom: 18px;">
            <label for="title"><strong>Judul Tugas</strong></label>
            <input
                type="text"
                id="title"
                name="title"
                value="{{ old('title', $task->title) }}"
                required
                style="display: block; width: 100%; padding: 10px; margin-top: 6px; border: 1px solid #d1d5db; border-radius: 6px;"
            >
        </div>

        <div style="margin-bottom: 18px;">
            <label for="description"><strong>Deskripsi Tugas</strong></label>
            <textarea
                id="description"
                name="description"
                rows="5"
                style="display: block; width: 100%; padding: 10px; margin-top: 6px; border: 1px solid #d1d5db; border-radius: 6px;"
            >{{ old('description', $task->description) }}</textarea>
        </div>

        <div style="margin-bottom: 18px;">
            <label for="class_id"><strong>Kelas</strong></label>
            <select
                id="class_id"
                name="class_id"
                required
                style="display: block; width: 100%; padding: 10px; margin-top: 6px; border: 1px solid #d1d5db; border-radius: 6px;"
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
        </div>

        <div style="margin-bottom: 18px;">
            <label for="due_date"><strong>Batas Waktu Pengumpulan</strong></label>
            <input
                type="datetime-local"
                id="due_date"
                name="due_date"
                value="{{ old('due_date', $task->due_date->format('Y-m-d\TH:i')) }}"
                required
                style="display: block; width: 100%; padding: 10px; margin-top: 6px; border: 1px solid #d1d5db; border-radius: 6px;"
            >
        </div>

        <button
            type="submit"
            style="background: #2563eb; color: white; border: none; padding: 10px 18px; border-radius: 6px; cursor: pointer;"
        >
            Simpan Perubahan
        </button>

        <a
            href="{{ route('teacher.tasks.index') }}"
            style="margin-left: 10px; color: #475569; text-decoration: none;"
        >
            Batal
        </a>

    </form>

</div>

@endsection