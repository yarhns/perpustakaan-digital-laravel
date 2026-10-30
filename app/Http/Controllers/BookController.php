<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request)
    {
        // Fitur Pencarian (Search)
        $search = $request->input('search');
        $books = Book::when($search, function ($query, $search) {
            return $query->where('title', 'like', "%{$search}%")
                         ->orWhere('author', 'like', "%{$search}%");
        })->get();

        return view('books.index', compact('books', 'search'));
    }

    // Di fungsi store:
public function store(Request $request)
{
            if (session('is_demo')) {
            return back()->with('demo_error', 'Mode Demo: Anda tidak diizinkan menyimpan, mengubah, atau menghapus data.');
        }

    $request->validate([
        'title' => 'required|string|max:255',
        'author' => 'required|string|max:255',
        'year' => 'required|integer|min:1900|max:' . date('Y'),
        'stock' => 'required|integer|min:0',
        'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Validasi gambar
        'description' => 'nullable|string',
    ]);

    $data = $request->all();

    if ($request->hasFile('image')) {
        // Simpan gambar ke folder storage/app/public/books
        $imagePath = $request->file('image')->store('books', 'public');
        $data['image'] = $imagePath;
    }

    Book::create($data);
    return redirect()->route('books.index')->with('success', 'Buku berhasil ditambahkan!');
}    

    // Di fungsi update:
public function update(Request $request, $id)
{
            if (session('is_demo')) {
            return back()->with('demo_error', 'Mode Demo: Anda tidak diizinkan menyimpan, mengubah, atau menghapus data.');
        }
    $request->validate([
        'title' => 'required|string|max:255',
        'author' => 'required|string|max:255',
        'year' => 'required|integer|min:1900|max:' . date('Y'),
        'stock' => 'required|integer|min:0',
        'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        'description' => 'nullable|string',
    ]);

    $book = Book::findOrFail($id);
    $data = $request->all();

    if ($request->hasFile('image')) {
        // Hapus gambar lama jika ada
        if ($book->image && \Storage::disk('public')->exists($book->image)) {
            \Storage::disk('public')->delete($book->image);
        }
        // Simpan gambar baru
        $imagePath = $request->file('image')->store('books', 'public');
        $data['image'] = $imagePath;
    }

    $book->update($data);
    return redirect()->route('books.index')->with('success', 'Buku berhasil diperbarui!');
}

    public function destroy($id)
    {
                if (session('is_demo')) {
            return back()->with('demo_error', 'Mode Demo: Anda tidak diizinkan menyimpan, mengubah, atau menghapus data.');
        }
        Book::findOrFail($id)->delete();
        return redirect()->route('books.index')->with('success', 'Buku berhasil dihapus!');
    }
}