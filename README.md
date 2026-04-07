# Laporan Praktikum 4: Framework Lanjutan (Modul Login)

Repositori ini merupakan dokumentasi pengerjaan modul login menggunakan Framework CodeIgniter 4 untuk mata kuliah Pemrograman Web 2. Fokus utama praktikum ini adalah implementasi Autentikasi (Auth) dan Filter.

## 🎯 Tujuan Praktikum
* Memahami konsep dasar Auth dan Filter pada framework.
* Memahami alur kerja sistem login (Login System).
* Mampu mengimplementasikan modul login secara utuh menggunakan CodeIgniter 4.

---

## 🛠️ Langkah-Langkah Pengerjaan

### 1. Persiapan Database & Tabel
Tahap awal dimulai dengan menjalankan MySQL melalui XAMPP dan membuat tabel bernama `user` untuk menampung data akun.

**Struktur Tabel:**
* `id`: INT (11) - Primary Key & Auto Increment
* `username`: VARCHAR (200)
* `useremail`: VARCHAR (200)
* `userpassword`: VARCHAR (200)

### 2. Pembuatan Model (UserModel.php)
Membuat file model di direktori `app/Models`. Model ini berfungsi untuk menghubungkan aplikasi dengan tabel user di database serta mendefinisikan field mana saja yang boleh diisi (`$allowedFields`).

### 3. Logic Controller (User.php)
Menyusun logic di `app/Controllers/User.php` yang menangani beberapa fungsi utama:
* **Index**: Untuk melihat daftar user (jika diperlukan).
* **Login**: Proses pengecekan email dan verifikasi password menggunakan fungsi `password_verify`. Jika berhasil, data user disimpan ke dalam session.
* **Logout**: Menghancurkan session yang aktif dan mengalihkan user kembali ke halaman login.

### 4. Interface Login (View)
Membuat halaman login di `app/views/user/login.php` menggunakan HTML dan CSS. Halaman ini sudah dilengkapi dengan pesan peringatan (*flashdata*) jika user memasukkan email atau password yang salah.

> 
![Halaman Login][https://i.postimg.cc/9fy9cLRB/Screenshot-2026-04-07-181623.png]

### 5. Pengisian Data dengan Seeder
Agar bisa melakukan uji coba login, data admin dibuat melalui fitur Seeder CodeIgniter:
* Menjalankan perintah: `php spark make:seeder UserSeeder`
* Mengisi data (admin@email.com / admin123).
* Mengeksekusi seeder dengan: `php spark db:seed UserSeeder`

### 6. Implementasi Auth Filter
Untuk mengamankan halaman admin, dibuat sebuah Filter di `app/Filters/Auth.php`. Filter ini akan mengecek apakah user sudah memiliki session `logged_in`. Jika belum, akses akan ditolak dan diarahkan ke halaman login.

**Konfigurasi Rute:**
* Mendaftarkan filter di `app/Config/Filters.php`.
* Menerapkan filter pada grup rute admin di `app/Config/Routes.php`.

---

## 🚀 Hasil Uji Coba

1. **Proteksi Halaman**: Saat mencoba mengakses URL `/admin/artikel` tanpa login, sistem otomatis melempar user kembali ke form login.
2. **Validasi Login**: Sistem mampu membedakan password yang benar dan yang salah.
3. **Session Management**: Setelah login, user bisa mengakses fitur admin hingga tombol logout ditekan.

> 
![Admin Panel](https://i.postimg.cc/pLJ97pg6/Screenshot-2026-04-07-181901.png)

---
**Instansi:** Universitas Pelita Bangsa, Bekasi  
**Dosen Pengampu:** Agung Nugroho
