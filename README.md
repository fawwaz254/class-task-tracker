# Class Task Tracker

Aplikasi web sederhana untuk mengelola tugas kelas antara guru (*Teacher*) dan siswa (*Student*). Dibangun menggunakan Laravel 12, Blade, MySQL, dan Laravel Sanctum.

## 1. Fitur Utama

### Authentication
- Registrasi dan login pengguna.
- Dua jenis role: Teacher dan Student.
- Password disimpan menggunakan hashing.
- Autentikasi web menggunakan session.
- Autentikasi REST API menggunakan Laravel Sanctum.

### Teacher
- Melihat daftar tugas dari kelas yang dimiliki.
- Membuat tugas baru.
- Memperbarui tugas.
- Menghapus tugas.
- Mengelola tugas berdasarkan kepemilikan kelas.

### Student
- Melihat tugas dari kelas yang diikuti.
- Mencari tugas berdasarkan judul.
- Memfilter tugas berdasarkan status pending atau completed.
- Menandai tugas sebagai selesai.

### REST API
- Endpoint untuk autentikasi.
- Endpoint pengelolaan tugas guru.
- Endpoint daftar dan penyelesaian tugas siswa.
- Validasi input dan pembatasan akses berdasarkan role.

## 2. Teknologi

| Teknologi | Penggunaan |
|---|---|
| PHP 8.2+ | Backend |
| Laravel 12 | Framework |
| Blade | Frontend |
| MySQL | Database |
| Laravel Sanctum | API Authentication |
| PHPUnit | Automated Testing |

## 3. Persyaratan Sistem

Pastikan perangkat telah memiliki:
- PHP 8.2 atau lebih baru.
- Composer.
- MySQL.
- Git.

## 4. Instalasi dan Menjalankan Proyek

### 1. Clone repository

```bash
git clone https://github.com/USERNAME/class-task-tracker.git
cd class-task-tracker
```

Ganti URL tersebut dengan URL repository proyek yang sebenarnya.

### 2. Install dependency

```bash
composer install
```

### 3. Konfigurasi environment

Salin `.env.example` menjadi `.env`.

Windows PowerShell:

```powershell
Copy-Item .env.example .env
```

Atur koneksi database di `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=class_task_tracker
DB_USERNAME=root
DB_PASSWORD=
```

Sesuaikan username dan password MySQL dengan konfigurasi lokal.

### 4. Generate application key

```bash
php artisan key:generate
```

### 5. Buat database

Buat database MySQL dengan nama:

```sql
CREATE DATABASE class_task_tracker;
```

### 6. Jalankan migration dan seeder

```bash
php artisan migrate --seed
```

Perintah tersebut membuat tabel dan mengisi data demo.

### 7. Jalankan aplikasi

```bash
php artisan serve
```

Buka aplikasi melalui:

`http://127.0.0.1:8000`

## 5. Demo Accounts

Gunakan akun berikut untuk mencoba aplikasi:

| Role | Email | Password |
|---|---|---|
| Teacher | guru@example.com | password123 |
| Student | siswa1@example.com | password123 |
| Student | siswa2@example.com | password123 |

## 6. REST API Documentation

Dokumentasi lengkap request dan response tersedia di:

`docs/API_DOCUMENTATION.md`

Base URL:

`http://127.0.0.1:8000/api`

### Endpoint

| Method | Endpoint | Access |
|---|---|---|
| POST | `/api/login` | Public |
| POST | `/api/logout` | Authenticated |
| GET | `/api/student/tasks` | Student |
| POST | `/api/student/tasks/{task}/complete` | Student |
| GET | `/api/teacher/tasks` | Teacher |
| POST | `/api/teacher/tasks` | Teacher |
| PUT | `/api/teacher/tasks/{task}` | Teacher |
| DELETE | `/api/teacher/tasks/{task}` | Teacher |

Endpoint yang membutuhkan autentikasi menggunakan Bearer Token dari Laravel Sanctum.

## 7. Database Design

Aplikasi menggunakan beberapa tabel utama:

| Tabel | Fungsi |
|---|---|
| users | Menyimpan akun dan role pengguna |
| classes | Menyimpan data kelas dan guru pemilik |
| class_user | Relasi siswa dengan kelas |
| tasks | Menyimpan tugas kelas |
| task_completions | Menyimpan status penyelesaian tugas siswa |
| personal_access_tokens | Menyimpan token API Sanctum |

Relasi utama:
- Satu guru dapat memiliki beberapa kelas.
- Satu kelas dapat diikuti beberapa siswa.
- Satu kelas dapat memiliki beberapa tugas.
- Satu tugas dapat memiliki catatan penyelesaian dari beberapa siswa.

## 8. Automated Testing

Jalankan pengujian menggunakan:

```bash
php artisan test
```

Pengujian mencakup:
- Login dengan kredensial valid dan tidak valid.
- Siswa melihat daftar tugas.
- Pembatasan akses siswa terhadap endpoint guru.
- Siswa menyelesaikan tugas.
- Guru melihat daftar tugas.
- Guru membuat, memperbarui, dan menghapus tugas.

**Hasil pengujian terakhir: 11 tests passed (33 assertions).**

### Database Testing

Pengujian menggunakan database MySQL terpisah bernama `class_task_tracker_testing` agar tidak mengubah data database utama.

Pastikan database testing tersebut dibuat sebelum menjalankan automated test.

## 9. Security and Authorization

- Password pengguna disimpan menggunakan hashing.
- Endpoint API dilindungi Laravel Sanctum.
- Middleware role membatasi akses Teacher dan Student.
- Guru hanya dapat mengelola tugas dari kelas miliknya.
- Siswa hanya dapat melihat dan menyelesaikan tugas dari kelas yang diikutinya.
- Validasi diterapkan pada input pengguna.

## 10. Development Notes

### AI Assistance Disclosure

During the development of Class Task Tracker, AI tools were used as development assistants to help with several technical aspects:

- **Database Design & Eloquent Relationships:** Assistance in understanding and implementing database relationships, including many-to-many relationships between students and classes, as well as task completion relationships.
- **Authentication & Authorization:** Assistance with implementing session-based authentication, Laravel Sanctum API authentication, and role-based middleware.
- **REST API Development:** Assistance in structuring API endpoints, implementing CRUD operations, request validation, and JSON responses.
- **Automated Testing:** Assistance in preparing PHPUnit Feature Tests, including API testing scenarios, database assertions, and authentication testing.
- **Debugging & Troubleshooting:** Assistance in identifying and resolving errors related to migrations, database configuration, API requests, and automated testing.
- **Project Documentation:** Assistance in preparing `README.md` and `docs/API_DOCUMENTATION.md`.

### Developer Contributions

The developer was responsible for:

- Integrating and adapting the suggested implementations to the project requirements.
- Reviewing and understanding the code before applying changes.
- Running the application and testing its functionality.
- Performing manual API testing using Postman.
- Running automated tests and reviewing the results.
- Adjusting the implementation based on testing results and project requirements.


AI Tools digunakan sebagai alat bantu untuk diskusi teknis, penjelasan konsep, dan panduan selama pengembangan. Implementasi, penyesuaian kode, serta pengujian dilakukan dan diperiksa oleh pengembang.

## 11. Future Improvements

Beberapa pengembangan yang dapat dilakukan selanjutnya:
- Pengelolaan kelas melalui dashboard guru.
- Notifikasi tenggat waktu tugas.
- Peningkatan tampilan responsif untuk perangkat mobile.
- Dokumentasi API menggunakan Swagger atau OpenAPI.
- Penambahan automated test untuk validasi dan skenario otorisasi lainnya.
