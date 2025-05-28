<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(to bottom right, #003477, #0065fd);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .img-header {
            position: absolute;
            top: 5px;
            left: 50%;
            transform: translateX(-50%);
            width: 200px;
            height: 200px;
        }

        .container {
            background-color: #1e3a8a;
            padding: 50px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            color: white;
            width: 400px;
        }

        .container h2 {
            text-align: center;
            margin-bottom: 25px;
            font-size: 20px;
        }

        .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        .form-group input {
            width: 82%;
            padding: 10px 35px 10px 35px;
            border: none;
            border-radius: 5px;
            background-color: #ffffff;
            color: rgb(13, 0, 0);
        }

        .underform-text {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
        }

        .form-group .icon {
            position: absolute;
            left: 10px;
            top: 10px;
            width: 16px;
            height: 16px;
        }

        .container button {
             width: 100%;
            background-color: #3b82f6;
            border: none;
            padding: 10px;
            border-radius: 5px;
            color: white;
            font-weight: bold;
            cursor: pointer;
        }

        .container button:hover {
            background-color: #2563eb;
        }
    </style>
</head>
<body>
    <img src="https://smktarunabhakti.net/wp-content/uploads/2020/07/logotbvector-copy.png" alt="" class="img-header">
    <div class="container">
        <h2>REGISTER</h2>
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="form-group">
                <input type="text" name="username" placeholder="Username" required>
            </div>

            <div class="form-group">
                <input type="email" name="email" placeholder="Email" required>
            </div>

            <div class="form-group">
                <input type="password" name="password" placeholder="Password" required>
            </div>

            <div class="form-group">
                <input type="password" name="password_confirmation" placeholder="Confirm Password" required>
            </div>

             <div class="form-group">
                <label for="role">Role</label>
                <select name="role" id="role" class="form-control" required>
                    <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>

            <p class="underform-text">
                Already have an account? <a href="{{ route('login') }}" style="color: rgb(135, 149, 255);">Login here</a>
            </p>
            <button type="submit">REGISTER</button>
        </form>
    </div>
</body>
</html>
