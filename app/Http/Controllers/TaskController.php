<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    // Menampilkan daftar tugas milik kelas yang diajar guru
    public function index(Request $request)
    {
        $tasks = Task::with('classroom')
            ->whereHas('classroom', function ($query) use ($request) {
                $query->where('teacher_id', $request->user()->id);
            })
            ->latest()
            ->paginate(10);

        return view('teacher.tasks.index', compact('tasks'));
    }

    // Menampilkan form tambah tugas
    public function create(Request $request)
    {
        $classes = Classroom::where('teacher_id', $request->user()->id)
            ->orderBy('name')
            ->get();

        return view('teacher.tasks.create', compact('classes'));
    }

    // Menyimpan tugas baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'class_id' => [
                'required',
                'integer',
                Rule::exists('classes', 'id')
                    ->where('teacher_id', $request->user()->id),
            ],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'due_date' => ['required', 'date'],
        ]);

        Task::create($validated);

        return redirect()
            ->route('teacher.tasks.index')
            ->with('success', 'Tugas berhasil ditambahkan.');
    }

    // Menampilkan form edit tugas
    public function edit(Request $request, Task $task)
    {
        $this->authorizeTask($request, $task);

        $classes = Classroom::where('teacher_id', $request->user()->id)
            ->orderBy('name')
            ->get();

        return view('teacher.tasks.edit', compact('task', 'classes'));
    }

    // Memperbarui tugas
    public function update(Request $request, Task $task)
    {
        $this->authorizeTask($request, $task);

        $validated = $request->validate([
            'class_id' => [
                'required',
                'integer',
                Rule::exists('classes', 'id')
                    ->where('teacher_id', $request->user()->id),
            ],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'due_date' => ['required', 'date'],
        ]);

        $task->update($validated);

        return redirect()
            ->route('teacher.tasks.index')
            ->with('success', 'Tugas berhasil diperbarui.');
    }

    // Menghapus tugas
    public function destroy(Request $request, Task $task)
    {
        $this->authorizeTask($request, $task);

        DB::transaction(function () use ($task) {
            // Hapus data penyelesaian siswa terlebih dahulu
            $task->completions()->delete();

            // Hapus tugas
            $task->delete();
        });

        return redirect()
            ->route('teacher.tasks.index')
            ->with('success', 'Tugas berhasil dihapus.');
    }

    // Memastikan guru hanya mengakses tugas dari kelas miliknya
    private function authorizeTask(Request $request, Task $task)
    {
        abort_unless(
            $task->classroom()
                ->where('teacher_id', $request->user()->id)
                ->exists(),
            403,
            'Anda tidak memiliki akses ke tugas ini.'
        );
    }
}