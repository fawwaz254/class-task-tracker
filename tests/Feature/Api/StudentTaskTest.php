<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Classroom;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class StudentTaskTest extends TestCase
{
    use RefreshDatabase;

    private function createStudentWithTask(): array
    {
        $teacher = User::create([
            'name' => 'Guru Testing',
            'email' => 'guru@test.com',
            'password' => bcrypt('password123'),
            'role' => 'teacher',
        ]);

        $student = User::create([
            'name' => 'Siswa Testing',
            'email' => 'siswa@test.com',
            'password' => bcrypt('password123'),
            'role' => 'student',
        ]);

        $classroom = Classroom::create([
            'name' => 'Informatika Testing',
            'teacher_id' => $teacher->id,
        ]);

        $classroom->students()->attach($student->id);

        $task = Task::create([
            'class_id' => $classroom->id,
            'title' => 'Tugas Testing API',
            'description' => 'Deskripsi tugas pengujian',
            'due_date' => now()->addDays(7),
        ]);

        return [$student, $task];
    }

    public function test_student_can_view_their_tasks(): void
    {
        [$student, $task] = $this->createStudentWithTask();

        Sanctum::actingAs($student);

        $response = $this->getJson('/api/student/tasks');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
            ])
            ->assertJsonFragment([
                'title' => 'Tugas Testing API',
            ]);
    }

    public function test_student_cannot_access_teacher_tasks(): void
    {
        [$student] = $this->createStudentWithTask();

        Sanctum::actingAs($student);

        $response = $this->getJson('/api/teacher/tasks');

        $response->assertStatus(403);
    }

    public function test_student_can_complete_task(): void
    {
        [$student, $task] = $this->createStudentWithTask();

        Sanctum::actingAs($student);

        $response = $this->postJson(
            "/api/student/tasks/{$task->id}/complete"
        );

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
            ]);

        $this->assertDatabaseHas('task_completions', [
            'task_id' => $task->id,
            'student_id' => $student->id,
        ]);
    }
}