<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Kategori</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #bbddff;
            color: #333;
        }

        .img {
            width: 70px;
            height: 70px;
            margin-right: 20px;
        }

        .navbar {
            background-color: #1e3a8a;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .left-content {
            display: flex;
            align-items: center;
        }

        .navbar h1 {
            margin: 0;
            font-size: 24px;
        }

        .navbar .left-content a {
            display: flex;
            align-items: center;
            text-decoration: none;
            color: white;
        }

        .navbar a,
        .navbar button {
            color: white;
            text-decoration: none;
            font-weight: bold;
            font-size: 18px;
            background: none;
            border: none;
            cursor: pointer;
            margin-left: 20px;
        }

        .right-buttons {
            display: flex;
            align-items: center;
        }

        .container {
            padding: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            color: black;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ccc;
            text-align: center;
        }

        form {
            margin-bottom: 20px;
        }

        input[type="text"] {
            padding: 10px;
            width: 300px;
        }

        button {
            padding: 10px 15px;
            margin-left: 10px;
            background-color: #1e3a8a;
            color: white;
            border: none;
            cursor: pointer;
        }

        .success-message {
            color: green;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div class="left-content">
            <a href="{{ route('home') }}">
            <img class="img" src="https://smktarunabhakti.net/wp-content/uploads/2020/07/logotbvector-copy.png" alt="Logo">
            <h1>Sarpras</h1>
            </a>
        </div>
        <div class="right-buttons">
            <form method="GET" action="{{ route('crud') }}">
                <button type="submit">Back</button>
            </form>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">Logout</button>
            </form>
        </div>
    </div>

    <div class="container">
        <h2>Daftar Kategori</h2>

        <form method="POST" action="{{ route('category.store') }}">
            @csrf
            <input type="text" name="name" placeholder="Nama kategori baru" required>
            <button type="submit">Tambah</button>
        </form>

        @if(session('success'))
            <div class="success-message">{{ session('success') }}</div>
        @endif

        @if($categories->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Kategori</th>
                        <th>Ubah Nama</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $i => $category)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $category->name }}</td>

                            <td>
                                <form method="POST" action="{{ route('category.update', $category->id) }}" style="display: flex; align-items: center; justify-content: center;">
                                    @csrf
                                    @method('PUT')
                                    <input type="text" name="name" value="{{ $category->name }}" required style="width: 150px;">
                                    <button type="submit">Ubah</button>
                                </form>
                            </td>

                            <td>
                                <form method="POST" action="{{ route('category.delete', $category->id) }}" onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="background-color: #dc2626;">Hapus</button>
                                </form>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>Tidak ada kategori yang tersedia.</p>
        @endif
    </div>
</body>
</html>
