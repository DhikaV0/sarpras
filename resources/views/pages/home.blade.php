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
            background-color: #053dd8;
            padding: 30px;
            text-align: center;;
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
            <a href="{{ route('crud') }}">Create</a>
            <a href="{{ route('users') }}">Users</a>
        </div>
    </body>
</html>
