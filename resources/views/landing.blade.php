<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pustaka Digital - Perpustakaan Modern</title>
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512'><path fill='%234f46e5' d='M64 64C64 46.3 78.3 32 96 32H416c17.7 0 32 14.3 32 32V416c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V64zm64 64v64H352V128H128zm0 128v64H352V256H128zm0 128v32H352V384H128z'/></svg>">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; scroll-behavior: smooth; }
    </style>
</head>
<body class="bg-gray-50">

    <!-- NAVBAR -->
    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <!-- Logo -->
                <div class="flex items-center text-indigo-700">
                    <i class="fas fa-book-journal-whills text-3xl mr-3"></i>
                    <span class="text-2xl font-bold tracking-tight">Pustaka Digital.</span>
                </div>
                <!-- Menu -->
<div class="flex items-center space-x-3 md:space-x-4">
    <a href="#katalog" class="text-gray-600 hover:text-indigo-600 font-medium hidden md:block mr-2">Katalog Buku</a>
    
    <!-- TOMBOL DEMO PUBLIK -->
    <a href="{{ route('demo-login') }}" class="bg-white text-indigo-600 border border-indigo-600 hover:bg-indigo-50 px-4 py-2 rounded-lg font-semibold transition shadow-sm flex items-center text-sm">
        <i class="fas fa-flask mr-2"></i> Coba Demo
    </a>

    <!-- TOMBOL LOGIN ADMIN (Sementara mengarah ke dashboard, nanti kita buat form login) -->
    <a href="{{ route('login') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg font-semibold transition shadow-md flex items-center text-sm">
    <i class="fas fa-lock mr-2"></i> Login Admin
