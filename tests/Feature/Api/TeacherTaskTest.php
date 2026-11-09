<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Classroom;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class TeacherTaskTest extends TestCase
{
    use RefreshDatabase;

    private function createTeacherWithClass(): array
    {
        $teacher = User::create([
            'name' => 'Guru Testing',
            'email' => 'guru@test.com',
            'password' => bcrypt('password123'),
            'role' => 'teacher',
        ]);

        $classroom = Classroom::create([
            'name' => 'Informatika Testing',
            'teacher_id' => $teacher->id,
        ]);

        Sanctum::actingAs($teacher);

        return [$teacher, $classroom];
    }

    private function createTask(Classroom $classroom): Task
    {
        return Task::create([
            'class_id' => $classroom->id,
            'title' => 'Tugas Lama',
            'description' => 'Deskripsi tugas lama',
            'due_date' => now()->addDays(7),
        ]);
    }

    public function test_teacher_can_view_their_tasks(): void
    {
        [, $classroom] = $this->createTeacherWithClass();

        $this->createTask($classroom);

        $response = $this->getJson('/api/teacher/tasks');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
            ])
            ->assertJsonFragment([
                'title' => 'Tugas Lama',
            ]);
    }

    public function test_teacher_can_create_task(): void
    {
        [, $classroom] = $this->createTeacherWithClass();

        $response = $this->postJson('/api/teacher/tasks', [
            'class_id' => $classroom->id,
            'title' => 'Tugas Baru',
            'description' => 'Tugas dibuat melalui automated test',
            'due_date' => now()->addDays(7)->format('Y-m-d H:i:s'),
        ]);

        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'message' => 'Tugas berhasil ditambahkan.',
            ]);

        $this->assertDatabaseHas('tasks', [
            'title' => 'Tugas Baru',
            'class_id' => $classroom->id,
        ]);
    }

    public function test_teacher_can_update_task(): void
    {
        [, $classroom] = $this->createTeacherWithClass();

        $task = $this->createTask($classroom);

        $response = $this->putJson("/api/teacher/tasks/{$task->id}", [
            'class_id' => $classroom->id,
            'title' => 'Tugas Diperbarui',
            'description' => 'Deskripsi yang sudah diperbarui',
            'due_date' => now()->addDays(10)->format('Y-m-d H:i:s'),
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Tugas berhasil diperbarui.',
            ]);

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'title' => 'Tugas Diperbarui',
        ]);
    }

    public function test_teacher_can_delete_task(): void
    {
        [, $classroom] = $this->createTeacherWithClass();

        $task = $this->createTask($classroom);

        $response = $this->deleteJson("/api/teacher/tasks/{$task->id}");

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Tugas berhasil dihapus.',
            ]);

        $this->assertDatabaseMissing('tasks', [
            'id' => $task->id,
        ]);
    }
}