<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;


class TeacherTaskController extends Controller
{
    // Menampilkan tugas milik guru
    public function index(Request $request)
    {
        $tasks = Task::with('classroom')
            ->whereHas('classroom', function ($query) use ($request) {
                $query->where('teacher_id', $request->user()->id);
            })
            ->latest()
            ->paginate(10);

        return response()->json([
            'success' => true,
            'message' => 'Daftar tugas berhasil diambil.',
            'data' => $tasks->items(),
            'pagination' => [
                'current_page' => $tasks->currentPage(),
                'last_page' => $tasks->lastPage(),
                'total' => $tasks->total(),
            ],
        ]);
    }

    // Menambahkan tugas
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

        $task = Task::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Tugas berhasil ditambahkan.',
            'data' => $task->load('classroom'),
        ], 201);
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

        return response()->json([
            'success' => true,
            'message' => 'Tugas berhasil diperbarui.',
            'data' => $task->fresh()->load('classroom'),
        ]);
    }

    // Menghapus tugas
    public function destroy(Request $request, Task $task)
    {
        $this->authorizeTask($request, $task);

        $task->completions()->delete();
        $task->delete();

        return response()->json([
            'success' => true,
            'message' => 'Tugas berhasil dihapus.',
        ]);
    }

    // Memastikan tugas dimiliki guru yang sedang login
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
