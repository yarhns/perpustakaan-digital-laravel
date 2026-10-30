<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Member;
use App\Models\Loan;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Hitung Data Ringkasan (Cards)
        $totalBooks = Book::sum('stock'); // Total stok buku yang tersedia
        $totalMembers = Member::count();
        $activeLoans = Loan::where('status', 'dipinjam')->count();
        
        // Hitung yang terlambat (status dipinjam & due_date < hari ini)
        $lateLoans = Loan::where('status', 'dipinjam')
                         ->where('due_date', '<', Carbon::now()->format('Y-m-d'))
                         ->count();

        // 2. Data untuk Grafik (7 Hari Terakhir)
        $chartData = Loan::select(
            DB::raw('DATE(loan_date) as date'),
            DB::raw('count(*) as total')
        )
        ->where('loan_date', '>=', Carbon::now()->subDays(7))
        ->groupBy('date')
        ->orderBy('date', 'ASC')
        ->get();

        $dates = [];
        $totals = [];

        // Looping 7 hari terakhir untuk memastikan grafik tetap terisi walau tidak ada peminjaman di hari tersebut
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $dates[] = Carbon::parse($date)->format('d M');
            
            // Cari data di $chartData yang tanggalnya sama
            $match = $chartData->firstWhere('date', $date);
            $totals[] = $match ? $match->total : 0;
        }

        return view('dashboard', compact('totalBooks', 'totalMembers', 'activeLoans', 'lateLoans', 'dates', 'totals'));
    }
}