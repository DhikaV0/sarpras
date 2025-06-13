<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengembalian Barang</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-blue-50">
    <!-- Navbar -->
    <div class="bg-blue-900 p-4 sticky top-0 z-50 shadow-md">
        <div class="container mx-auto flex justify-end">
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                @csrf
            </form>
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
               class="text-white hover:text-blue-200 font-semibold px-4 py-2 rounded-lg transition-colors">
                <i class="fas fa-sign-out-alt mr-2"></i>Logout
            </a>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="fixed left-0 top-0 h-full w-64 bg-blue-900 text-white shadow-lg z-40 pt-20">
        <div class="flex flex-col items-center mb-10 px-4">
            <div class="bg-blue-400 p-4 rounded-xl w-40 text-center mb-6">
                <img src="https://smktarunabhakti.net/wp-content/uploads/2020/07/logotbvector-copy.png"
                     alt="Logo" class="w-16 h-16 mx-auto mb-2">
                <h1 class="text-lg font-bold">SARPRAS</h1>
            </div>

            <nav class="w-full">
                <a href="{{ route('home') }}"
                   class="block px-6 py-3 rounded-lg mb-2 transition-colors {{ request()->routeIs('home') ? 'bg-blue-700 font-bold' : 'hover:bg-blue-800' }}">
                    <i class="fas fa-home mr-3"></i>Home
                </a>
                <a href="{{ route('users') }}"
                   class="block px-6 py-3 rounded-lg mb-2 transition-colors {{ request()->routeIs('users') ? 'bg-blue-700 font-bold' : 'hover:bg-blue-800' }}">
                    <i class="fas fa-users mr-3"></i>Daftar Pengguna
                </a>
                <a href="{{ route('crud') }}"
                   class="block px-6 py-3 rounded-lg mb-2 transition-colors {{ request()->routeIs('crud') ? 'bg-blue-700 font-bold' : 'hover:bg-blue-800' }}">
                    <i class="fas fa-plus-circle mr-3"></i>Tambah
                </a>
                <a href="{{ route('peminjaman') }}"
                   class="block px-6 py-3 rounded-lg mb-2 transition-colors {{ request()->routeIs('peminjaman') ? 'bg-blue-700 font-bold' : 'hover:bg-blue-800' }}">
                    <i class="fas fa-hand-holding mr-3"></i>Peminjaman
                </a>
                <a href="{{ route('pengembalian') }}"
                   class="block px-6 py-3 rounded-lg mb-2 transition-colors {{ request()->routeIs('pengembalian') ? 'bg-blue-700 font-bold' : 'hover:bg-blue-800' }}">
                    <i class="fas fa-undo-alt mr-3"></i>Pengembalian
                </a>
                <a href="{{ route('laporan') }}"
                   class="block px-6 py-3 rounded-lg mb-2 transition-colors {{ request()->routeIs('laporan') ? 'bg-blue-700 font-bold' : 'hover:bg-blue-800' }}">
                    <i class="fas fa-file-alt mr-3"></i>Laporan
                </a>
            </nav>
        </div>
    </div>

    <!-- Main Content -->
    <div class="ml-64 p-8">
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="p-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                    <i class="fas fa-undo-alt mr-3 text-blue-600"></i>Daftar Pengajuan Pengembalian
                </h2>

                @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded">
                    {{ session('success') }}
                </div>
                @endif

                @if(session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded">
                    {{ session('error') }}
                </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-blue-800 text-white">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">No</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Peminjam</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Barang</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Jumlah</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Tgl Pinjam</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Tgl Pengajuan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Deskripsi</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Foto</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Disetujui Oleh</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Tgl Disetujui</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 text-gray-700">
                            @forelse($pengembalians as $i => $pengajuan)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">{{ $i + 1 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $pengajuan->peminjaman->user->username }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $pengajuan->peminjaman->items->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $pengajuan->peminjaman->jumlah_pinjam }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ \Carbon\Carbon::parse($pengajuan->peminjaman->tanggal_pinjam)->format('d-m-Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $pengajuan->tanggal_pengajuan_kembali ? \Carbon\Carbon::parse($pengajuan->tanggal_pengajuan_kembali)->format('d-m-Y H:i') : '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $pengajuan->deskripsi_pengembalian ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($pengajuan->foto_pengembalian)
                                    <img src="{{ asset('storage/' . $pengajuan->foto_pengembalian) }}" alt="Foto Pengembalian" class="h-12 w-12 object-cover rounded">
                                    @else
                                    -
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap capitalize">{{ str_replace('_', ' ', $pengajuan->status_pengembalian) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $pengajuan->returnedBy?->username ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $pengajuan->tanggal_disetujui ? \Carbon\Carbon::parse($pengajuan->tanggal_disetujui)->format('d-m-Y H:i') : '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($pengajuan->status_pengembalian === 'diajukan')
                                    <div class="flex space-x-2">
                                        <form method="POST" action="{{ route('pengembalian.approve', $pengajuan->id) }}">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white py-1 px-3 rounded text-sm flex items-center">
                                                <i class="fas fa-check mr-1"></i> Setujui
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('pengembalian.reject', $pengajuan->id) }}">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white py-1 px-3 rounded text-sm flex items-center">
                                                <i class="fas fa-times mr-1"></i> Tolak
                                            </button>
                                        </form>
                                    </div>
                                    @else
                                    <span class="text-gray-400 text-sm">Tidak ada aksi</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="12" class="px-6 py-4 text-center text-gray-500">Belum ada data pengajuan pengembalian</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
