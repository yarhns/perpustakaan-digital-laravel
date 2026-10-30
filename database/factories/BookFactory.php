<?php
namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    public function definition()
    {
        // Daftar buku terkenal di Indonesia & Dunia
        $titles = [
            'Laskar Pelangi', 'Bumi Manusia', 'Filosofi Teras', 'Atomic Habits', 
            'Sapiens', 'Bumi', 'Cantik Itu Luka', 'Pulang', 'Negeri 5 Menara',
            'The Psychology of Money', 'Rich Dad Poor Dad', 'Pemrograman Laravel',
            'Clean Code', 'Algoritma dan Struktur Data', 'Sistem Basis Data'
        ];
        
        $authors = [
            'Andrea Hirata', 'Pramoedya Ananta Toer', 'Henry Manampiring', 
            'James Clear', 'Yuval Noah Harari', 'Tere Liye', 'Eka Kurniawan',
            'Leila S. Chudori', 'Ahmad Fuadi', 'Morgan Housel', 'Robert Kiyosaki',
            'Robert C. Martin', 'Rinaldi Munir', 'Abdul Kadir'
        ];

        return [
            'title' => $this->faker->randomElement($titles) . ' ' . $this->faker->numberBetween(1, 5), // Diberi angka agar unik
            'author' => $this->faker->randomElement($authors),
            'year' => $this->faker->numberBetween(2000, 2023),
            'stock' => $this->faker->numberBetween(1, 10),
            'image' => null, // Biarkan null agar tampil cover gradien otomatis
        ];
    }
}