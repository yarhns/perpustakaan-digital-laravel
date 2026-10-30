# 📚 Pustaka Digital - Sistem Informasi Perpustakaan

Sistem Informasi Manajemen Perpustakaan berbasis web yang dibangun menggunakan **Laravel 12**, **Tailwind CSS**, dan **MySQL**. Proyek ini dirancang untuk mempermudah pengelolaan koleksi buku, anggota, serta transaksi peminjaman dan pengembalian secara otomatis.

## ✨ Fitur Utama

- **Landing Page Publik**: Halaman depan modern untuk melihat katalog buku.
- **Mode Demo Interaktif**: Pengunjung dapat mencoba fitur admin (Read-Only) tanpa merusak data.
- **Autentikasi Admin**: Login aman untuk mengelola sistem.
- **Manajemen Buku**: CRUD lengkap, upload cover, sinopsis, dan stok otomatis.
- **Manajemen Anggota**: Pengelolaan data mahasiswa/anggota perpustakaan.
- **Peminjaman & Pengembalian**: Stok buku berkurang/bertambah secara otomatis.
- **Sistem Denda**: Menghitung denda keterlambatan secara otomatis.
- **Laporan PDF**: Cetak riwayat peminjaman dengan filter dinamis.
- **Dashboard Statistik**: Grafik tren peminjaman 7 hari terakhir.

## 🛠️ Teknologi yang Digunakan

- **Framework**: Laravel 12
- **Frontend**: Tailwind CSS (via CDN), FontAwesome, SweetAlert2
- **Database**: MySQL
- **PDF Generator**: barryvdh/laravel-dompdf
- **Chart**: Chart.js

## 🚀 Cara Menjalankan di Lokal

1. Clone repository ini:
   ```bash
   git clone https://github.com/yarhns/perpustakaan-digital-laravel.git
   cd perpustakaan-digital-laravel
   
## 📸 Screenshot

![Landing Page]<img width="1366" height="768" alt="Screenshot (330)" src="https://github.com/user-attachments/assets/3fdcbb79-efd2-46c6-ab65-6cda899f3779" />
![Dashboard]<img width="1366" height="768" alt="Screenshot (331)" src="https://github.com/user-attachments/assets/9c74860f-663b-445e-ae73-d01b699fb04e" />
