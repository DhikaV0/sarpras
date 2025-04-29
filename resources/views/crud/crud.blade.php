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
        padding: 20px;
    }
    .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        height: 100%;
        width: 220px;
        background: #1e3a8a;
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
    .img {
        width: 70px;
        height: 70px;
        margin-right: 20px;
    }
    .sidebar a:hover {
        background: #2563eb;
    }
    .sidebar h1 {
        color: white;
        text-align: center;
        margin-bottom: 30px;
        font-size: 22px;
    }
    .main-content {
        margin-left: 240px;
        padding: 20px;
    }
    .container {
        width: 100%;
        max-width: 1100px;
        margin: 0 auto;
        padding: 0 1rem;
        box-sizing: border-box;
    }
    .card {
        background: white;
        padding: 20px;
        border-radius: 12px;
        margin-bottom: 30px;
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

<div class="sidebar">
    <img src="https://smktarunabhakti.net/wp-content/uploads/2020/07/logotbvector-copy.png" alt="">
    <h1>SARPRAS</h1>
    <a href="{{ route('home') }}">Dashboard</a>
    <a href="{{ route('logout') }}">Logout</a>
</div>

<div class="container">
  <!-- CARD KATEGORI -->
  <div class="card">
    <h2>Daftar Kategori</h2>

    <button onclick="openModal('addCategory')">Tambah Kategori</button>

    @if(session('success') && request()->routeIs('category.*'))
      <p class="success-message">{{ session('success') }}</p>
    @endif

    <div class="table-wrap">
      <table>
        <thead>
          <tr><th>No</th><th>Nama</th><th>Aksi</th></tr>
        </thead>
        <tbody>
          @foreach($categories as $i => $cat)
          <tr>
            <td>{{ $i+1 }}</td>
            <td>{{ $cat->name }}</td>
            <td>
              <button class="action-btn btn-edit" onclick="openEditCategory({{ $cat->id }}, '{{ $cat->name }}')">Ubah</button>
              <form method="POST" action="{{ route('category.delete', $cat->id) }}" style="display:inline">
                @csrf @method('DELETE')
                <button class="action-btn btn-delete" onclick="return confirm('Yakin?')" type="submit">Hapus</button>
              </form>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

  <!-- CARD ITEM -->
  <div class="card">
    <h2>Daftar Barang</h2>

    <button onclick="openModal('addItem')">Tambah Item</button>

    @if(session('success') && request()->routeIs('item.*'))
      <p class="success-message">{{ session('success') }}</p>
    @endif

    <div class="table-wrap">
      <table>
        <thead>
          <tr><th>No</th><th>Nama</th><th>Stok</th><th>Kategori</th><th>Aksi</th></tr>
        </thead>
        <tbody>
          @foreach($items as $i => $it)
          <tr>
            <td>{{ $i+1 }}</td>
            <td>{{ $it->name }}</td>
            <td>{{ $it->stok }}</td>
            <td>{{ $it->category->name }}</td>
            <td>
              <button class="action-btn btn-edit" onclick="openEditItem({{ $it->id }}, '{{ $it->name }}', {{ $it->stok }}, {{ $it->category_id }})">Ubah</button>
              <form method="POST" action="{{ route('item.delete', $it->id) }}" style="display:inline">
                @csrf @method('DELETE')
                <button class="action-btn btn-delete" onclick="return confirm('Yakin?')" type="submit">Hapus</button>
              </form>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- MODAL -->
<div class="modal" id="modal">
  <div class="modal-content">
    <button class="close-btn" onclick="closeModal()">×</button>
    <div id="modal-body"></div>
  </div>
</div>

<script>
function openModal(type) {
  const modal = document.getElementById('modal');
  const body = document.getElementById('modal-body');
  modal.style.display = 'flex';

  if (type === 'addCategory') {
    body.innerHTML = `
      <h2>Tambah Kategori</h2>
      <form method="POST" action="{{ route('category.store') }}">
        @csrf
        <input type="text" name="name" placeholder="Nama kategori" required>
        <button type="submit">Simpan</button>
      </form>
    `;
  }
  if (type === 'addItem') {
    body.innerHTML = `
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
        <input type="text" name="deskripsi" placeholder="Deskripsi">
        <input type="file" name="foto" accept="image/*">
        <button type="submit">Simpan</button>
      </form>
    `;
  }
}

function openEditCategory(id, name) {
  const modal = document.getElementById('modal');
  const body = document.getElementById('modal-body');
  modal.style.display = 'flex';

  body.innerHTML = `
    <h2>Ubah Kategori</h2>
    <form method="POST" action="/category/${id}">
      @csrf
      @method('PUT')
      <input type="text" name="name" value="${name}" required>
      <button type="submit">Update</button>
    </form>
  `;
}

function openEditItem(id, name, stok, categoryId) {
  const modal = document.getElementById('modal');
  const body = document.getElementById('modal-body');
  modal.style.display = 'flex';

  let selectOptions = `
    @foreach($categories as $cat)
      <option value="{{ $cat->id }}" \${categoryId == {{ $cat->id }} ? 'selected' : ''}>{{ $cat->name }}</option>
    @endforeach
  `;

  body.innerHTML = `
    <h2>Ubah Item</h2>
    <form method="POST" action="/item/${id}" enctype="multipart/form-data">
      @csrf
      @method('PUT')
      <input type="text" name="name" value="${name}" required>
      <input type="number" name="stok" value="${stok}" required>
      <select name="category_id" required>
        ${selectOptions}
      </select>
      <button type="submit">Update</button>
    </form>
  `;
}

function closeModal() {
  document.getElementById('modal').style.display = 'none';
}
</script>

</body>
</html>
