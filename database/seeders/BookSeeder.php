<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;

class BookSeeder extends Seeder
{
    public function run()
    {
        // Daftar Buku Asli (Judul, Penulis, Tahun, Stok)
        $books = [
            ['title' => 'Laskar Pelangi', 'author' => 'Andrea Hirata', 'year' => 2005, 'stock' => 5],
            ['title' => 'Bumi Manusia', 'author' => 'Pramoedya Ananta Toer', 'year' => 1980, 'stock' => 3],
            ['title' => 'Filosofi Teras', 'author' => 'Henry Manampiring', 'year' => 2018, 'stock' => 4],
            ['title' => 'Atomic Habits', 'author' => 'James Clear', 'year' => 2018, 'stock' => 6],
            ['title' => 'Sapiens: A Brief History of Humankind', 'author' => 'Yuval Noah Harari', 'year' => 2011, 'stock' => 2],
            ['title' => 'Bumi', 'author' => 'Tere Liye', 'year' => 2014, 'stock' => 7],
            ['title' => 'Cantik Itu Luka', 'author' => 'Eka Kurniawan', 'year' => 2002, 'stock' => 3],
            ['title' => 'Pulang', 'author' => 'Leila S. Chudori', 'year' => 2012, 'stock' => 4],
            ['title' => 'Negeri 5 Menara', 'author' => 'Ahmad Fuadi', 'year' => 2009, 'stock' => 5],
            ['title' => 'The Psychology of Money', 'author' => 'Morgan Housel', 'year' => 2020, 'stock' => 3],
            ['title' => 'Rich Dad Poor Dad', 'author' => 'Robert T. Kiyosaki', 'year' => 1997, 'stock' => 4],
            ['title' => 'Clean Code', 'author' => 'Robert C. Martin', 'year' => 2008, 'stock' => 2],
            ['title' => 'Algoritma dan Pemrograman', 'author' => 'Rinaldi Munir', 'year' => 2016, 'stock' => 5],
            ['title' => 'Sistem Basis Data', 'author' => 'Abdul Kadir', 'year' => 2018, 'stock' => 3],
            ['title' => 'Pemrograman Web dengan PHP dan MySQL', 'author' => 'Abdul Kadir', 'year' => 2019, 'stock' => 4],
        ];

        // Looping dan simpan ke database
        foreach ($books as $book) {
            Book::create([
                'title' => $book['title'],
                'author' => $book['author'],
                'year' => $book['year'],
                'stock' => $book['stock'],
                'image' => null,
                'description' => 'Ini adalah deskripsi dummy untuk buku ' . $book['title'] . '. Buku ini merupakan salah satu koleksi terbaik di perpustakaan kami.'
            ]);
        }
    }
}