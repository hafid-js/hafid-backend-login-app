# Backend API - Sistem Login (Laravel)

Backend API sederhana untuk sistem autentikasi (login & logout) menggunakan Laravel.
Autentikasi menggunakan JWT yang disimpan dalam HttpOnly Cookie.

---

## Tech Stack

* Laravel
* MySQL
* JWT Authentication
* Bcrypt (hash password)
* Rate Limit

---

## Requirement

Sebelum menjalankan project, pastikan sudah terinstall:

- PHP versi 8 atau lebih baru
- Composer
- MySQL

## Cara Menjalankan

```bash
git clone https://github.com/hafid-js/hafid-backend-login-app.git
cd hafid-backend-login-app
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

Akses di:
http://127.0.0.1:8000 atau http://localhost:8000

---

## Endpoint

* POST /api/login
* POST /api/register
* GET /api/me (protected)
* POST /api/logout

---

## Sistem Autentikasi

* Login akan menghasilkan JWT
* Token disimpan dalam HttpOnly Cookie
* Setiap request akan otomatis membawa cookie
* Endpoint `/api/me` hanya bisa diakses jika token valid
* Logout akan menghapus token

---

## Arsitektur Singkat

* Controller menangani request login, logout, dan user
* Middleware digunakan untuk proteksi endpoint
* JWT digunakan sebagai mekanisme autentikasi
* Database MySQL untuk menyimpan data user

Alur:

1. User login → validasi → generate JWT
2. JWT disimpan di cookie
3. Request berikutnya diverifikasi oleh middleware
4. Jika valid → akses diberikan

---

## Keamanan

* Password di-hash menggunakan bcrypt
* JWT disimpan dalam HttpOnly Cookie
* Endpoint dilindungi middleware auth
* Rate limit login untuk mencegah brute force (limit 5x percobaan login per 1 menit tiap IP)

---

## Unit Test

Unit test sederhana dibuat untuk memastikan:

* Validasi input login berjalan dengan benar
* Login berhasil dengan kredensial yang valid
* Login gagal dengan kredensial yang salah

Jalankan test:

```bash
php artisan test
```

---

## Akun Dummy

Gunakan akun berikut untuk login:

* Email: test@example.com
* Password: Password123

---

## Catatan

* Pastikan database MySQL sudah berjalan
* sistem autentikasi menggunakan Laravel + JWT
* Aplikasi menggunakan HttpOnly Cookie, sehingga testing harus menggunakan frontend atau Postman dengan cookie aktif.
