<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'class_id',
        'title',
        'description',
        'due_date',
    ];

    protected function casts(): array
    {
        return [
            'due_date' => 'datetime',
        ];
    }

    // Kelas tempat tugas diberikan
    public function classroom()
    {
        return $this->belongsTo(Classroom::class, 'class_id');
    }

    // Daftar penyelesaian tugas oleh siswa
    public function completions()
    {
        return $this->hasMany(TaskCompletion::class, 'task_id');
    }
}