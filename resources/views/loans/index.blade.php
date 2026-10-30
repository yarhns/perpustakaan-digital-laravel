@extends('layouts.app')

@section('title', 'Transaksi Peminjaman')

@section('content')
    <div class="flex flex-col md:flex-row justify-between md:items-end mb-8 gap-4">
        <div>
            <h2 class="text-3xl font-bold text-gray-800">Peminjaman Buku</h2>
            <p class="text-gray-500 mt-1">Riwayat peminjaman dan pengembalian buku.</p>
        </div>
        
        <!-- BAGIAN TOMBOL YANG DIUBAH -->
        <div class="flex gap-3">
            <!-- TOMBOL CETAK PDF BARU -->
            <a href="{{ route('loans.export-pdf', ['search' => request('search'), 'status' => request('status')]) }}" class="bg-red-600 hover:bg-red-700 text-white px-5 py-2.5 rounded-lg shadow-md transition flex items-center justify-center">
                <i class="fas fa-file-pdf mr-2"></i> Cetak PDF
            </a>

            <!-- TOMBOL BUAT PEMINJAMAN -->
            <a href="{{ route('loans.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-lg shadow-md transition flex items-center justify-center">
                <i class="fas fa-plus mr-2"></i> Buat Peminjaman
            </a>
        </div>
        <!-- AKHIR BAGIAN TOMBOL -->
        
    </div>    

    <!-- FORM PENCARIAN & FILTER -->
    <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 mb-6">
        <form method="GET" action="{{ route('loans.index') }}" class="flex flex-col md:flex-row gap-4">
            <!-- Input Search -->
            <div class="relative flex-1">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama anggota, NPM, atau judul buku..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 text-sm">
                <i class="fas fa-search absolute left-4 top-2.5 text-gray-400"></i>
            </div>
            
            <!-- Dropdown Filter Status -->
            <div class="w-full md:w-48">
                <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 text-sm bg-white">
                    <option value="">Semua Status</option>
                    <option value="dipinjam" {{ request('status') == 'dipinjam' ? 'selected' : '' }}>Sedang Dipinjam</option>
                    <option value="dikembalikan" {{ request('status') == 'dikembalikan' ? 'selected' : '' }}>Sudah Dikembalikan</option>
                    <option value="terlambat" {{ request('status') == 'terlambat' ? 'selected' : '' }}>Terlambat (Telat)</option>
                </select>
            </div>

            <!-- Tombol Submit & Reset -->
            <div class="flex gap-3">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-lg text-sm font-medium transition">
                    Terapkan
                </button>
                @if(request('search') || request('status'))
                <a href="{{ route('loans.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-600 px-5 py-2 rounded-lg text-sm font-medium transition flex items-center">
                    Reset
                </a>
                @endif
            </div>
        </form>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-x-auto">
        <table class="w-full text-left border-collapse min-w-max">
            <thead>
                <tr class="bg-gray-50 text-gray-600 text-sm border-b border-gray-200">
                    <th class="p-4 font-semibold">Peminjam</th>
                    <th class="p-4 font-semibold">Buku</th>
                    <th class="p-4 font-semibold">Tgl Pinjam</th>
                    <th class="p-4 font-semibold">Jatuh Tempo</th>
                    <th class="p-4 font-semibold">Status / Denda</th>
                    <th class="p-4 font-semibold text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-gray-700">
                @forelse($loans as $loan)
                <tr class="hover:bg-gray-50 transition">
                    <td class="p-4">
                        <div class="font-medium">{{ $loan->member->name }}</div>
                        <div class="text-xs text-gray-500">{{ $loan->member->npm }}</div>
                    </td>
                    <td class="p-4">
                        <div class="font-medium">{{ $loan->book->title }}</div>
                        <div class="text-xs text-gray-500">{{ $loan->book->author }}</div>
                    </td>
                    <td class="p-4">{{ \Carbon\Carbon::parse($loan->loan_date)->format('d M Y') }}</td>
                    
                    <td class="p-4">
                        @if($loan->status == 'dipinjam')
                            @if(\Carbon\Carbon::now()->greaterThan($loan->due_date))
                                <span class="text-red-600 font-semibold text-sm">
                                    <i class="fas fa-exclamation-triangle mr-1"></i>
                                    {{ \Carbon\Carbon::parse($loan->due_date)->format('d M Y') }} (Telat)
                                </span>
                            @else
                                <span class="text-gray-700 text-sm">
                                    {{ \Carbon\Carbon::parse($loan->due_date)->format('d M Y') }}
                                </span>
                            @endif
                        @else
                            <span class="text-gray-400 text-sm">-</span>
                        @endif
                    </td>
                    
                    <td class="p-4">
                        @if($loan->status == 'dipinjam')
                            <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-semibold"><i class="fas fa-clock mr-1"></i>Dipinjam</span>
                        @else
                            <div class="flex flex-col space-y-1 items-start">
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold"><i class="fas fa-check mr-1"></i>Dikembalikan</span>
                                @if($loan->fine > 0)
                                    <span class="text-red-600 text-xs font-bold">Denda: Rp {{ number_format($loan->fine, 0, ',', '.') }}</span>
                                @else
                                    <span class="text-green-600 text-xs font-medium">Tepat Waktu</span>
                                @endif
                            </div>
                        @endif
                    </td>
                    
                    <td class="p-4 text-center">
                        @if($loan->status == 'dipinjam')
                        <form method="POST" action="{{ route('loans.return', $loan->id) }}">
                            @csrf @method('PUT')
                            <button type="submit" class="bg-indigo-50 text-indigo-600 hover:bg-indigo-100 px-3 py-1.5 rounded text-sm font-medium transition" onclick="return confirm('Proses pengembalian buku ini?')">
                                Kembalikan
                            </button>
                        </form>
                        @else
                            <span class="text-gray-400 text-sm">-</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="p-12 text-center text-gray-500">
                        <i class="fas fa-search text-gray-300 text-4xl mb-3 block"></i>
                        <p class="text-lg font-medium text-gray-600 mb-1">Data tidak ditemukan</p>
                        <p class="text-sm">Tidak ada riwayat peminjaman yang cocok dengan pencarian atau filter Anda.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection