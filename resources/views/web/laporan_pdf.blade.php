<!DOCTYPE html>
<html>
<head>
    <title>Laporan PDF</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background-color: #eee; }
    </style>
</head>
<body>
    <h2>Laporan Barang</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Stok</th>
                <th>Dipinjam</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $i => $item)
            <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->stok ?? 0 }}</td>
                <td>{{ $item->jumlah_dipinjam ?? 0 }}</td>
                <td>{{ ($item->stok ?? 0) + ($item->jumlah_dipinjam ?? 0) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Laporan Peminjaman</h2>
    <table>
        <thead>
            <tr>
                <th>Nama</th>
                <th>Barang</th>
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
                <td>{{ $pinjam->created_at->format('d-m-Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Laporan Pengembalian</h2>
    <table>
        <thead>
            <tr>
                <th>Nama</th>
                <th>Barang</th>
                <th>Jumlah</th>
                <th>Status</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($semuaPengembalian as $kembali)
            <tr>
                <td>{{ $kembali->peminjaman->user->username }}</td>
                <td>{{ $kembali->peminjaman->items->name }}</td>
                <td>{{ $kembali->peminjaman->jumlah_pinjam }}</td>
                <td>{{ $kembali->status_pengembalian }}</td>
                <td>{{ \Carbon\Carbon::parse($kembali->tanggal_disetujui)->format('d-m-Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
