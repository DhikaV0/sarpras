<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://unpkg.com/xlsx/dist/xlsx.full.min.js"></script>
</head>
<body class="bg-blue-50">
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

    <div class="ml-64 p-8">
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="p-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                    <i class="fas fa-file-alt mr-3 text-blue-600"></i>Laporan Peminjaman & Pengembalian
                </h2>

                <div class="flex gap-4 mb-6">
                    <a href="{{ route('laporan.pdf') }}" class="inline-block bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-md transition-colors duration-300">
                        <i class="fas fa-file-pdf mr-2"></i>Download PDF
                    </a>
                    <button onclick="downloadExcel()" class="inline-block bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-md transition-colors duration-300">
                        <i class="fas fa-file-excel mr-2"></i>Download Excel
                    </button>
                </div>

                <hr class="my-6 border-gray-200">

                <div class="mb-10">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-boxes mr-2"></i>Data Barang
                    </h3>
                    <div class="overflow-x-auto mb-4">
                        <table id="tabel-barang" class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-blue-800 text-white">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">No</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Nama Barang</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Foto</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Jumlah Tersedia</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Jumlah Dipinjam</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Total Barang</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 text-gray-700">
                                @foreach($items as $i => $it)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $i + 1 }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $it->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($it->foto)
                                        <img src="{{ asset('storage/' . $it->foto) }}" alt="{{ $it->name }}" class="h-12 w-12 object-cover rounded">
                                        @else
                                        <span class="text-gray-400">Tidak ada gambar</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $it->stok ?? 0 }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $it->jumlah_dipinjam ?? 0 }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ ($it->jumlah_tersedia ?? 0) + ($it->jumlah_dipinjam ?? 0) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <h4 class="text-lg font-medium text-gray-800">Total Barang: {{ $totalItems }}</h4>
                </div>

                <hr class="my-6 border-gray-200">

                <div class="mb-10">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-hand-holding mr-2"></i>Data Peminjaman
                    </h3>
                    <div class="overflow-x-auto mb-4">
                        <table id="tabel-peminjaman" class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-blue-800 text-white">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Nama Peminjam</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Barang</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Jumlah</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Tanggal</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 text-gray-700">
                                @foreach($semuaPeminjaman as $pinjam)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $pinjam->user->username }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $pinjam->items->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $pinjam->jumlah_pinjam }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap capitalize">{{ $pinjam->status }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $pinjam->created_at->format('d M Y') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <h4 class="text-lg font-medium text-gray-800">Total Peminjaman: {{ $totalPeminjaman }}</h4>
                </div>

                <hr class="my-6 border-gray-200">

                <div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-undo-alt mr-2"></i>Data Pengembalian
                    </h3>
                    <div class="overflow-x-auto mb-4">
                        <table id="tabel-pengembalian" class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-blue-800 text-white">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Nama Peminjam</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Barang</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Jumlah</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Tanggal Disetujui</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 text-gray-700">
                                @foreach($semuaPengembalian as $kembali)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $kembali->peminjaman->user->username }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $kembali->peminjaman->items->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $kembali->peminjaman->jumlah_pinjam }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap capitalize">{{ $kembali->status_pengembalian }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $kembali->tanggal_disetujui ? \Carbon\Carbon::parse($kembali->tanggal_disetujui)->format('d M Y') : '-' }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <h4 class="text-lg font-medium text-gray-800">Total Pengembalian: {{ $totalPengembalian }}</h4>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

