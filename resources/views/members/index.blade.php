@extends('layouts.app')

@section('title', 'Data Anggota')

@section('content')
        <!-- Header Section & Search -->
    <div class="flex flex-col md:flex-row justify-between md:items-end mb-8 gap-4">
        <div>
            <h2 class="text-3xl font-bold text-gray-800">Data Anggota</h2>
            <p class="text-gray-500 mt-1">Total {{ count($members) }} anggota terdaftar.</p>
        </div>
        
        <div class="flex flex-col md:flex-row gap-3">
            <!-- Form Search Anggota -->
            <form method="GET" action="{{ route('members.index') }}" class="relative">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau NPM..." class="w-full md:w-64 pl-10 pr-4 py-2.5 bg-white border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 transition text-sm shadow-sm">
                <i class="fas fa-search absolute left-4 top-3 text-gray-400"></i>
                @if(request('search'))
                    <a href="{{ route('members.index') }}" class="absolute right-3 top-3 text-gray-400 hover:text-red-500"><i class="fas fa-times"></i></a>
                @endif
            </form>
            
            <button onclick="openModal()" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-lg shadow-md transition flex items-center justify-center whitespace-nowrap">
                <i class="fas fa-plus mr-2"></i> Tambah Anggota
            </button>
        </div>
    </div>

    <!-- Tabel Anggota -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-left border-collapse">            
            <thead>
                <tr class="bg-gray-50 text-gray-600 text-sm border-b border-gray-200">
                    <th class="p-4 font-semibold">No</th>
                    <th class="p-4 font-semibold">Nama Lengkap</th>
                    <th class="p-4 font-semibold">NPM</th>
                    <th class="p-4 font-semibold">Program Studi</th>
                    <th class="p-4 font-semibold text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-gray-700">
                @forelse($members as $index => $member)
                <tr class="hover:bg-gray-50 transition">
                    <td class="p-4">{{ $index + 1 }}</td>
                    <td class="p-4 font-medium flex items-center">
    <!-- Foto Profil Dummy berdasarkan Nama -->
    <img src="https://ui-avatars.com/api/?name={{ urlencode($member->name) }}&background=random&color=fff&rounded=true&bold=true" alt="{{ $member->name }}" class="w-9 h-9 rounded-full mr-3 shadow-sm">
    <div>
        <p class="text-gray-800 font-semibold">{{ $member->name }}</p>
        <p class="text-xs text-gray-500">Anggota</p>
    </div>
</td>
                    <td class="p-4">{{ $member->npm }}</td>
                    <td class="p-4"><span class="bg-blue-50 text-blue-600 px-3 py-1 rounded-full text-xs font-medium">{{ $member->prodi }}</span></td>
                                        <td class="p-4 text-center space-x-2">
                        <!-- Tombol Edit (Warna Kuning) -->
                        <button onclick="openEditModal({{ $member->id }}, '{{ addslashes($member->name) }}', '{{ $member->npm }}', '{{ addslashes($member->prodi) }}')" class="bg-yellow-100 text-yellow-600 hover:bg-yellow-200 px-3 py-1.5 rounded text-sm font-medium transition">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        
                        <!-- Tombol Hapus (Warna Merah) -->
                        <form method="POST" action="{{ route('members.destroy', $member->id) }}" class="inline-block" onsubmit="confirmDelete(event, this)">
                            @csrf 
                            @method('DELETE')
                            <button type="submit" class="bg-red-100 text-red-600 hover:bg-red-200 px-3 py-1.5 rounded text-sm font-medium transition">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-8 text-center text-gray-500">
                        <i class="fas fa-users text-gray-300 text-4xl mb-3 block"></i>
                        Belum ada data anggota. Silakan klik "Tambah Anggota".
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- MODAL TAMBAH ANGGOTA -->
    <div id="addModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center backdrop-blur-sm">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg mx-4 overflow-hidden">
            <div class="bg-indigo-600 px-6 py-4 flex justify-between items-center">
                <h3 class="text-lg font-bold text-white">Tambah Anggota Baru</h3>
                <button onclick="closeModal('addModal')" class="text-white hover:text-gray-200"><i class="fas fa-times text-xl"></i></button>
            </div>
            <form method="POST" action="{{ route('members.store') }}" class="p-6">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name') }}" placeholder="Masukkan nama lengkap" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">NPM</label>
                        <input type="text" name="npm" value="{{ old('npm') }}" placeholder="Masukkan NPM" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Program Studi</label>
                        <input type="text" name="prodi" value="{{ old('prodi') }}" placeholder="Contoh: Teknik Informatika" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500" required>
                    </div>
                </div>
                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" onclick="closeModal('addModal')" class="px-5 py-2 text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg transition">Batal</button>
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-lg transition">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL EDIT ANGGOTA -->
    <div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center backdrop-blur-sm">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg mx-4 overflow-hidden">
            <div class="bg-indigo-600 px-6 py-4 flex justify-between items-center">
                <h3 class="text-lg font-bold text-white">Edit Data Anggota</h3>
                <button onclick="closeModal('editModal')" class="text-white hover:text-gray-200"><i class="fas fa-times text-xl"></i></button>
            </div>
            <form id="editForm" method="POST" class="p-6">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap</label>
                        <input type="text" name="name" id="edit_name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 transition" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">NPM</label>
                        <input type="text" name="npm" id="edit_npm" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 transition" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Program Studi</label>
                        <input type="text" name="prodi" id="edit_prodi" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 transition" required>
                    </div>
                </div>
                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" onclick="closeModal('editModal')" class="px-5 py-2 text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg transition">Batal</button>
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-lg transition">Update Data</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function openModal() { document.getElementById('addModal').classList.remove('hidden'); }
    function closeModal(id) { document.getElementById(id).classList.add('hidden'); }
    
    // Fungsi untuk mengisi form edit dan membukanya
    function openEditModal(id, name, npm, prodi) {
        document.getElementById('editForm').action = '/members/' + id;
        document.getElementById('edit_name').value = name;
        document.getElementById('edit_npm').value = npm;
        document.getElementById('edit_prodi').value = prodi;
        document.getElementById('editModal').classList.remove('hidden');
    }

    // Buka form tambah jika ada error validasi
    @if($errors->any()) openModal(); @endif
</script>
@endpush