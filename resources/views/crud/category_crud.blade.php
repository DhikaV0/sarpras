<!-- resources/views/Crud/category_crud.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CRUD Kategori</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #bbddff;
            color: #333;
        }

        .navbar {
            background-color: #1e3a8a;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
        }

        .navbar a, .navbar button {
            color: white;
            text-decoration: none;
            font-weight: bold;
            font-size: 16px;
            margin-left: 20px;
            background: none;
            border: none;
            cursor: pointer;
        }

        .container {
            padding: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            color: black;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ccc;
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
        }

    </style>
</head>
<body>
    <div class="navbar">
        <div>
            <a href="{{ route('home') }}">Home</a>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit">Logout</button>
        </form>
    </div>

    <div class="container">
        <h2>Daftar Kategori</h2>

        <form method="POST" action="{{ route('category.store') }}">
            @csrf
            <input type="text" name="name" placeholder="Nama kategori" required>
            <button type="submit">Tambah</button>
        </form>

        @if(session('success'))
            <p style="color: green;">{{ session('success') }}</p>
        @endif

        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Kategori</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $i => $category)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $category->name }}</td>
                        <td>
                            <form method="POST" action="{{ route('category.update', $category->id) }}" style="display:inline;">
                                @csrf
                                <input type="text" name="name" value="{{ $category->name }}" required>
                                <button type="submit">Edit</button>
                            </form>

                            <form method="POST" action="{{ route('category.delete', $category->id) }}" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Yakin hapus?')" type="submit">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