<script>
    function downloadExcel() {
        const wb = XLSX.utils.book_new();
        const now = new Date();
        const dateString = now.toISOString().split('T')[0];
        const filename = `Laporan_SARPRAS_${dateString}.xlsx`;

        // --- Data Barang ---
        const excelDataBarang = [
            ['No', 'Nama Barang', 'Jumlah Tersedia', 'Jumlah Dipinjam', 'Total Barang']
        ];
        const rowsBarang = document.querySelectorAll('#tabel-barang tbody tr');
        rowsBarang.forEach((row, index) => {
            // Skip rows with colspan (e.g., "Tidak ada data")
            if(row.querySelector('td[colspan]')) return;
            const cells = row.querySelectorAll('td');
            // Assuming the order of cells matches the headers
            const no = cells[0].textContent.trim();
            const namaBarang = cells[1].textContent.trim();
            const jumlahTersedia = cells[3].textContent.trim(); // Index 3 for Jumlah Tersedia
            const jumlahDipinjam = cells[4].textContent.trim(); // Index 4 for Jumlah Dipinjam
            const totalBarang = cells[5].textContent.trim();   // Index 5 for Total Barang

            excelDataBarang.push([
                parseInt(no),
                namaBarang,
                parseInt(jumlahTersedia),
                parseInt(jumlahDipinjam),
                parseInt(totalBarang)
            ]);
        });
        const wsBarang = XLSX.utils.aoa_to_sheet(excelDataBarang);
        applyHeaderStyleAndWidth(wsBarang);
        XLSX.utils.book_append_sheet(wb, wsBarang, 'Data Barang');

        // --- Data Peminjaman ---
        const excelDataPeminjaman = [
            ['Nama Peminjam', 'Barang', 'Jumlah', 'Status', 'Tanggal']
        ];
        const rowsPeminjaman = document.querySelectorAll('#tabel-peminjaman tbody tr');
        rowsPeminjaman.forEach((row) => {
            if(row.querySelector('td[colspan]')) return;
            const cells = row.querySelectorAll('td');
            excelDataPeminjaman.push([
                cells[0].textContent.trim(), // Nama Peminjam
                cells[1].textContent.trim(), // Barang
                parseInt(cells[2].textContent.trim()), // Jumlah
                cells[3].textContent.trim(), // Status
                cells[4].textContent.trim()  // Tanggal
            ]);
        });
        const wsPeminjaman = XLSX.utils.aoa_to_sheet(excelDataPeminjaman);
        applyHeaderStyleAndWidth(wsPeminjaman);
        XLSX.utils.book_append_sheet(wb, wsPeminjaman, 'Data Peminjaman');

        // --- Data Pengembalian ---
        const excelDataPengembalian = [
            ['Nama Peminjam', 'Barang', 'Jumlah', 'Status', 'Tanggal Disetujui']
        ];
        const rowsPengembalian = document.querySelectorAll('#tabel-pengembalian tbody tr');
        rowsPengembalian.forEach((row) => {
            if(row.querySelector('td[colspan]')) return;
            const cells = row.querySelectorAll('td');
            excelDataPengembalian.push([
                cells[0].textContent.trim(), // Nama Peminjam
                cells[1].textContent.trim(), // Barang
                parseInt(cells[2].textContent.trim()), // Jumlah
                cells[3].textContent.trim(), // Status
                cells[4].textContent.trim()  // Tanggal Disetujui
            ]);
        });
        const wsPengembalian = XLSX.utils.aoa_to_sheet(excelDataPengembalian);
        applyHeaderStyleAndWidth(wsPengembalian);
        XLSX.utils.book_append_sheet(wb, wsPengembalian, 'Data Pengembalian');

        XLSX.writeFile(wb, filename);

        showNotification(`File ${filename} berhasil diunduh!`, 'success');
    }

    // Helper function to apply styles and column widths
    function applyHeaderStyleAndWidth(ws) {
        if (!ws['!ref']) return;
        const range = XLSX.utils.decode_range(ws['!ref']);
        for (let col = range.s.c; col <= range.e.c; col++) {
            const headerCell = ws[XLSX.utils.encode_cell({r: 0, c: col})];
            if (headerCell) {
                headerCell.s = {
                    font: { bold: true, color: { rgb: "FFFFFF" } },
                    fill: { fgColor: { rgb: "0B74DE" } }, // Dark blue header
                    alignment: { horizontal: "center", vertical: "center" },
                    border: {
                        top: { style: "thin", color: { rgb: "000000" } },
                        bottom: { style: "thin", color: { rgb: "000000" } },
                        left: { style: "thin", color: { rgb: "000000" } },
                        right: { style: "thin", color: { rgb: "000000" } }
                    }
                };
            }
        }

        const colWidths = [];
        for (let col = range.s.c; col <= range.e.c; col++) {
            let maxWidth = 10;
            for (let row = range.s.r; row <= range.e.r; row++) {
                const cell = ws[XLSX.utils.encode_cell({r: row, c: col})];
                if (cell && cell.v) {
                    const cellWidth = cell.v.toString().length;
                    if (cellWidth > maxWidth) maxWidth = cellWidth;
                }
            }
            colWidths.push({wch: Math.min(maxWidth + 3, 50)}); // Limit max width to 50 for readability
        }
        ws['!cols'] = colWidths;
    }


    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 p-4 rounded-lg shadow-lg z-50 transition-all duration-300 transform translate-x-full max-w-sm`;

        if (type === 'success') {
            notification.className += ' bg-green-500 text-white';
            notification.innerHTML = `
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-3 text-xl"></i>
                    <div>
                        <p class="font-semibold">Berhasil!</p>
                        <p class="text-sm">${message}</p>
                    </div>
                </div>
            `;
        } else {
            notification.className += ' bg-blue-500 text-white';
            notification.innerHTML = `
                <div class="flex items-center">
                    <i class="fas fa-info-circle mr-3 text-xl"></i>
                    <div>
                        <p class="font-semibold">Info</p>
                        <p class="text-sm">${message}</p>
                    </div>
                </div>
            `;
        }

        document.body.appendChild(notification);

        setTimeout(() => {
            notification.classList.remove('translate-x-full');
        }, 100);

        setTimeout(() => {
            notification.classList.add('translate-x-full');
            setTimeout(() => {
                if (document.body.contains(notification)) {
                    document.body.removeChild(notification);
                }
            }, 300);
        }, 4000);
    }
</script>
