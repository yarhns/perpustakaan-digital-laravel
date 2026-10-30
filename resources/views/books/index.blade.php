@extends('layouts.app')

@section('title', 'Koleksi Buku')

@section('content')
    <!-- Header Section -->
    <div class="flex justify-between items-end mb-8">
        <div>
            <h2 class="text-3xl font-bold text-gray-800">Koleksi Buku</h2>
            <p class="text-gray-500 mt-1">Total {{ count($books) }} buku tersedia.</p>
        </div>
        <button onclick="openAddModal()" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-lg shadow-md transition flex items-center">
            <i class="fas fa-plus mr-2"></i> Tambah Buku
        </button>
    </div>

    <!-- PENCARIAN -->
    <form method="GET" action="{{ route('books.index') }}" class="relative w-full max-w-md mb-6">
        <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari judul atau penulis..." class="w-full pl-10 pr-4 py-2 bg-white border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 transition text-sm shadow-sm">
        <i class="fas fa-search absolute left-4 top-2.5 text-gray-400"></i>
    </form>

    <!-- GRID BUKU -->
    @if(count($books) > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($books as $book)
            <div onclick="openDetailModal('{{ $book->image ? asset('storage/' . $book->image) : '' }}', '{{ addslashes($book->title) }}', '{{ addslashes($book->author) }}', '{{ $book->year }}', '{{ $book->stock }}', '{{ addslashes($book->description) }}')" 
                 class="bg-white cursor-pointer rounded-xl shadow-sm hover:shadow-xl transition-all duration-300 group overflow-hidden border border-gray-100 flex flex-col">
                
                                <!-- Bagian Cover Gambar -->
                <div class="h-56 bg-gray-100 flex items-center justify-center relative overflow-hidden">
                    @if($book->image)
                        <img src="{{ asset('storage/' . $book->image) }}" alt="{{ $book->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    @else
                        <!-- Ganti Gradien dengan Foto Buku Unsplash -->
                        <div class="w-full h-full relative">
                            <!-- Foto buku (bisa diganti sesuai selera) -->
                            <img src="https://images.unsplash.com/photo-1544947950-fa07a98d237f?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            <!-- Overlay gelap agar teks terbaca -->
                            <div class="absolute inset-0 bg-black/40 flex items-center justify-center p-4">
                                <h3 class="text-white text-lg font-bold text-center leading-tight">{{ Str::limit($book->title, 25) }}</h3>
                            </div>
                        </div>
                    @endif
                    
                    <!-- Tombol Aksi (Edit/Hapus) -->
                    <div class="absolute top-2 right-2 flex space-x-1 opacity-0 group-hover:opacity-100 transition-opacity z-20">
                        <button onclick="event.stopPropagation(); openEditModal({{ $book->id }}, '{{ addslashes($book->title) }}', '{{ addslashes($book->author) }}', {{ $book->year }}, {{ $book->stock }}, '{{ addslashes($book->description) }}')" class="bg-white text-yellow-600 p-2 rounded-full hover:bg-yellow-50 shadow" title="Edit">
                            <i class="fas fa-edit text-sm"></i>
                        </button>
                        
                        <form method="POST" action="{{ route('books.destroy', $book->id) }}" onsubmit="confirmDelete(event, this)" onclick="event.stopPropagation();">
                            @csrf @method('DELETE')
                            <button type="submit" class="bg-white text-red-600 p-2 rounded-full hover:bg-red-50 shadow" title="Hapus">
                                <i class="fas fa-trash text-sm"></i>
                            </button>
                        </form>
                    </div>
                </div>
                
                <!-- Bagian Detail Buku -->
                <div class="p-5 flex-1 flex flex-col">
                    <h4 class="font-bold text-gray-800 text-lg mb-1 leading-tight">{{ $book->title }}</h4>
                    <p class="text-sm text-gray-500 mb-4"><i class="fas fa-pen-nib mr-1 text-indigo-400"></i> {{ $book->author }}</p>
                    <div class="mt-auto flex justify-between items-center pt-3 border-t border-gray-100">
                        <span class="text-xs font-medium text-gray-500 bg-gray-100 px-2 py-1 rounded">
                            <i class="fas fa-calendar-alt mr-1"></i> {{ $book->year }}
                        </span>
                        <span class="text-xs font-medium {{ $book->stock > 0 ? 'text-green-600 bg-green-50' : 'text-red-600 bg-red-50' }} px-2 py-1 rounded">
                            Stok: {{ $book->stock }}
                        </span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <div class="bg-white rounded-xl border border-dashed border-gray-300 p-12 text-center">
            <p class="text-gray-500">Buku tidak ditemukan atau belum ada buku.</p>
        </div>
    @endif

    <!-- ========================================== -->
    <!-- MODAL TAMBAH BUKU -->
    <!-- ========================================== -->
    <div id="addModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center backdrop-blur-sm">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg mx-4 overflow-hidden">
            <div class="bg-indigo-600 px-6 py-4 flex justify-between items-center">
                <h3 class="text-lg font-bold text-white">Tambah Buku Baru</h3>
                <button onclick="closeModal('addModal')" class="text-white hover:text-gray-200"><i class="fas fa-times text-xl"></i></button>
            </div>
            
            <form method="POST" action="{{ route('books.store') }}" class="p-6" enctype="multipart/form-data">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Judul Buku</label>
                        <input type="text" name="title" value="{{ old('title') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Penulis</label>
                        <input type="text" name="author" value="{{ old('author') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500" required>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Tahun</label>
                            <input type="number" name="year" value="{{ old('year') }}" min="1900" max="{{ date('Y') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500" required>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Stok Awal</label>
                            <input type="number" name="stock" value="1" min="1" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500" required>
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Cover Buku (Opsional)</label>
                        <input type="file" name="image" accept="image/*" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 text-sm bg-gray-50 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Sinopsis (Opsional)</label>
                        <textarea name="description" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500" placeholder="Tuliskan sinopsis singkat buku..."></textarea>
                    </div>
                </div>
                
                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" onclick="closeModal('addModal')" class="px-5 py-2 text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg transition">Batal</button>
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-lg transition">Simpan Buku</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- MODAL EDIT BUKU -->
    <!-- ========================================== -->
    <div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center backdrop-blur-sm">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg mx-4 overflow-hidden">
            <div class="bg-indigo-600 px-6 py-4 flex justify-between items-center">
                <h3 class="text-lg font-bold text-white">Edit Data Buku</h3>
                <button onclick="closeModal('editModal')" class="text-white hover:text-gray-200"><i class="fas fa-times text-xl"></i></button>
            </div>
            
            <form id="editForm" method="POST" class="p-6" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Judul Buku</label>
                        <input type="text" name="title" id="edit_title" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Penulis</label>
                        <input type="text" name="author" id="edit_author" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500" required>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Tahun</label>
                            <input type="number" name="year" id="edit_year" min="1900" max="{{ date('Y') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500" required>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Stok</label>
                            <input type="number" name="stock" id="edit_stock" min="0" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500" required>
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Ganti Cover (Opsional)</label>
                        <input type="file" name="image" accept="image/*" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 text-sm bg-gray-50 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                        <p class="text-xs text-gray-500 mt-1">Biarkan kosong jika tidak ingin mengubah cover.</p>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Sinopsis (Opsional)</label>
                        <textarea name="description" id="edit_description" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500"></textarea>
                    </div>
                </div>
                
                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" onclick="closeModal('editModal')" class="px-5 py-2 text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg transition">Batal</button>
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-lg transition">Update Buku</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- MODAL DETAIL BUKU -->
    <!-- ========================================== -->
    <div id="detailModal" class="fixed inset-0 bg-black bg-opacity-60 hidden z-50 flex items-center justify-center backdrop-blur-sm p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-3xl mx-auto overflow-hidden flex flex-col md:flex-row relative">
            <!-- Tombol Close -->
            <button onclick="closeModal('detailModal')" class="absolute top-4 right-4 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-full w-8 h-8 flex items-center justify-center z-10 transition">
                <i class="fas fa-times"></i>
            </button>

            <!-- Bagian Cover -->
            <div class="w-full md:w-2/5 h-64 md:h-auto bg-gray-100 relative">
                <img id="detail_image" src="" alt="Cover" class="w-full h-full object-cover hidden">
                <div id="detail_no_image" class="w-full h-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center p-6 hidden">
                    <h3 id="detail_title_placeholder" class="text-white text-3xl font-bold text-center"></h3>
                </div>
            </div>

            <!-- Bagian Info -->
            <div class="p-8 w-full md:w-3/5 flex flex-col">
                <h2 id="detail_title" class="text-3xl font-bold text-gray-800 mb-2 leading-tight"></h2>
                <p class="text-indigo-600 font-medium mb-4"><i class="fas fa-pen-nib mr-2"></i><span id="detail_author"></span></p>
                
                <div class="flex gap-4 mb-6">
                    <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm font-medium">
                        <i class="fas fa-calendar-alt mr-1 text-gray-400"></i> Tahun: <span id="detail_year"></span>
                    </span>
                    <span id="detail_stock_container" class="px-3 py-1 rounded-full text-sm font-medium">
                        <i class="fas fa-box mr-1"></i> Stok: <span id="detail_stock"></span>
                    </span>
                </div>

                <h4 class="text-gray-800 font-bold mb-2">Sinopsis</h4>
                <p id="detail_description" class="text-gray-600 text-sm leading-relaxed overflow-y-auto max-h-40"></p>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Fungsi Buka Modal Tambah
    function openAddModal() { document.getElementById('addModal').classList.remove('hidden'); }
    
    // Fungsi Tutup Modal (Universal)
    function closeModal(id) { document.getElementById(id).classList.add('hidden'); }
    
    // Fungsi Buka Modal Edit & Isi Data Otomatis
    function openEditModal(id, title, author, year, stock, description) {
        // Set action URL form ke route update
        document.getElementById('editForm').action = '/books/' + id;
        
        // Isi value inputan
        document.getElementById('edit_title').value = title;
        document.getElementById('edit_author').value = author;
        document.getElementById('edit_year').value = year;
        document.getElementById('edit_stock').value = stock;
        document.getElementById('edit_description').value = description ? description : '';
        
        // Buka Modal
        document.getElementById('editModal').classList.remove('hidden');
    }

    // Fungsi Buka Modal Detail Buku
    function openDetailModal(image, title, author, year, stock, description) {
        // Set Data Teks
        document.getElementById('detail_title').innerText = title;
        document.getElementById('detail_author').innerText = author;
        document.getElementById('detail_year').innerText = year;
        document.getElementById('detail_stock').innerText = stock;
        document.getElementById('detail_description').innerText = description ? description : 'Belum ada sinopsis untuk buku ini.';

        // Logika Gambar
        const imgElement = document.getElementById('detail_image');
        const noImgElement = document.getElementById('detail_no_image');
        
        if (image) {
            imgElement.src = image;
            imgElement.classList.remove('hidden');
            noImgElement.classList.add('hidden');
        } else {
            document.getElementById('detail_title_placeholder').innerText = title;
            noImgElement.classList.remove('hidden');
            imgElement.classList.add('hidden');
        }

        // Warna Stok Berdasarkan Jumlah
        const stockContainer = document.getElementById('detail_stock_container');
        if (stock > 0) {
            stockContainer.className = 'px-3 py-1 rounded-full text-sm font-medium bg-green-50 text-green-700';
        } else {
            stockContainer.className = 'px-3 py-1 rounded-full text-sm font-medium bg-red-50 text-red-700';
        }

        // Tampilkan Modal
        document.getElementById('detailModal').classList.remove('hidden');
    }

    // Otomatis buka modal tambah jika ada error validasi dari server
    @if($errors->any()) openAddModal(); @endif
</script>
@endpush