<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Member;
use App\Models\Loan;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        // Ambil 8 buku terbaru untuk katalog di halaman depan
        $books = Book::latest()->take(8)->get();
        
        // Ambil data statistik untuk dipamerkan
        $totalBooks = Book::sum('stock');
        $totalMembers = Member::count();
        $totalLoans = Loan::count();

        return view('landing', compact('books', 'totalBooks', 'totalMembers', 'totalLoans'));
    }
}