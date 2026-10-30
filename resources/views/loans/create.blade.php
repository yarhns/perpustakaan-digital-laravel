@extends('layouts.app')

@section('title', 'Buat Peminjaman')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="mb-6 flex items-center">
            <a href="{{ route('loans.index') }}" class="text-gray-500 hover:text-indigo-600 mr-4"><i class="fas fa-arrow-left text-xl"></i></a>
            <h2 class="text-2xl font-bold text-gray-800">Form Peminjaman Buku</h2>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
            <form method="POST" action="{{ route('loans.store') }}">
                @csrf
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Pilih Anggota (Peminjam)</label>
                        <select name="member_id" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 bg-gray-50" required>
                            <option value="">-- Cari dan Pilih Mahasiswa --</option>
                            @foreach($members as $member)
                                <option value="{{ $member->id }}">{{ $member->npm }} - {{ $member->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Pilih Buku</label>
                        <select name="book_id" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 bg-gray-50" required>
                            <option value="">-- Pilih Buku yang Tersedia --</option>
                            @foreach($books as $book)
                                <option value="{{ $book->id }}">{{ $book->title }} (Stok: {{ $book->stock }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mt-8 pt-6 border-t border-gray-100 flex justify-end">
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3 rounded-lg shadow-md font-bold transition">
                        <i class="fas fa-paper-plane mr-2"></i> Proses Peminjaman
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection