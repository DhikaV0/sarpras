<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Page</title>
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

        .sidebar img {
            width: 100px;
            height: auto;
            margin: 0 auto;
            display: block;
        }

        .sidebar h1 {
            color: white;
            text-align: center;
            margin-bottom: 30px;
            font-size: 20px;
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

        .modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.4);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1001;
        }

        .modal-content {
            background-color: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.2);
            width: 400px;
            max-width: 90%;
            position: relative;
        }

        .action-btn {
            background: #1e3a8a;
            color: white;
            margin-top: 20px;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
        }

        .close {
            position: absolute;
            right: 15px;
            top: 10px;
            font-size: 22px;
            font-weight: bold;
            cursor: pointer;
        }

        .modal-content input {
            width: 95%;
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #ccc;
            margin-top: 5px;
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
        <img class="img" src="https://smktarunabhakti.net/wp-content/uploads/2020/07/logotbvector-copy.png" alt="">
        <h1>SARPRAS</h1>
        <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
        <a href="{{ route('users') }}" class="{{ request()->routeIs('users') ? 'active' : '' }}">Users</a>
        <a href="{{ route('crud') }}" class="{{ request()->routeIs('crud') ? 'active' : '' }}">Create</a>
        <a href="{{ route('peminjaman') }}" class="{{ request()->routeIs('peminjaman') ? 'active' : '' }}">Peminjaman</a>
    </div>

    <div class="main-content">
        <div class="card">
            <h2>Daftar Pengguna</h2>

            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Terdaftar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $i => $user)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->created_at->format('d M Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">Belum ada data pengguna</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <button onclick="document.getElementById('addUserModal').style.display='flex'" class="action-btn">Tambah User</button>
            <div id="addUserModal" class="modal" style="display:none;">
                <div class="modal-content">
                    <span class="close" onclick="document.getElementById('addUserModal').style.display='none'">&times;</span>
                    <h3>Tambah User Baru</h3>
                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf
                        <input type="text" name="username" placeholder="Username" required><br><br>
                        <input type="email" name="email" placeholder="Email" required><br><br>
                        <input type="password" name="password" placeholder="Password" required><br><br>
                        <button type="submit" class="action-btn">Simpan</button>
                    </form>
                </div>
            </div>
        @if(session('success'))
            <div style="margin: 15px 0; background: #d4edda; color: #155724; padding: 10px; border-radius: 8px;">
                {{ session('success') }}
            </div>
        @endif
        </div>
    </div>
    <script>

        function openModal() {
            document.getElementById("popupModal").style.display = "flex";
        }

        function closeModal() {
            document.getElementById("popupModal").style.display = "none";
        }

        window.onclick = function(event) {
            let modal = document.getElementById("popupModal");
            if (event.target === modal) {
                modal.style.display = "none";
            }
        }
    </script>
</body>
</html>
