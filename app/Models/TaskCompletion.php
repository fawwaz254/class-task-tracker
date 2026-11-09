<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskCompletion extends Model
{
    protected $fillable = [
        'task_id',
        'student_id',
        'completed_at',
    ];

    protected function casts(): array
    {
        return [
            'completed_at' => 'datetime',
        ];
    }

    // Tugas yang diselesaikan
    public function task()
    {
        return $this->belongsTo(Task::class, 'task_id');
    }

    // Siswa yang menyelesaikan tugas
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}