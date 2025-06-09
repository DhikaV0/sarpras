<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create</title>
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
                    <i class="fas fa-plus-circle mr-3"></i>Tanbah
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
        <!-- Categories Card -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden mb-8">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800 flex items-center">
                        <i class="fas fa-tags mr-3 text-blue-600"></i>Daftar Kategori
                    </h2>
                    <button class="open-modal-btn bg-blue-700 hover:bg-blue-800 text-white font-semibold py-2 px-4 rounded-lg transition-colors"
                            data-modal="addCategoryModal">
                        <i class="fas fa-plus mr-2"></i>Tambah Kategori
                    </button>
                </div>

                @if(session('success') && request()->routeIs('category.*'))
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
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 text-gray-700">
                            @forelse($categories as $i => $cat)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">{{ $i+1 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $cat->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap flex space-x-2">
                                    <button class="open-modal-btn bg-blue-600 hover:bg-blue-700 text-white py-1 px-3 rounded text-sm"
                                            data-modal="editCategoryModal"
                                            data-id="{{ $cat->id }}"
                                            data-name="{{ $cat->name }}">
                                        <i class="fas fa-edit mr-1"></i>Ubah
                                    </button>
                                    <form method="POST" action="{{ route('category.delete', $cat->id) }}" onsubmit="return confirm('Yakin ingin menghapus?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white py-1 px-3 rounded text-sm">
                                            <i class="fas fa-trash mr-1"></i>Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="px-6 py-4 text-center text-gray-500">Tidak ada kategori</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Items Card -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800 flex items-center">
                        <i class="fas fa-boxes mr-3 text-blue-600"></i>Daftar Barang
                    </h2>
                    <button class="open-modal-btn bg-blue-700 hover:bg-blue-800 text-white font-semibold py-2 px-4 rounded-lg transition-colors"
                            data-modal="addItemModal">
                        <i class="fas fa-plus mr-2"></i>Tambah Item
                    </button>
                </div>

                @if(session('success') && request()->routeIs('item.*'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded">
                    <p>{{ session('success') }}</p>
                </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-blue-800 text-white">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">No</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Nama Barang</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Stok</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Gambar</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Kategori</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Aksi</th>
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
                                <td class="px-6 py-4 whitespace-nowrap flex space-x-2">
                                    <button class="open-modal-btn bg-blue-600 hover:bg-blue-700 text-white py-1 px-3 rounded text-sm"
                                            data-modal="editItemModal"
                                            data-id="{{ $it->id }}"
                                            data-name="{{ $it->name }}"
                                            data-stok="{{ $it->stok }}"
                                            data-category-id="{{ $it->category_id }}">
                                        <i class="fas fa-edit mr-1"></i>Ubah
                                    </button>
                                    <form method="POST" action="{{ route('item.delete', $it->id) }}" onsubmit="return confirm('Yakin ingin menghapus?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white py-1 px-3 rounded text-sm">
                                            <i class="fas fa-trash mr-1"></i>Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500">Tidak ada barang</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Container -->
    <div id="modal-container" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div id="modal-content" class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md">
            <button class="close-modal-btn absolute top-4 right-4 text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </button>
            <div id="modal-body"></div>
        </div>
    </div>

    <!-- Modal Templates -->
    <template id="addCategoryModalTemplate">
        <h3 class="text-xl font-bold text-gray-800 mb-4">Tambah Kategori</h3>
        <form method="POST" action="{{ route('category.store') }}">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Nama Kategori</label>
                <input type="text" name="name" placeholder="Nama kategori" required
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="flex justify-end">
                <button type="button" class="close-modal-btn mr-2 px-4 py-2 text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 transition-colors">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 bg-blue-700 text-white rounded-lg hover:bg-blue-800 transition-colors">
                    Simpan
                </button>
            </div>
        </form>
    </template>

    <template id="addItemModalTemplate">
        <h3 class="text-xl font-bold text-gray-800 mb-4">Tambah Item</h3>
        <form method="POST" action="{{ route('item.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Nama Item</label>
                <input type="text" name="name" placeholder="Nama item" required
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Stok</label>
                <input type="number" name="stok" placeholder="Stok" required
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Kategori</label>
                <select name="category_id" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Pilih Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-6">
                <label class="block text-gray-700 mb-2">Gambar</label>
                <input type="file" name="foto" accept="image/*"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="flex justify-end">
                <button type="button" class="close-modal-btn mr-2 px-4 py-2 text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 transition-colors">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 bg-blue-700 text-white rounded-lg hover:bg-blue-800 transition-colors">
                    Simpan
                </button>
            </div>
        </form>
    </template>

    <template id="editCategoryModalTemplate">
        <h3 class="text-xl font-bold text-gray-800 mb-4">Ubah Kategori</h3>
        <form method="POST" action="">
            @csrf
            @method('PUT')
            <input type="hidden" name="id">
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Nama Kategori</label>
                <input type="text" name="name" required
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="flex justify-end">
                <button type="button" class="close-modal-btn mr-2 px-4 py-2 text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 transition-colors">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 bg-blue-700 text-white rounded-lg hover:bg-blue-800 transition-colors">
                    Update
                </button>
            </div>
        </form>
    </template>

    <template id="editItemModalTemplate">
        <h3 class="text-xl font-bold text-gray-800 mb-4">Ubah Item</h3>
        <form method="POST" action="" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="id">
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Nama Item</label>
                <input type="text" name="name" required
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Stok</label>
                <input type="number" name="stok" required
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Kategori</label>
                <select name="category_id" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Pilih Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-6">
                <label class="block text-gray-700 mb-2">Gambar</label>
                <input type="file" name="foto" accept="image/*"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="flex justify-end">
                <button type="button" class="close-modal-btn mr-2 px-4 py-2 text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 transition-colors">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 bg-blue-700 text-white rounded-lg hover:bg-blue-800 transition-colors">
                    Update
                </button>
            </div>
        </form>
    </template>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modalContainer = document.getElementById('modal-container');
            const modalBody = document.getElementById('modal-body');
            const closeModalBtn = document.querySelector('.close-modal-btn');
            const openModalButtons = document.querySelectorAll('.open-modal-btn');
            const templates = {
                addCategoryModal: document.getElementById('addCategoryModalTemplate'),
                addItemModal: document.getElementById('addItemModalTemplate'),
                editCategoryModal: document.getElementById('editCategoryModalTemplate'),
                editItemModal: document.getElementById('editItemModalTemplate')
            };

            function openModal(modalId, data = {}) {
                let template;
                modalBody.innerHTML = '';
                modalContainer.classList.remove('hidden');

                switch (modalId) {
                    case 'addCategoryModal':
                        template = templates.addCategoryModal.content.cloneNode(true);
                        modalBody.appendChild(template);
                        break;
                    case 'addItemModal':
                        template = templates.addItemModal.content.cloneNode(true);
                        modalBody.appendChild(template);
                        break;
                    case 'editCategoryModal':
                        template = templates.editCategoryModal.content.cloneNode(true);
                        const editCategoryForm = template.querySelector('form');
                        editCategoryForm.action = `/category/${data.id}`;
                        template.querySelector('input[name="id"]').value = data.id;
                        template.querySelector('input[name="name"]').value = data.name;
                        modalBody.appendChild(template);
                        break;
                    case 'editItemModal':
                        template = templates.editItemModal.content.cloneNode(true);
                        const editItemForm = template.querySelector('form');
                        editItemForm.action = `/item/${data.id}`;
                        template.querySelector('input[name="id"]').value = data.id;
                        template.querySelector('input[name="name"]').value = data.name;
                        template.querySelector('input[name="stok"]').value = data.stok;
                        const categorySelect = template.querySelector('select[name="category_id"]');
                        Array.from(categorySelect.options).forEach(option => {
                            if (parseInt(option.value) === parseInt(data.categoryId)) {
                                option.selected = true;
                            }
                        });
                        modalBody.appendChild(template);
                        break;
                }

                // Add event listener to close button inside the modal
                const closeBtn = modalBody.querySelector('.close-modal-btn');
                if (closeBtn) {
                    closeBtn.addEventListener('click', closeModal);
                }
            }

            function closeModal() {
                modalContainer.classList.add('hidden');
            }

            // Event listeners for open modal buttons
            openModalButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const modalId = this.dataset.modal;
                    let data = {};
                    if (this.dataset.id) data.id = this.dataset.id;
                    if (this.dataset.name) data.name = this.dataset.name;
                    if (this.dataset.stok) data.stok = this.dataset.stok;
                    if (this.dataset.categoryId) data.categoryId = this.dataset.categoryId;
                    openModal(modalId, data);
                });
            });

            // Event listener for main close modal button
            if (closeModalBtn) {
                closeModalBtn.addEventListener('click', closeModal);
            }

            // Close modal when clicking outside
            modalContainer.addEventListener('click', function(e) {
                if (e.target === this) {
                    closeModal();
                }
            });
        });
    </script>
</body>
</html>
