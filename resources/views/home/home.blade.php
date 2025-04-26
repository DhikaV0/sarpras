<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Dashboard Home</title>
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

        .right-content {
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
        </style>
    </head>
    <body>
        <div class="navbar">
            <div class="left-content">
                <a href="{{ route('home') }}">
                <img class="img" src="https://smktarunabhakti.net/wp-content/uploads/2020/07/logotbvector-copy.png" alt="">
                <h1>Sarpras</h1>
                </a>
            </div>
            <div class="right-content">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button style="font-size: 20px" type="submit">Logout</button>
                </form>
                <form method="GET" action="{{ route('crud') }}">
                    @csrf
                    <button style="font-size: 20px" type="submit">Create</button>
                </form>
            </div>
        </div>
    </body>
</html>
