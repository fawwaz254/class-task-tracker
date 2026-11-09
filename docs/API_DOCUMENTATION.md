# Class Task Tracker API Documentation

## 1. Overview

Class Task Tracker menyediakan REST API untuk mengelola tugas kelas dengan dua jenis pengguna, yaitu Teacher dan Student.

**Base URL (local):**

`http://127.0.0.1:8000/api`

**Authentication:** Laravel Sanctum menggunakan Bearer Token.

**Format request dan response:** JSON.

Untuk endpoint yang membutuhkan autentikasi, sertakan header:

```http
Accept: application/json
Authorization: Bearer YOUR_ACCESS_TOKEN
Content-Type: application/json
```

## 2. Authentication

### Login

- **Method:** POST
- **Endpoint:** `/login`
- **Access:** Public

Request:

```json
{
    "email": "guru@example.com",
    "password": "password123"
}
```

Response sukses (200):

```json
{
    "success": true,
    "message": "Login berhasil.",
    "data": {
        "user": {
            "id": 1,
            "name": "Guru",
            "email": "guru@example.com",
            "role": "teacher"
        },
        "token": "ACCESS_TOKEN"
    }
}
```

### Logout

- **Method:** POST
- **Endpoint:** `/logout`
- **Access:** Authenticated

Menghapus token akses yang sedang digunakan.

## 3. Student Endpoints

Semua endpoint berikut membutuhkan autentikasi dengan role `student`.

### Get Student Tasks

- **Method:** GET
- **Endpoint:** `/student/tasks`

Menampilkan daftar tugas dari kelas yang diikuti siswa.

Query parameters (opsional):

| Parameter | Keterangan |
|---|---|
| `search` | Mencari tugas berdasarkan judul |
| `status` | Filter `pending` atau `completed` |
| `page` | Nomor halaman pagination |

Contoh:

`GET /student/tasks?search=Website&status=pending`

### Complete Task

- **Method:** POST
- **Endpoint:** `/student/tasks/{task}`

Endpoint lengkap:

`POST /student/tasks/{task}/complete`

Menandai tugas sebagai selesai. Siswa hanya dapat menyelesaikan tugas dari kelas yang diikutinya.

## 4. Teacher Endpoints

Semua endpoint berikut membutuhkan autentikasi dengan role `teacher`.

### Get Teacher Tasks

- **Method:** GET
- **Endpoint:** `/teacher/tasks`

Menampilkan daftar tugas pada kelas yang dimiliki guru.

### Create Task

- **Method:** POST
- **Endpoint:** `/teacher/tasks`

Request body:

```json
{
    "class_id": 1,
    "title": "Membuat Website Profil",
    "description": "Buat website profil sederhana.",
    "due_date": "2026-11-20 23:59:00"
}
```

### Update Task

- **Method:** PUT
- **Endpoint:** `/teacher/tasks/{task}`

Request body menggunakan format yang sama seperti Create Task.

### Delete Task

- **Method:** DELETE
- **Endpoint:** `/teacher/tasks/{task}`

Menghapus tugas beserta data penyelesaian terkait.

Guru hanya dapat mengelola tugas dari kelas miliknya sendiri.

## 5. HTTP Response Codes

| Status | Keterangan |
|---|---|
| 200 | Request berhasil |
| 201 | Data berhasil dibuat |
| 401 | Belum terautentikasi atau token tidak valid |
| 403 | Tidak memiliki hak akses |
| 404 | Data tidak ditemukan |
| 422 | Validasi request gagal |

## 6. Demo Accounts

Gunakan akun berikut untuk pengujian lokal:

| Role | Email | Password |
|---|---|---|
| Teacher | guru@example.com | password123 |
| Student | siswa1@example.com | password123 |
| Student | siswa2@example.com | password123 |

Akun demo tersedia setelah menjalankan database seeder.

## 7. Testing

Jalankan seluruh automated test dengan:

```bash
php artisan test
```

Pengujian mencakup:

- Authentication: login berhasil dan gagal.
- Student: melihat tugas, pembatasan akses, dan menyelesaikan tugas.
- Teacher: melihat, membuat, memperbarui, dan menghapus tugas.

Hasil pengujian terakhir: **11 tests passed (33 assertions)**.

