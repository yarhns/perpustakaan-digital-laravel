<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Book;

class BookSeeder extends Seeder
{
    public function run()
    {
        // Buat 30 buku otomatis
        Book::factory(30)->create();
    }
}