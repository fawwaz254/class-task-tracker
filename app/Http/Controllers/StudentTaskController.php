<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class StudentTaskController extends Controller
{
    public function index(Request $request)
    {
        $studentId = $request->user()->id;

        $query = Task::with('classroom')
            ->with(['completions' => function ($query) use ($studentId) {
                $query->where('student_id', $studentId);
            }])
            ->whereHas('classroom.students', function ($query) use ($studentId) {
                $query->where('users.id', $studentId);
            });

        // Pencarian berdasarkan judul tugas
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Filter status tugas
        if ($request->status === 'completed') {
            $query->whereHas('completions', function ($query) use ($studentId) {
                $query->where('student_id', $studentId)
                    ->whereNotNull('completed_at');
            });
        } elseif ($request->status === 'pending') {
            $query->whereDoesntHave('completions', function ($query) use ($studentId) {
                $query->where('student_id', $studentId)
                    ->whereNotNull('completed_at');
            });
        }

        $tasks = $query->latest()->paginate(10)->withQueryString();

        return view('student.tasks.index', compact('tasks'));
    }

    public function complete(Request $request, Task $task)
    {
        $studentId = $request->user()->id;

        // Pastikan siswa terdaftar di kelas yang memiliki tugas ini
        $isEnrolled = $task->classroom()
            ->whereHas('students', function ($query) use ($studentId) {
                $query->where('users.id', $studentId);
            })
            ->exists();

        abort_unless($isEnrolled, 403, 'Anda tidak memiliki akses ke tugas ini.');

        // Tandai tugas sebagai selesai
        $task->completions()->updateOrCreate(
            ['student_id' => $studentId],
            ['completed_at' => now()]
        );

        return redirect()
            ->route('student.tasks.index')
            ->with('success', 'Tugas berhasil ditandai selesai.');
    }
}