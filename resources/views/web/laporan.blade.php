<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #bbddff;
            color: white;
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
            font-weight: bold;
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
            max-width: 1200px;
        }

        .card {
            background: white;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .card h2 {
            margin: 10px;
            color: black;
        }

        .sidebar h2 {
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

        tbody {
            color: black
        }

        th {
            background: #1e3a8a;
            color: white;
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
        <a href="{{ route('laporan') }}" class="{{ request()->routeIs('laporan') ? 'active' : '' }}">Laporan</a>
    </div>

    <div class="main-content">
        <div class="card">
            <h2>Laporan Peminjaman & Pengembalian</h2>


            <hr>

            <h3 style="color: black">Data Peminjaman</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Nama Peminjam</th>
                            <th>Item</th>
                            <th>Jumlah</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                <tbody>
                    @foreach($semuaPeminjaman as $pinjam)
                    <tr>
                        <td>{{ $pinjam->user->username }}</td>
                        <td>{{ $pinjam->items->name }}</td>
                        <td>{{ $pinjam->jumlah_pinjam }}</td>
                        <td>{{ $pinjam->status }}</td>
                        <td>{{ $pinjam->created_at->format('d M Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <h4 style="color: black">Total Peminjaman: {{ $totalPeminjaman }}</h4>

            <hr>

            <h3 style="color: black">Data Pengembalian</h3>
            <table>
                <thead>
                    <tr>
                        <th>Nama Peminjam</th>
                        <th>Item</th>
                        <th>Jumlah</th>
                        <th>Status Pengembalian</th>
                        <th>Tanggal Disetujui</th>
                    </tr>
                </thead>
            <tbody>
                @foreach($semuaPengembalian as $kembali)
                <tr>
                    <td>{{ $kembali->peminjaman->user->username }}</td>
                    <td>{{ $kembali->peminjaman->items->name }}</td>
                    <td>{{ $kembali->peminjaman->jumlah_pinjam }}</td>
                    <td>{{ $kembali->status_pengembalian }}</td>
                    <td>{{ $kembali->tanggal_disetujui ? \Carbon\Carbon::parse($kembali->tanggal_disetujui)->format('d M Y') : '-' }}</td>
                </tr>
                @endforeach
            </tbody>
            </table>
            <h4 style="color: black">Total Pengembalian: {{ $totalPengembalian }}</h4>

        </div>
    </div>
</body>
</html>
