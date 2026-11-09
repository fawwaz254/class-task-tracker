<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Classroom;
use App\Models\Task;
use App\Models\TaskCompletion;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class ClassTaskTrackerSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Membuat akun guru
        $teacher = User::firstOrCreate(
            ['email' => 'guru@example.com'],
            [
                'name' => 'Guru Demo',
                'password' => Hash::make('password123'),
                'role' => 'teacher',
            ]
        );

        // 2. Membuat akun siswa
        $student1 = User::firstOrCreate(
            ['email' => 'siswa1@example.com'],
            [
                'name' => 'Siswa Pertama',
                'password' => Hash::make('password123'),
                'role' => 'student',
            ]
        );

        $student2 = User::firstOrCreate(
            ['email' => 'siswa2@example.com'],
            [
                'name' => 'Siswa Kedua',
                'password' => Hash::make('password123'),
                'role' => 'student',
            ]
        );

        // 3. Membuat kelas
        $classroom = Classroom::firstOrCreate(
            [
                'name' => 'Informatika 12A',
                'teacher_id' => $teacher->id,
            ]
        );

        // 4. Memasukkan siswa ke dalam kelas
        $classroom->students()->syncWithoutDetaching([
            $student1->id,
            $student2->id,
        ]);

        // 5. Membuat tugas
        $task1 = Task::firstOrCreate(
            [
                'class_id' => $classroom->id,
                'title' => 'Membuat Website Profil',
            ],
            [
                'description' => 'Buat website profil sederhana menggunakan HTML dan CSS.',
                'due_date' => Carbon::now()->addDays(7),
            ]
        );

        Task::firstOrCreate(
            [
                'class_id' => $classroom->id,
                'title' => 'Belajar Dasar PHP',
            ],
            [
                'description' => 'Pelajari variabel, percabangan, dan perulangan PHP.',
                'due_date' => Carbon::now()->addDays(10),
            ]
        );

        // 6. Contoh penyelesaian tugas oleh siswa pertama
        TaskCompletion::firstOrCreate(
            [
                'task_id' => $task1->id,
                'student_id' => $student1->id,
            ],
            [
                'completed_at' => Carbon::now(),
            ]
        );
    }
}