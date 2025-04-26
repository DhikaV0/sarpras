<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #bbddff;
            color: white;
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
            display: flex;
            justify-content: space-around;
            margin-top: 100px;
        }

        .btn-box {
            border: 2px solid #1e3a8a;
            padding: 40px;
            border-radius: 20px;
            text-align: center;
            background-color: white;
        }

        .btn-box a {
            text-decoration: none;
            color: #1e3a8a;
            font-size: 18px;
            font-weight: bold;
        }

        .btn-box:hover {
            background-color: #e8eaf6;
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
        <form method="GET" action="{{ route('home') }}">
            <button type="submit">Home</button>
        </form>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit">Logout</button>
        </form>
    </div>
</div>

<div class="container">
    <div class="btn-box">
        <a href="{{ route('category') }}">Create Category</a>
    </div>
    <div class="btn-box">
        <a href="#">Create Item</a>
    </div>
</div>

</body>
</html>
