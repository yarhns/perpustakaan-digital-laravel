@extends('layouts.app')

@section('title', 'Dashboard Utama')

@section('content')
    <!-- WELCOME BANNER -->
    <div class="relative bg-indigo-900 rounded-2xl overflow-hidden mb-8 shadow-lg">
        <!-- Gambar Background -->
        <img src="https://images.unsplash.com/photo-1507842217343-583bb7270b66?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80" class="absolute inset-0 w-full h-full object-cover opacity-30">
        
        <!-- Overlay Gradien -->
        <div class="absolute inset-0 bg-gradient-to-r from-indigo-900 via-indigo-900/80 to-transparent"></div>
        
        <!-- Konten Teks -->
        <div class="relative z-10 p-8 md:p-10 w-full md:w-2/3">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-2">Selamat Datang, {{ session('is_demo') ? 'Pengunjung Demo' : 'Dear Haens' }}! 👋</h2>
            <p class="text-indigo-100 text-sm md:text-base mb-6">Berikut adalah ringkasan aktivitas perpustakaan Anda hari ini. Semua sistem berjalan dengan baik.</p>
            <div class="flex items-center space-x-4 text-sm text-indigo-200">
                <span class="bg-indigo-800/80 px-3 py-1.5 rounded-lg border border-indigo-700 backdrop-blur-sm">
                    <i class="fas fa-calendar-day mr-2"></i> {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                </span>
            </div>
        </div>
    </div>
    <!-- 4 Kotak Ringkasan -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Card 1: Total Buku -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center">
            <div class="w-14 h-14 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center text-2xl mr-4">
                <i class="fas fa-book"></i>
            </div>
            <div>
                <p class="text-gray-500 text-sm font-medium mb-1">Total Stok Buku</p>
                <h3 class="text-2xl font-bold text-gray-800">{{ number_format($totalBooks, 0, ',', '.') }}</h3>
            </div>
        </div>

        <!-- Card 2: Anggota -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center">
            <div class="w-14 h-14 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center text-2xl mr-4">
                <i class="fas fa-users"></i>
            </div>
            <div>
                <p class="text-gray-500 text-sm font-medium mb-1">Total Anggota</p>
                <h3 class="text-2xl font-bold text-gray-800">{{ number_format($totalMembers, 0, ',', '.') }}</h3>
            </div>
        </div>

        <!-- Card 3: Sedang Dipinjam -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center">
            <div class="w-14 h-14 rounded-full bg-yellow-50 text-yellow-600 flex items-center justify-center text-2xl mr-4">
                <i class="fas fa-book-reader"></i>
            </div>
            <div>
                <p class="text-gray-500 text-sm font-medium mb-1">Buku Dipinjam</p>
                <h3 class="text-2xl font-bold text-gray-800">{{ number_format($activeLoans, 0, ',', '.') }}</h3>
            </div>
        </div>

        <!-- Card 4: Terlambat -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center">
            <div class="w-14 h-14 rounded-full bg-red-50 text-red-600 flex items-center justify-center text-2xl mr-4">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div>
                <p class="text-gray-500 text-sm font-medium mb-1">Peminjaman Telat</p>
                <h3 class="text-2xl font-bold text-gray-800">{{ number_format($lateLoans, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>

    <!-- Area Grafik -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-lg font-bold text-gray-800 mb-6"><i class="fas fa-chart-line text-indigo-500 mr-2"></i>Tren Peminjaman (7 Hari Terakhir)</h3>
        <div class="relative h-80 w-full">
            <canvas id="loanChart"></canvas>
        </div>
    </div>
@endsection

@push('scripts')
<!-- Panggil Library Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('loanChart').getContext('2d');
    
    // Data dari Controller
    const labels = @json($dates);
    const dataTotals = @json($totals);

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Jumlah Buku Dipinjam',
                data: dataTotals,
                borderColor: '#4f46e5', // Warna Indigo
                backgroundColor: 'rgba(79, 70, 229, 0.1)', // Warna Indigo transparan
                borderWidth: 3,
                pointBackgroundColor: '#ffffff',
                pointBorderColor: '#4f46e5',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6,
                tension: 0.4, // Membuat garis melengkung (smooth)
                fill: true // Memberi warna di bawah garis
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 },
                    grid: { borderDash: [2, 4], color: '#e5e7eb' }
                },
                x: {
                    grid: { display: false }
                }
            }
        }
    });
</script>
@endpush