<?php
namespace App\Http\Controllers;
use App\Models\Loan;
use App\Models\Book;
use App\Models\Member;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class LoanController extends Controller
{
        public function index(Request $request)
    {
        // Mulai Query
        $query = Loan::with(['book', 'member']);

        // 1. Logika Pencarian (Search)
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('member', function($memberQuery) use ($search) {
                    $memberQuery->where('name', 'like', "%{$search}%")
                                ->orWhere('npm', 'like', "%{$search}%");
                })->orWhereHas('book', function($bookQuery) use ($search) {
                    $bookQuery->where('title', 'like', "%{$search}%");
                });
            });
        }

        // 2. Logika Filter Status
        if ($request->has('status') && $request->status != '') {
            if ($request->status == 'terlambat') {
                $query->where('status', 'dipinjam')
                      ->where('due_date', '<', Carbon::now()->format('Y-m-d'));
            } else {
                $query->where('status', $request->status);
            }
        }

        // Eksekusi Query (Urutkan dari yang terbaru)
        $loans = $query->latest()->get();
        
        return view('loans.index', compact('loans'));
    }

    public function create()
    {
        // Hanya tampilkan buku yang stoknya > 0
        $books = Book::where('stock', '>', 0)->get(); 
        $members = Member::all();
        return view('loans.create', compact('books', 'members'));
    }

        public function store(Request $request)
    {
                if (session('is_demo')) {
            return back()->with('demo_error', 'Mode Demo: Anda tidak diizinkan menyimpan, mengubah, atau menghapus data.');
        }

        $request->validate([
            'book_id' => 'required|exists:books,id',
            'member_id' => 'required|exists:members,id',
        ]);

        $book = Book::findOrFail($request->book_id);
        

        if ($book->stock <= 0) {
            return back()->withErrors(['book_id' => 'Stok buku ini sedang habis!']);
        }


        // Buat transaksi + Tambahkan Due Date (Jatuh Tempo 7 Hari)
        Loan::create([
            'book_id' => $request->book_id,
            'member_id' => $request->member_id,
            'loan_date' => Carbon::now(),
            'due_date' => Carbon::now()->addDays(7), // <--- TAMBAHKAN INI
            'status' => 'dipinjam'
        ]);

        $book->decrement('stock');

        return redirect()->route('loans.index')->with('success', 'Buku berhasil dipinjam! Jatuh tempo 7 hari.');
    }

        public function returnBook($id)
    {
                if (session('is_demo')) {
            return back()->with('demo_error', 'Mode Demo: Anda tidak diizinkan menyimpan, mengubah, atau menghapus data.');
        }
        $loan = Loan::findOrFail($id);
        $returnDate = Carbon::now();
        $fine = 0;

        // Hitung denda jika melewati jatuh tempo
        if ($returnDate->greaterThan($loan->due_date)) {
            $daysLate = $returnDate->diffInDays($loan->due_date);
            $fine = $daysLate * 1000; // Denda Rp 1.000 per hari
        }

        // Update status pinjaman
        $loan->update([
            'return_date' => $returnDate,
            'status' => 'dikembalikan',
            'fine' => $fine // <--- Simpan total denda
        ]);

        // Tambah stok buku kembali
        $loan->book->increment('stock');

        if ($fine > 0) {
            return redirect()->route('loans.index')->with('success', 'Buku dikembalikan. Terlambat ' . $daysLate . ' hari. Denda: Rp ' . number_format($fine, 0, ',', '.'));
        }

        return redirect()->route('loans.index')->with('success', 'Buku berhasil dikembalikan tepat waktu!');
    }

        public function exportPdf(Request $request)
    {
        // Ambil data persis seperti logika di fungsi index (mengikuti filter & search)
        $query = Loan::with(['book', 'member']);

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('member', function($memberQuery) use ($search) {
                    $memberQuery->where('name', 'like', "%{$search}%")
                                ->orWhere('npm', 'like', "%{$search}%");
                })->orWhereHas('book', function($bookQuery) use ($search) {
                    $bookQuery->where('title', 'like', "%{$search}%");
                });
            });
        }

        if ($request->has('status') && $request->status != '') {
            if ($request->status == 'terlambat') {
                $query->where('status', 'dipinjam')
                      ->where('due_date', '<', Carbon::now()->format('Y-m-d'));
            } else {
                $query->where('status', $request->status);
            }
        }

        $loans = $query->latest()->get();

        // Load view khusus PDF dan kirim data
        $pdf = Pdf::loadView('loans.pdf', compact('loans'));
        
        // (Opsional) Set ukuran kertas ke A4 Landscape agar tabel muat
        $pdf->setPaper('A4', 'landscape');

        // Download file dengan nama laporan-peminjaman-tanggal.pdf
        return $pdf->download('Laporan-Peminjaman-' . date('d-m-Y') . '.pdf');
    }
}