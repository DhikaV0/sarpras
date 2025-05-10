<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Peminjaman</title>
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

        .sidebar a:hover {
            background: #2563eb;
        }

        .sidebar a.active {
            background: #6293ff;
        }

        .sidebar h1 {
            color: white;
            text-align: center;
            margin-bottom: 30px;
            font-size: 20px;
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
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
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

        .close-btn,
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
            background: #2563eb;
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
        <img src="https://smktarunabhakti.net/wp-content/uploads/2020/07/logotbvector-copy.png" alt="">
        <h1>SARPRAS</h1>
        <a href="{{ route('home') }}">Home</a>
        <a href="{{ route('users') }}">Users</a>
        <a href="{{ route('crud') }}">Create</a>
        <a href="{{ route('peminjaman') }}" class="active">Peminjaman</a>
    </div>

    <div class="main-content">
        <div class="card">
            <h2>Daftar Peminjaman</h2>
            <button class="open-modal-btn" data-modal="addPeminjamanModal">Tambah Peminjaman</button>

            @if(session('success'))
                <p class="success-message">{{ session('success') }}</p>
            @endif
            @if(session('error'))
                <p class="error-message">{{ session('error') }}</p>
            @endif

            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Barang</th>
                            <th>Jumlah</th>
                            <th>Tanggal Pinjam</th>
                            <th>Tanggal Kembali</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($peminjaman as $i => $pinjam)
                            <tr>
                                <td>{{ $i+1 }}</td>
                                <td>{{ $pinjam->item->name }}</td>
                                <td>{{ $pinjam->jumlah_pinjam }}</td>
                                <td>{{ $pinjam->tanggal_pinjam }}</td>
                                <td>{{ $pinjam->tanggal_kembali ?? '-' }}</td> {{-- Tampilkan '-' jika belum kembali --}}
                                <td>{{ $pinjam->status }}</td>
                                <td>
                                    <button class="action-btn btn-edit open-modal-btn" data-modal="editPeminjamanModal"
                                            data-id="{{ $pinjam->id }}"
                                            data-item-id="{{ $pinjam->items_id }}"
                                            data-jumlah="{{ $pinjam->jumlah_pinjam }}"
                                            data-pinjam="{{ $pinjam->tanggal_pinjam }}"
                                            data-kembali="{{ $pinjam->tanggal_kembali }}"
                                            data-status="{{ $pinjam->status }}">Ubah</button>
                                    <form method="POST" action="{{ route('peminjaman.delete', $pinjam->id) }}" style="display:inline">
                                        @csrf @method('DELETE')
                                        <button class="action-btn btn-delete" onclick="return confirm('Yakin?')" type="submit">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8">Belum ada data peminjaman</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="modal-container" class="modal" style="display: none;">
        <div id="modal-content" class="modal-content">
            <span class="close-modal-btn" style="cursor: pointer;">&times;</span>
            <div id="modal-body"></div>
        </div>
    </div>

    <template id="addPeminjamanModalTemplate">
        <h2>Tambah Peminjaman</h2>
        <form method="POST" action="{{ route('peminjaman.store') }}">
            @csrf
            <select name="item_id" required>
                <option value="">Pilih Barang</option>
                @foreach($items as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </select>
            <input type="number" name="jumlah_pinjam" placeholder="Jumlah" required>
            <input type="date" name="tanggal_pinjam" required>
            <input type="date" name="tanggal_kembali" placeholder="Tanggal Kembali (Opsional)">
            <button type="submit">Simpan</button>
        </form>
    </template>

    <template id="editPeminjamanModalTemplate">
        <h2>Ubah Status Peminjaman</h2>
        <form method="POST" action="">
            @csrf @method('PUT')
            <input type="hidden" name="id">
            <p>Peminjam: <span data-user-name></span></p>
            <p>Barang: <span data-item-name></span></p>
            <p>Jumlah Pinjam: <span data-jumlah></span></p>
            <p>Tanggal Pinjam: <span data-pinjam></span></p>
            <input type="date" name="tanggal_kembali" required>
            <select name="status" required>
                <option value="pinjam">Dipinjam</option>
                <option value="kembali">Dikembalikan</option>
            </select>
            <button type="submit">Update</button>
        </form>
    </template>

    <script>
    // Modal JS
        const modalContainer = document.getElementById('modal-container');
        const modalContent = document.getElementById('modal-body');

        document.querySelectorAll('.open-modal-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const modalType = btn.dataset.modal;
                const template = document.getElementById(modalType + 'Template');
                modalContent.innerHTML = template.innerHTML;
                modalContainer.style.display = 'flex';

                if (modalType === 'editPeminjamanModal') {
                    const form = modalContent.querySelector('form');
                    form.action = `/peminjaman/update/${btn.dataset.id}`;
                    form.querySelector('[name="id"]').value = btn.dataset.id;
                    form.querySelector('[name="tanggal_pinjam"]').value = btn.dataset.pinjam;
                    form.querySelector('[name="tanggal_kembali"]').value = btn.dataset.kembali === 'null' ? '' : btn.dataset.kembali;
                    form.querySelector('[name="status"]').value = btn.dataset.status;

                    // Ambil nama user dan item dari data yang mungkin sudah ada di $peminjaman
                    const peminjamanData = @json($peminjaman->keyBy('id'));
                    const data = peminjamanData[btn.dataset.id];
                    if (data) {
                        form.querySelector('[data-user-name]').textContent = data.user.name;
                        form.querySelector('[data-item-name]').textContent = data.item.name;
                        form.querySelector('[data-jumlah]').textContent = data.jumlah_pinjam;
                        form.querySelector('[data-pinjam]').textContent = data.tanggal_pinjam;
                    }
                }
            });
        });

        document.querySelector('.close-modal-btn').addEventListener('click', () => {
            modalContainer.style.display = 'none';
        });
    </script>
</body>
</html>
