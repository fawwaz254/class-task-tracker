<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:255'],
            'status' => ['nullable', 'in:pending,completed'],
        ]);

        $studentId = $request->user()->id;

        $query = Task::with('classroom')
            ->with(['completions' => function ($query) use ($studentId) {
                $query->where('student_id', $studentId);
            }])
            ->whereHas('classroom.students', function ($query) use ($studentId) {
                $query->where('users.id', $studentId);
            });

        if (!empty($validated['search'])) {
            $query->where('title', 'like', '%' . $validated['search'] . '%');
        }

        if (($validated['status'] ?? null) === 'completed') {
            $query->whereHas('completions', function ($query) use ($studentId) {
                $query->where('student_id', $studentId)
                    ->whereNotNull('completed_at');
            });
        } elseif (($validated['status'] ?? null) === 'pending') {
            $query->whereDoesntHave('completions', function ($query) use ($studentId) {
                $query->where('student_id', $studentId)
                    ->whereNotNull('completed_at');
            });
        }

        $tasks = $query->latest()->paginate(10);

        $data = $tasks->getCollection()->map(function ($task) {
            $completion = $task->completions->first();

            return [
                'id' => $task->id,
                'title' => $task->title,
                'description' => $task->description,
                'class' => $task->classroom->name,
                'due_date' => $task->due_date,
                'status' => $completion && $completion->completed_at
                    ? 'completed'
                    : 'pending',
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'Daftar tugas berhasil diambil.',
            'data' => $data,
            'pagination' => [
                'current_page' => $tasks->currentPage(),
                'last_page' => $tasks->lastPage(),
                'per_page' => $tasks->perPage(),
                'total' => $tasks->total(),
            ],
        ]);
    }

    public function complete(Request $request, Task $task)
    {
        $studentId = $request->user()->id;

        $isEnrolled = $task->classroom()
            ->whereHas('students', function ($query) use ($studentId) {
                $query->where('users.id', $studentId);
            })
            ->exists();

        if (!$isEnrolled) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki akses ke tugas ini.',
            ], 403);
        }

        $task->completions()->updateOrCreate(
            ['student_id' => $studentId],
            ['completed_at' => now()]
        );

        return response()->json([
            'success' => true,
            'message' => 'Tugas berhasil ditandai selesai.',
            'data' => [
                'task_id' => $task->id,
                'status' => 'completed',
            ],
        ]);
    }
}
