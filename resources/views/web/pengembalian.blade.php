<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pengembalian Barang</title>
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

        .sidebar img {
            width: 100px;
            height: auto;
            margin: 0 auto;
            display: block;
        }

        .main-content {
            margin-left: 250px;
            padding: 30px;
            max-width: 1400px;
        }

        .card {
            background: white;
            padding: 30px;
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

        .btn-approve {
            background: #30ff4f;
            color: white;
        }

        .btn-reject {
            background: #dc2626;
            color: white;
        }

        .btn-return-approve {
            background: #10B981; /* Hijau yang berbeda */
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

        .error-message {
            color: red;
            margin-top: 10px;
        }

        .foto-preview {
            max-width: 100px;
            max-height: 100px;
            object-fit: cover;
            border-radius: 4px;
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
        <a style="margin-top: 50px;" href="{{ route('home') }}">Home</a>
        <a href="{{ route('users') }}" class="{{ request()->routeIs('users') ? 'active' : '' }}">Users</a>
        <a href="{{ route('crud') }}" class="{{ request()->routeIs('crud') ? 'active' : '' }}">Create</a>
        <a href="{{ route('peminjaman') }}" class="{{ request()->routeIs('peminjaman') ? 'active' : '' }}">Peminjaman</a>
        <a href="{{ route('pengembalian') }}" class="{{ request()->routeIs('pengembalian') ? 'active' : '' }}">Pengembalian</a>
    </div>

    <div class="main-content">
        <div class="card">
            <h2>Daftar Pengajuan Pengembalian</h2>

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
                            <th>Peminjam</th>
                            <th>Barang</th>
                            <th>Jumlah Pinjam</th>
                            <th>Tanggal Pinjam</th> <th>Tanggal Pengajuan Kembali</th>
                            <th>Deskripsi Pengembalian</th>
                            <th>Foto Pengembalian</th>
                            <th>Status Pengajuan</th> <th>Disetujui Oleh</th>
                            <th>Tanggal Disetujui</th> <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pengembalians as $i => $pengajuan)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $pengajuan->peminjaman->user->username }}</td>
                                <td>{{ $pengajuan->peminjaman->items->name }}</td>
                                <td>{{ $pengajuan->peminjaman->jumlah_pinjam }}</td>
                                <td>{{ \Carbon\Carbon::parse($pengajuan->peminjaman->tanggal_pinjam)->format('d-m-Y') }}</td>

                                <td>{{ $pengajuan->tanggal_pengajuan_kembali ? \Carbon\Carbon::parse($pengajuan->tanggal_pengajuan_kembali)->format('d-m-Y H:i') : '-' }}</td>
                                <td>{{ $pengajuan->deskripsi_pengembalian ?? '-' }}</td>
                                <td>
                                    @if($pengajuan->foto_pengembalian)
                                        <img src="{{ asset('storage/' . $pengajuan->foto_pengembalian) }}" alt="Foto Pengembalian" class="foto-preview" width="50">
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ ucfirst(str_replace('_', ' ', $pengajuan->status_pengembalian)) }}</td>
                                <td>{{ $pengajuan->returnedBy?->username ?? '-' }}</td>
                                <td>{{ $pengajuan->tanggal_disetujui ? \Carbon\Carbon::parse($pengajuan->tanggal_disetujui)->format('d-m-Y H:i') : '-' }}</td>
                                <td>
                                    @if($pengajuan->status_pengembalian === 'diajukan')
                                        <form method="POST" action="{{ route('pengembalian.approve', $pengajuan->id) }}" style="display:inline">
                                            @csrf
                                            @method('PUT')
                                            <button class="action-btn btn-return-approve" type="submit">Setujui</button>
                                        </form>
                                        <form method="POST" action="{{ route('pengembalian.reject', $pengajuan->id) }}" style="display:inline">
                                            @csrf
                                            @method('PUT')
                                            <button class="action-btn btn-reject" type="submit">Tolak</button>
                                        </form>
                                    @else
                                        <p style="opacity: 0.5; font-size: 12px;">Tidak Ada Aksi</p>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11">Belum ada data pengajuan pengembalian.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
