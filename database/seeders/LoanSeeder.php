<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Loan;
use App\Models\Book;
use App\Models\Member;
use Carbon\Carbon;

class LoanSeeder extends Seeder
{
    public function run()
    {
        // Ambil ID buku dan anggota yang sudah dibuat
        $books = Book::pluck('id')->toArray();
        $members = Member::pluck('id')->toArray();

        // Buat 40 riwayat peminjaman acak (7 hari terakhir)
        for ($i = 0; $i < 40; $i++) {
            $loanDate = Carbon::now()->subDays(rand(0, 6)); // Acak antara hari ini s/d 6 hari lalu
            $dueDate = (clone $loanDate)->addDays(7);
            
            // Acak status (60% masih dipinjam, 40% sudah dikembalikan)
            $isReturned = rand(1, 10) > 6; 
            
            Loan::create([
                'book_id' => $books[array_rand($books)],
                'member_id' => $members[array_rand($members)],
                'loan_date' => $loanDate,
                'due_date' => $dueDate,
                'return_date' => $isReturned ? (clone $loanDate)->addDays(rand(2, 10)) : null,
                'status' => $isReturned ? 'dikembalikan' : 'dipinjam',
                'fine' => 0 // Denda 0 untuk data dummy
            ]);
        }
    }
}