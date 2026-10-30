<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Pustaka Digital</title>
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512'><path fill='%234f46e5' d='M64 64C64 46.3 78.3 32 96 32H416c17.7 0 32 14.3 32 32V416c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V64zm64 64v64H352V128H128zm0 128v64H352V256H128zm0 128v32H352V384H128z'/></svg>">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 h-screen flex overflow-hidden">

        <!-- Bagian Kiri: Ilustrasi & Branding -->
    <div class="hidden md:flex md:w-1/2 relative bg-indigo-900">
        <!-- Background Image Perpustakaan -->
        <img src="https://images.unsplash.com/photo-1568667256549-094345857637?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80" 
             alt="Library Background" 
             class="absolute inset-0 w-full h-full object-cover opacity-40">
        
        <!-- Overlay Warna Indigo -->
        <div class="absolute inset-0 bg-indigo-900 mix-blend-multiply opacity-70"></div>

        <!-- Konten Teks -->
        <div class="relative z-10 flex flex-col justify-center items-center p-12 w-full text-center">
            <div class="bg-white/10 backdrop-blur-md p-6 rounded-3xl border border-white/20 mb-8 shadow-2xl">
                <i class="fas fa-book-journal-whills text-7xl text-white"></i>
            </div>
            <h1 class="text-4xl font-bold mb-4 text-white">Pustaka Digital.</h1>
            <p class="text-indigo-100 text-lg max-w-md">Sistem Informasi Manajemen Perpustakaan Modern. Silakan login untuk mengelola data.</p>
        </div>
    </div>

    <!-- Bagian Kanan: Form Login -->
    <div class="w-full md:w-1/2 flex items-center justify-center p-8 bg-white relative">
        <!-- Tombol Kembali ke Landing Page -->
        <a href="{{ route('landing') }}" class="absolute top-8 left-8 text-gray-500 hover:text-indigo-600 transition flex items-center text-sm font-medium">
            <i class="fas fa-arrow-left mr-2"></i> Kembali ke Depan
        </a>

        <div class="w-full max-w-md">
            <div class="text-center mb-10">
                <h2 class="text-3xl font-bold text-gray-800">Selamat Datang</h2>
                <p class="text-gray-500 mt-2">Silakan masukkan kredensial Admin Anda.</p>
            </div>

            <!-- Pesan Error -->
            @if($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-sm text-sm">
                    <i class="fas fa-exclamation-circle mr-2"></i> {{ $errors->first() }}
                </div>
            @endif

            <!-- Pesan Sukses (misal habis logout) -->
            @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm text-sm">
                    <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Alamat Email</label>
                    <div class="relative">
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="admin@pustaka.com" class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition" required autofocus>
                        <i class="fas fa-envelope absolute left-4 top-4 text-gray-400"></i>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                    <div class="relative">
                        <input type="password" name="password" placeholder="••••••••" class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition" required>
                        <i class="fas fa-lock absolute left-4 top-4 text-gray-400"></i>
                    </div>
                </div>

                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 rounded-lg shadow-md transition transform hover:scale-[1.02]">
                    Masuk ke Dashboard <i class="fas fa-arrow-right ml-2"></i>
                </button>
            </form>

            <div class="mt-8 pt-6 border-t border-gray-100 text-center">
                <p class="text-sm text-gray-500 mb-3">Belum punya akses? Coba jelajahi dulu.</p>
                <a href="{{ route('demo-login') }}" class="inline-block bg-indigo-50 text-indigo-700 font-semibold px-6 py-2 rounded-full hover:bg-indigo-100 transition text-sm">
                    <i class="fas fa-flask mr-2"></i> Masuk Mode Demo
                </a>
            </div>
        </div>
    </div>

</body>
</html>