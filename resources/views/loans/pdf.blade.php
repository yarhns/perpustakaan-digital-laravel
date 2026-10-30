<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Peminjaman Buku</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #4f46e5;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            color: #4f46e5;
            font-size: 20px;
        }
        .header p {
            margin: 5px 0 0 0;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f3f4f6;
            color: #333;
            font-weight: bold;
        }
        .text-center {
            text-align: center;
        }
        .badge-dipinjam { color: #d97706; font-weight: bold; }
        .badge-kembali { color: #059669; font-weight: bold; }
        .badge-telat { color: #dc2626; font-weight: bold; }
        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 10px;
            color: #888;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>Perpustakaan Digital</h1>
        <p>Laporan Riwayat Peminjaman Buku</p>
        <p>Dicetak pada: {{ \Carbon\Carbon::now()->timezone('Asia/Jakarta')->translatedFormat('d F Y, H:i') }} WIB</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="20%">Peminjam</th>
                <th width="25%">Judul Buku</th>
                <th width="15%">Tgl Pinjam</th>
                <th width="15%">Jatuh Tempo</th>
                <th width="20%">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($loans as $index => $loan)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>
                    <strong>{{ $loan->member->name }}</strong><br>
                    <small>{{ $loan->member->npm }}</small>
                </td>
                <td>{{ $loan->book->title }}</td>
                <td>{{ \Carbon\Carbon::parse($loan->loan_date)->format('d/m/Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($loan->due_date)->format('d/m/Y') }}</td>
                <td>
                    @if($loan->status == 'dipinjam')
                        @if(\Carbon\Carbon::now()->greaterThan($loan->due_date))
                            <span class="badge-telat">TERLAMBAT</span>
                        @else
                            <span class="badge-dipinjam">DIPINJAM</span>
                        @endif
                    @else
                        <span class="badge-kembali">DIKEMBALIKAN</span><br>
                        @if($loan->fine > 0)
                            <small style="color: #dc2626;">Denda: Rp {{ number_format($loan->fine, 0, ',', '.') }}</small>
                        @endif
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">Tidak ada data peminjaman.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Laporan ini di-generate secara otomatis oleh Sistem Perpustakaan Digital.</p>
    </div>

</body>
</html>