</a>
</div>
            </div>
        </div>
    </nav>

        <!-- HERO SECTION -->
    <header class="bg-indigo-900 text-white relative overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-28 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                
                <!-- Kolom Kiri: Teks & Tombol -->
                <div>
                    <span class="inline-block py-1 px-3 rounded-full bg-indigo-800 text-indigo-300 text-sm font-semibold mb-6 border border-indigo-700">
                        <i class="fas fa-star mr-1 text-yellow-400"></i> Perpustakaan Modern
                    </span>
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold leading-tight mb-6">Jelajahi Dunia Melalui <span class="text-indigo-400">Membaca.</span></h1>
                    <p class="text-lg md:text-xl text-indigo-100 mb-8 max-w-lg">Sistem Perpustakaan Digital modern. Temukan ribuan koleksi buku, pinjam dengan mudah, dan kelola riwayat bacaan Anda dalam satu platform.</p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="#katalog" class="bg-white text-indigo-900 px-8 py-3 rounded-full font-bold shadow-lg hover:bg-gray-100 transition text-center">Lihat Katalog</a>
                        <a href="{{ route('demo-login') }}" class="bg-indigo-600 border border-indigo-500 text-white px-8 py-3 rounded-full font-bold shadow-lg hover:bg-indigo-700 transition text-center">Coba Demo</a>
                    </div>
                </div>

                <!-- Kolom Kanan: Foto Perpustakaan -->
                <div class="hidden lg:block relative">
                    <!-- Efek hiasan di belakang foto -->
                    <div class="absolute inset-0 bg-indigo-500 rounded-3xl transform rotate-3 scale-105 opacity-30"></div>
                    
                    <!-- Foto Utama -->
                    <img src="https://images.unsplash.com/photo-1507842217343-583bb7270b66?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80" 
                         alt="Perpustakaan Modern" 
                         class="relative rounded-3xl shadow-2xl object-cover h-[400px] w-full border-4 border-indigo-800">
                    
                    <!-- Kartu kecil melayang -->
                    <div class="absolute -bottom-6 -left-6 bg-white p-4 rounded-xl shadow-xl flex items-center gap-3">
                        <div class="w-10 h-10 bg-green-100 text-green-600 rounded-full flex items-center justify-center">
                            <i class="fas fa-check"></i>
                        </div>
                        <div>
                            <p class="text-gray-800 font-bold text-sm">Sistem Otomatis</p>
                            <p class="text-gray-500 text-xs">Denda & Stok terupdate</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        
        <!-- STATISTIK MELAYANG (Tetap dipertahankan) -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 -mb-16 transform translate-y-16">
            <div class="bg-white rounded-2xl shadow-xl p-8 grid grid-cols-1 md:grid-cols-3 gap-8 text-center divide-y md:divide-y-0 md:divide-x divide-gray-100">
                <div>
                    <p class="text-gray-500 font-medium mb-1">Total Stok Buku</p>
                    <h3 class="text-4xl font-bold text-indigo-600">{{ number_format($totalBooks, 0, ',', '.') }}</h3>
                </div>
                <div>
                    <p class="text-gray-500 font-medium mb-1">Anggota Terdaftar</p>
                    <h3 class="text-4xl font-bold text-indigo-600">{{ number_format($totalMembers, 0, ',', '.') }}</h3>
                </div>
                <div>
                    <p class="text-gray-500 font-medium mb-1">Total Transaksi</p>
                    <h3 class="text-4xl font-bold text-indigo-600">{{ number_format($totalLoans, 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>
    </header>

    <!-- KATALOG BUKU -->
    <section id="katalog" class="py-24 bg-gray-50 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Koleksi Terbaru</h2>
                <p class="text-gray-500 max-w-2xl mx-auto">Temukan buku-buku terbaru yang baru saja ditambahkan ke dalam sistem perpustakaan kami.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($books as $book)
                <div class="bg-white rounded-xl shadow-sm hover:shadow-xl transition duration-300 overflow-hidden border border-gray-100 flex flex-col group">
                    <div class="h-56 bg-gray-100 relative overflow-hidden">
                                                @if($book->image)
                            <img src="{{ asset('storage/' . $book->image) }}" alt="{{ $book->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        @else
                            <!-- Ganti gradien polos dengan gambar ilustrasi buku -->
                            <div class="w-full h-full bg-gray-200 flex items-center justify-center relative overflow-hidden">
                                <img src="https://images.unsplash.com/photo-1544947950-fa07a98d237f?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" class="w-full h-full object-cover opacity-80 group-hover:scale-105 transition-transform duration-300">
                                <div class="absolute inset-0 bg-black/40 flex items-center justify-center p-4">
                                    <h3 class="text-white text-lg font-bold text-center">{{ Str::limit($book->title, 25) }}</h3>
                                </div>
                            </div>
                        @endif
                        <div class="absolute top-2 right-2 bg-white/90 backdrop-blur-sm px-2 py-1 rounded text-xs font-bold text-gray-800">
                            Stok: {{ $book->stock }}
                        </div>
                    </div>
                    <div class="p-5 flex-1 flex flex-col">
                        <h4 class="font-bold text-gray-800 text-lg mb-1 leading-tight">{{ $book->title }}</h4>
                        <p class="text-sm text-gray-500 mb-4"><i class="fas fa-pen-nib mr-1 text-indigo-400"></i> {{ $book->author }}</p>
                        <div class="mt-auto text-xs font-medium text-gray-500 bg-gray-100 px-2 py-1 rounded inline-block w-max">
                            <i class="fas fa-calendar-alt mr-1"></i> {{ $book->year }}
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

        <!-- BANNER CALL TO ACTION (DEMO) -->
    <section class="py-20 bg-indigo-600 relative overflow-hidden">
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">Ingin Mencoba Sistemnya?</h2>
            <p class="text-indigo-100 text-lg mb-8">Jelajahi seluruh fitur Dashboard tanpa perlu membuat akun. Data yang Anda masukkan tidak akan disimpan secara permanen (Read-Only Demo).</p>
            <a href="{{ route('demo-login') }}" class="inline-block bg-white text-indigo-700 px-10 py-4 rounded-full font-bold text-lg shadow-xl hover:bg-gray-100 hover:scale-105 transition transform">
                <i class="fas fa-play mr-2"></i> Mulai Uji Coba
            </a>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center text-center md:text-left gap-4">
            <div class="flex items-center justify-center md:justify-start">
                <i class="fas fa-book-journal-whills text-2xl text-indigo-400 mr-3"></i>
                <span class="text-xl font-bold">Pustaka Digital.</span>
            </div>
            <p class="text-gray-400 text-sm">&copy; {{ date('Y') }} Pustaka Digital. Dibuat oleh Dear Haens.</p>
        </div>
    </footer>

</body>
</html>