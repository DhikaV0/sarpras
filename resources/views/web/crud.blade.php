<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>CRUD with Modal</title>
  <style>
    body {
        font-family: Arial, sans-serif;
        background: #bbddff;
        margin: 0;
    }

    .nav {
        background-color: #002793;
        padding: 30px;
        text-align: center;
        position: sticky;
        top: 0;
        z-index: 999;
        margin-bottom: 50px;
    }

    .nav a {
        color: white;
        text-decoration: none;
        font-size: 18px;
        font-weight: bold;
        margin-left: 1500px;
        padding: 15px 20px;
    }

    .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        height: 100%;
        width: 220px;
        background: #002793;
        padding-top: 20px;
        box-shadow: 2px 0 8px rgba(0,0,0,0.1);
        display: flex;
        flex-direction: column;
        z-index: 1000;
    }

    .sidebar a {
        padding: 15px 20px;
        text-decoration: none;
        color: white;
        font-weight: bold;
        display: block;
        transition: background 0.3s;
    }

    .sidebar a:hover {
        background: #2563eb;
    }

    .sidebar a.active {
        background: #3700ff;
    }

    .logo-container {
        background: #85a6ff;
        padding-right: 20px;
        padding-left: 20px;
        padding-bottom: 10px;
        margin: 0 auto;
        border-radius: 15px;
        width: 120px;
        text-align: center;
    }

    .logo-container img {
        width: 60px;
        height: 60px;
        display: block;
        margin: 0 auto 8px;
    }

    .sidebar h1 {
        color: white;
        text-align: center;
        font-size: 20px;
    }

    .item-image {
        max-width: 50px;
        max-height: 50px;
        width: auto;
        height: auto;
    }

    .sidebar img {
        width: 100px;
        height: auto;
        margin: 0 auto;
        display: block;
    }

    .main-content {
        margin-left: 250px;
        padding: 30px;
        max-width: 1200px;
    }

    .card {
        background: white;
        padding: 20px;
        margin-bottom: 20px;
        border-radius: 12px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    h2 {
        margin-top: 0;
    }

    .table-wrap {
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 15px;
    }

    th, td {
        border: 1px solid #ccc;
        padding: 10px 15px;
        text-align: left;
    }

    th {
        background: #1e3a8a;
        color: white;
    }

    .action-btn {
        padding: 6px 12px;
        margin: 2px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
    }

    .btn-edit {
        background: #1d4ed8;
        color: white;
    }

    .btn-delete {
        background: #dc2626;
        color: white;
    }

    button {
        background: #2563eb;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-weight: bold;
        margin-top: 10px;
    }

    .success-message {
        color: green;
        margin-top: 10px;
    }

    .modal {
        display: none;
        position: fixed;
        z-index: 100;
        left: 0; top: 0;
        width: 100%; height: 100%;
        background: rgba(0,0,0,0.5);
        justify-content: center;
        align-items: center;
    }

    .modal-content {
        background: white;
        padding: 30px;
        border-radius: 12px;
        width: 90%;
        max-width: 500px;
        position: relative;
    }

    .close-btn {
        position: absolute;
        right: 15px;
        top: 10px;
        font-size: 24px;
        background: none;
        border: none;
        cursor: pointer;
    }

    .close-modal-btn {
        position: absolute;
        right: 15px;
        top: 10px;
        font-size: 24px;
        background: none;
        border: none;
        cursor: pointer;
    }

    .modal form input,
    .modal form select,
    .modal form button {
        width: 100%;
        margin: 10px 0;
        padding: 10px;
        border-radius: 8px;
        border: 1px solid #ccc;
        font-size: 16px;
    }

    .modal form button {
        background: #1e3a8a;
        color: white;
        font-weight: bold;
    }
  </style>
</head>
<body>
    <div class="nav">
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
    </div>
    <div class="sidebar">
        <div class="logo-container">
            <img src="https://smktarunabhakti.net/wp-content/uploads/2020/07/logotbvector-copy.png" alt="">
            <h1>SARPRAS</h1>
        </div>
        <a style="margin-top: 50px;" href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
        <a href="{{ route('users') }}" class="{{ request()->routeIs('users') ? 'active' : '' }}">Users</a>
        <a href="{{ route('crud') }}" class="{{ request()->routeIs('crud') ? 'active' : '' }}">Create</a>
        <a href="{{ route('peminjaman') }}" class="{{ request()->routeIs('peminjaman') ? 'active' : '' }}">Peminjaman</a>
        <a href="{{ route('pengembalian') }}" class="{{ request()->routeIs('pengembalian') ? 'active' : '' }}">Pengembalian</a>
    </div>

<div class="main-content">
    <div class="card">
        <h2>Daftar Kategori</h2>
        <button class="open-modal-btn" data-modal="addCategoryModal">Tambah Kategori</button>

        @if(session('success') && request()->routeIs('category.*'))
            <p class="success-message">{{ session('success') }}</p>
        @endif

        <div class="table-wrap">
            <table>
                <thead>
                    <tr><th>No</th><th>Nama</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                    @forelse($categories as $i => $cat)
                    <tr>
                        <td>{{ $i+1 }}</td>
                        <td>{{ $cat->name }}</td>
                        <td>
                            <button class="action-btn btn-edit open-modal-btn" data-modal="editCategoryModal" data-id="{{ $cat->id }}" data-name="{{ $cat->name }}">Ubah</button>
                            <form method="POST" action="{{ route('category.delete', $cat->id) }}" style="display:inline">
                                @csrf @method('DELETE')
                                <button class="action-btn btn-delete" onclick="return confirm('Yakin?')" type="submit">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" style="text-align: center;">Tidak ada kategori</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="card">
        <h2>Daftar Barang</h2>
        <button class="open-modal-btn" data-modal="addItemModal">Tambah Item</button>

        @if(session('success') && request()->routeIs('item.*'))
            <p class="success-message">{{ session('success') }}</p>
        @endif

        <div class="table-wrap">
            <table>
                <thead>
                    <tr><th>No</th><th>Nama</th><th>Stok</th><th>Gambar</th><th>Kategori</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                    @forelse($items as $i => $it)
                    <tr>
                        <td>{{ $i+1 }}</td>
                        <td>{{ $it->name }}</td>
                        <td>{{ $it->stok }}</td>
                        <td>
                            @if($it->foto)
                            <img src="{{ asset('storage/' . $it->foto) }}" alt="{{ $it->name }}" class="item-image">
                            @else
                                Tidak ada gambar
                            @endif
                        </td>
                        <td>{{ $it->category->name }}</td>
                        <td>
                            <button class="action-btn btn-edit open-modal-btn" data-modal="editItemModal" data-id="{{ $it->id }}" data-name="{{ $it->name }}" data-stok="{{ $it->stok }}" data-category-id="{{ $it->category_id }}">Ubah</button>
                            <form method="POST" action="{{ route('item.delete', $it->id) }}" style="display:inline">
                                @csrf @method('DELETE')
                                <button class="action-btn btn-delete" onclick="return confirm('Yakin?')" type="submit">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align: center;">Tidak ada barang</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div id="modal-container" class="modal" style="display: none;">
        <div id="modal-content" class="modal-content">
            <span class="close-modal-btn" style="cursor: pointer;">&times;</span>
            <div id="modal-body">
            </div>
        </div>
    </div>

    <template id="addCategoryModalTemplate">
        <h2>Tambah Kategori</h2>
        <form method="POST" action="{{ route('category.store') }}">
            @csrf
            <input type="text" name="name" placeholder="Nama kategori" required>
            <button type="submit">Simpan</button>
        </form>
    </template>

    <template id="addItemModalTemplate">
        <h2>Tambah Item</h2>
        <form method="POST" action="{{ route('item.store') }}" enctype="multipart/form-data">
            @csrf
            <input type="text" name="name" placeholder="Nama item" required>
            <input type="number" name="stok" placeholder="Stok" required>
            <select name="category_id" required>
                <option value="">Pilih Kategori</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
            </select>
            <input type="file" name="foto" accept="image/*">
            <button type="submit">Simpan</button>
        </form>
    </template>

    <template id="editCategoryModalTemplate">
        <h2>Ubah Kategori</h2>
        <form method="POST" action="">
            @csrf
            @method('PUT')
            <input type="hidden" name="id">
            <input type="text" name="name" required>
            <button type="submit">Update</button>
        </form>
    </template>

    <template id="editItemModalTemplate">
        <h2>Ubah Item</h2>
        <form method="POST" action="" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="id">
            <input type="text" name="name" required>
            <input type="number" name="stok" required>
            <select name="category_id" required>
                <option value="">Pilih Kategori</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
            </select>
            <input type="file" name="foto" accept="image/*">
            <button type="submit">Update</button>
        </form>
    </template>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modalContainer = document.getElementById('modal-container');
        const modalBody = document.getElementById('modal-body');
        const closeModalBtn = document.querySelector('.close-modal-btn');
        const openModalButtons = document.querySelectorAll('.open-modal-btn');
        const addCategoryModalTemplate = document.getElementById('addCategoryModalTemplate');
        const addItemModalTemplate = document.getElementById('addItemModalTemplate');
        const editCategoryModalTemplate = document.getElementById('editCategoryModalTemplate');
        const editItemModalTemplate = document.getElementById('editItemModalTemplate');

        function openModal(modalId, data = {}) {
            let template;
            modalBody.innerHTML = ''; // Bersihkan konten modal sebelumnya
            modalContainer.style.display = 'flex';

            switch (modalId) {
                case 'addCategoryModal':
                    template = addCategoryModalTemplate.content.cloneNode(true);
                    modalBody.appendChild(template);
                    break;
                case 'addItemModal':
                    template = addItemModalTemplate.content.cloneNode(true);
                    modalBody.appendChild(template);
                    break;
                case 'editCategoryModal':
                    template = editCategoryModalTemplate.content.cloneNode(true);
                    const editCategoryForm = template.querySelector('form');
                    editCategoryForm.action = `/category/${data.id}`;
                    template.querySelector('input[name="id"]').value = data.id;
                    template.querySelector('input[name="name"]').value = data.name;
                    modalBody.appendChild(template);
                    break;
                case 'editItemModal':
                    template = editItemModalTemplate.content.cloneNode(true);
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

            const form = modalBody.querySelector('form');
            if (form) {
                form.addEventListener('submit', function(event) {
                });
            }
        }

        function closeModal() {
            modalContainer.style.display = 'none';
        }

        // Event listeners untuk tombol buka modal
        openModalButtons.forEach(button => {
            button.addEventListener('click', function() {
                const modalId = this.dataset.modal;
                let data = {};
                if (this.dataset.id) {
                    data.id = this.dataset.id;
                }
                if (this.dataset.name) {
                    data.name = this.dataset.name;
                }
                if (this.dataset.stok) {
                    data.stok = this.dataset.stok;
                }
                if (this.dataset.categoryId) {
                    data.categoryId = this.dataset.categoryId;
                }
                openModal(modalId, data);
            });
        });

        // Event listener untuk tombol close modal
        if (closeModalBtn) {
            closeModalBtn.addEventListener('click', closeModal);
        }

        // Menutup modal jika area di luar modal diklik
        window.addEventListener('click', function(event) {
            if (event.target === modalContainer) {
                closeModal();
            }
        });
    });
    </script>
</body>
</html>
