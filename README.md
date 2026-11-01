# 📚 Pustaka Digital — Sistem Informasi Perpustakaan

Sistem Informasi Manajemen Perpustakaan berbasis web yang dibangun menggunakan **Laravel 12**, **Tailwind CSS**, dan **MySQL/SQLite**. Proyek ini dirancang untuk mempermudah pengelolaan koleksi buku, anggota perpustakaan, serta transaksi peminjaman dan pengembalian secara otomatis.

## ✨ Fitur Utama

- 🌐 **Landing Page Publik** — Halaman depan modern untuk melihat katalog buku.
- 👁️ **Mode Demo Interaktif** — Pengunjung dapat mencoba fitur admin dalam mode Read-Only tanpa mengubah atau merusak data.
- 🔐 **Autentikasi Admin** — Sistem login untuk mengelola aplikasi dengan kredensial yang dikonfigurasi melalui `.env`.
- 📚 **Manajemen Buku** — Mengelola data buku dengan fitur tambah, lihat, edit, hapus (CRUD), upload cover, sinopsis, dan pengelolaan stok otomatis.
- 👥 **Manajemen Anggota** — Mengelola data mahasiswa atau anggota perpustakaan.
- 🔄 **Peminjaman & Pengembalian** — Mengelola transaksi peminjaman dan pengembalian dengan pembaruan stok buku secara otomatis.
- 💰 **Sistem Denda** — Menghitung denda keterlambatan pengembalian secara otomatis sebesar Rp1.000 per hari.
- 📄 **Laporan PDF** — Mencetak riwayat peminjaman dengan filter dinamis.
- 📊 **Dashboard Statistik** — Menampilkan grafik tren peminjaman selama 7 hari terakhir.

## 🛠️ Teknologi yang Digunakan

| Kategori | Teknologi |
|---|---|
| Framework Backend | Laravel 12 |
| Frontend | Tailwind CSS (CDN) |
| Icons | Font Awesome |
| Alert & Notification | SweetAlert2 |
| Database | MySQL / SQLite |
| PDF Generator | barryvdh/laravel-dompdf |
| Data Visualization | Chart.js |

## 🚀 Cara Menjalankan di Lokal

Ikuti langkah-langkah berikut untuk menjalankan aplikasi pada komputer Anda.

### Prasyarat

Pastikan perangkat telah memiliki:

- PHP yang kompatibel dengan Laravel 12.
- Composer.
- MySQL atau SQLite.
- XAMPP atau Laragon (jika menggunakan MySQL).
- Browser seperti Google Chrome atau Mozilla Firefox.

### Langkah Instalasi

**1. Clone Repository**

Buka terminal atau PowerShell, kemudian jalankan:

```bash
git clone https://github.com/yarhns/perpustakaan-digital-laravel.git
cd perpustakaan-digital-laravel
```

**2. Install Dependensi**

Jalankan perintah berikut untuk menginstal dependensi Laravel:

```bash
composer install
```

**3. Salin File Environment dan Generate Application Key**

Untuk Windows Command Prompt:

```cmd
copy .env.example .env
php artisan key:generate
```

Jika menggunakan PowerShell:

```powershell
Copy-Item .env.example .env
php artisan key:generate
```

**4. Konfigurasi Database**

Buka file `.env`, kemudian sesuaikan konfigurasi database yang ingin digunakan.

Contoh konfigurasi MySQL:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pustaka_digital
DB_USERNAME=root
DB_PASSWORD=
```

Buat database baru bernama `pustaka_digital` melalui phpMyAdmin.

Jika ingin menggunakan SQLite, sesuaikan konfigurasi database dengan pengaturan SQLite pada proyek.

**5. Jalankan Migrasi dan Seeder**

Untuk membuat tabel database sekaligus mengisi data dummy, jalankan:

```bash
php artisan migrate --seed
```

**6. Buat Storage Symlink**

Jalankan perintah berikut agar gambar cover buku yang tersimpan pada storage dapat diakses oleh aplikasi:

```bash
php artisan storage:link
```

**7. Jalankan Server Laravel**

```bash
php artisan serve
```

**8. Buka Aplikasi**

Buka browser dan akses alamat:

```text
http://127.0.0.1:8000
```

Aplikasi Pustaka Digital siap digunakan.

## 🔑 Akun Demo

Berikut informasi akun untuk mencoba aplikasi:

### Admin Login

| Informasi | Detail |
|---|---|
| Email | `admin@pustaka.com` |
| Password | `password123` |
| Hak Akses | Admin |

### Mode Demo (Read-Only)

Pengunjung tidak perlu melakukan login.

Cukup klik tombol **"Coba Demo"** pada halaman depan untuk mencoba aplikasi dalam mode Read-Only.

> **Catatan Keamanan:** Kredensial di atas merupakan akun demo. Untuk penggunaan publik, sebaiknya ganti password default dan hindari menggunakan kredensial yang sama pada lingkungan produksi.

## 📸 Screenshot Aplikasi

Berikut beberapa tampilan antarmuka Pustaka Digital.

### Landing Page

![Landing Page](https://github.com/user-attachments/assets/3fdcbb79-efd2-46c6-ab65-6cda899f3779)

### Dashboard Admin

![Dashboard Admin](https://github.com/user-attachments/assets/9c74860f-663b-445e-ae73-d01b699fb04e)

## 👨‍💻 Pengembang

**Dear Haens**

*Web Developer Enthusiast*

- GitHub: [@yarhns](https://github.com/yarhns)
- Repository: [Pustaka Digital — Sistem Informasi Perpustakaan](https://github.com/yarhns/perpustakaan-digital-laravel)

---

<div align="center">

  <i>Dibuat dengan ❤️ menggunakan Laravel 12.</i>

</div>
