<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengguna</title>
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
                    <i class="fas fa-users mr-3"></i>Users
                </a>
                <a href="{{ route('crud') }}"
                   class="block px-6 py-3 rounded-lg mb-2 transition-colors {{ request()->routeIs('crud') ? 'bg-blue-700 font-bold' : 'hover:bg-blue-800' }}">
                    <i class="fas fa-plus-circle mr-3"></i>Create
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
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800 flex items-center">
                        <i class="fas fa-user-friends mr-3 text-blue-600"></i>Daftar Pengguna
                    </h2>
                    <button onclick="document.getElementById('addUserModal').classList.remove('hidden')"
                            class="bg-blue-700 hover:bg-blue-800 text-white font-semibold py-2 px-4 rounded-lg transition-colors">
                        <i class="fas fa-plus mr-2"></i>Tambah User
                    </button>
                </div>

                @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded">
                    <p>{{ session('success') }}</p>
                </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-blue-800 text-white">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">No</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Nama</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Terdaftar</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 text-gray-700">
                            @forelse ($users as $i => $user)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">{{ $i + 1 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $user->username }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $user->email }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $user->created_at->format('d M Y') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-gray-500">Belum ada data pengguna</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Add User Modal -->
    <div id="addUserModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold text-gray-800">Tambah User Baru</h3>
                <button onclick="document.getElementById('addUserModal').classList.add('hidden')"
                        class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Username</label>
                    <input type="text" name="username" placeholder="Username" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Email</label>
                    <input type="email" name="email" placeholder="Email" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 mb-2">Password</label>
                    <input type="password" name="password" placeholder="Password" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="flex justify-end">
                    <button type="button" onclick="document.getElementById('addUserModal').classList.add('hidden')"
                            class="mr-2 px-4 py-2 text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 transition-colors">
                        Batal
                    </button>
                    <button type="submit"
                            class="px-4 py-2 bg-blue-700 text-white rounded-lg hover:bg-blue-800 transition-colors">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Close modal when clicking outside
        document.getElementById('addUserModal').addEventListener('click', function(e) {
            if (e.target === this) {
                this.classList.add('hidden');
            }
        });
    </script>
</body>
</html>
