<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pustaka Digital</title>
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512'><path fill='%234f46e5' d='M64 64C64 46.3 78.3 32 96 32H416c17.7 0 32 14.3 32 32V416c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V64zm64 64v64H352V128H128zm0 128v64H352V256H128zm0 128v32H352V384H128z'/></svg>">
    <script src="https://cdn.tailwindcss.com"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- TAMBAHKAN INI: Library SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; background-color: #f3f4f6; }
                @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="flex h-screen overflow-hidden">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-indigo-900 text-white flex-shrink-0 hidden md:flex flex-col shadow-2xl z-20">
        <div class="h-20 flex items-center justify-center border-b border-indigo-800">
            <h1 class="text-2xl font-bold tracking-wider"><i class="fas fa-book-reader mr-2"></i>Pustaka.</h1>
        </div>
        
        <nav class="flex-1 py-6 px-4 space-y-2">
            <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('dashboard') ? 'bg-indigo-800 text-white shadow-sm' : 'text-indigo-200 hover:bg-indigo-800 hover:text-white' }} rounded-lg font-medium transition">
                <i class="fas fa-chart-pie w-6 text-indigo-300"></i> Dashboard
            </a>
            <a href="{{ route('books.index') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('books.*') ? 'bg-indigo-800 text-white shadow-sm' : 'text-indigo-200 hover:bg-indigo-800 hover:text-white' }} rounded-lg font-medium transition">
                <i class="fas fa-book w-6 text-indigo-300"></i> Koleksi Buku
            </a>
            <a href="{{ route('loans.index') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('loans.*') ? 'bg-indigo-800 text-white shadow-sm' : 'text-indigo-200 hover:bg-indigo-800 hover:text-white' }} rounded-lg font-medium transition">
                <i class="fas fa-exchange-alt w-6 text-indigo-300"></i> Peminjaman
            </a>
            <a href="{{ route('members.index') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('members.*') ? 'bg-indigo-800 text-white shadow-sm' : 'text-indigo-200 hover:bg-indigo-800 hover:text-white' }} rounded-lg font-medium transition">
                <i class="fas fa-users w-6 text-indigo-300"></i> Data Anggota
            </a>
        </nav>
        
                <div class="p-4 border-t border-indigo-800">
            <!-- TOMBOL KEMBALI KE WEB PUBLIK (Disembunyikan saat mode demo agar tidak terlalu ramai) -->
            @if(!session('is_demo'))
            <a href="{{ route('landing') }}" target="_blank" class="flex items-center justify-center w-full bg-indigo-800 hover:bg-indigo-700 text-white text-sm font-medium py-2 rounded-lg transition mb-4">
                <i class="fas fa-external-link-alt mr-2"></i> Lihat Halaman Depan
            </a>
            @endif
            
            <!-- PROFIL & LOGOUT -->
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-10 h-10 rounded-full bg-indigo-500 flex items-center justify-center font-bold text-lg">
                        {{ session('is_demo') ? 'D' : 'DH' }}
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium">{{ session('is_demo') ? 'Pengunjung Demo' : 'Dear Haens' }}</p>
                        <p class="text-xs {{ session('is_demo') ? 'text-yellow-400' : 'text-indigo-300' }}">
                            {{ session('is_demo') ? 'Mode Demo Aktif' : 'Administrator' }}
                        </p>
                    </div>
                </div>
                
                <!-- Tombol Logout (Tampil untuk Admin & Demo) -->
                @if(session('is_demo'))
                    <a href="{{ route('demo-logout') }}" class="text-red-400 hover:text-red-300 transition ml-2" title="Keluar Demo">
                        <i class="fas fa-sign-out-alt text-lg"></i>
                    </a>
                @else
                    <form method="POST" action="{{ route('logout') }}" class="ml-2">
                        @csrf
                        <button type="submit" class="text-red-400 hover:text-red-300 transition" title="Logout">
                            <i class="fas fa-sign-out-alt text-lg"></i>
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="flex-1 flex flex-col h-full overflow-hidden relative">
        <!-- Topbar -->
        <header class="h-20 bg-white shadow-sm flex items-center px-8 z-10 border-b border-gray-200">
            <div class="flex items-center text-indigo-700">
                <i class="fas fa-book-journal-whills text-2xl mr-3"></i>
                <h2 class="text-xl font-bold text-gray-800">@yield('title', 'Dashboard')</h2>
            </div>
        </header>

        <!-- Area Konten Dinamis -->
                <div class="flex-1 overflow-y-auto p-8 animate-[fadeIn_0.5s_ease-in-out]">
            
            <!-- 1. Alert Sukses -->
            @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm flex items-center justify-between">
                    <div><i class="fas fa-check-circle mr-2"></i>{{ session('success') }}</div>
                    <button onclick="this.parentElement.style.display='none'" class="text-green-700 hover:text-green-900"><i class="fas fa-times"></i></button>
                </div>
            @endif

            <!-- 2. Banner Mode Demo -->
            @if(session('is_demo'))
            <div class="bg-yellow-50 border-l-4 border-yellow-500 text-yellow-800 p-4 mb-6 rounded shadow-sm flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <i class="fas fa-flask mr-2"></i>
                    <strong>Mode Demo Aktif:</strong> Anda bisa mengisi form, tapi data tidak akan disimpan ke database.
                </div>
                <a href="{{ route('demo-logout') }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded text-sm font-bold transition whitespace-nowrap">
                    Keluar Demo
                </a>
            </div>
            @endif

            <!-- 3. Alert Jika Demo Mencoba Menyimpan Data -->
            @if(session('demo_error'))
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-sm flex items-center">
                <i class="fas fa-ban mr-2 text-lg"></i>
                <span>{{ session('demo_error') }}</span>
            </div>
            @endif

            <!-- 4. Alert Error Validasi Form -->
            @if($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-sm">
                    <ul class="list-disc ml-5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Konten Utama Halaman -->
            @yield('content')
        </div>
    </main>

        <!-- SCRIPT KONFIRMASI HAPUS GLOBAL -->
    <script>
        function confirmDelete(event, formElement) {
            event.preventDefault(); // Mencegah form langsung tersubmit
            
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444', // Warna Merah (Tailwind Red-500)
                cancelButtonColor: '#6b7280',  // Warna Abu-abu (Tailwind Gray-500)
                confirmButtonText: '<i class="fas fa-trash mr-2"></i> Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                customClass: {
                    popup: 'rounded-2xl',
                    confirmButton: 'rounded-lg px-5 py-2.5 font-bold',
                    cancelButton: 'rounded-lg px-5 py-2.5 font-bold'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    formElement.submit(); // Lanjutkan submit form jika diklik "Ya"
                }
            });
        }
    </script>

    @stack('scripts')
</body>
</html>