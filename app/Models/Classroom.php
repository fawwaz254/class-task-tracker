<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    protected $table = 'classes';

    protected $fillable = [
        'name',
        'teacher_id',
    ];

    // Guru pemilik kelas
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    // Siswa yang mengikuti kelas
    public function students()
    {
        return $this->belongsToMany(User::class, 'class_user');
    }

    // Daftar tugas dalam kelas
    public function tasks()
    {
        return $this->hasMany(Task::class, 'class_id');
    }
}