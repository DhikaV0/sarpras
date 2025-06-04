<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
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

        </div>
    </div>

    <!-- Main Content -->
    <div class="ml-64 p-8">
        <!-- Items Card -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden mb-8">
            <div class="p-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                    <i class="fas fa-boxes mr-3 text-blue-600"></i>Daftar Barang
                </h2>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-blue-800 text-white">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">No</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Nama Barang</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Stok</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Gambar</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Kategori</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 text-gray-700">
                            @forelse($items as $i => $it)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">{{ $i+1 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $it->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $it->stok }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($it->foto)
                                    <img src="{{ asset('storage/' . $it->foto) }}" alt="{{ $it->name }}" class="h-12 w-12 object-cover rounded">
                                    @else
                                    <span class="text-gray-400">Tidak ada gambar</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $it->category->name }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">Tidak ada barang</td>
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
