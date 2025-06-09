<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body class="font-sans h-screen flex justify-center items-center bg-gradient-to-br from-blue-900 to-blue-500">
    <div class="bg-blue-900 p-12 rounded-xl shadow-lg text-white w-full max-w-md">
        <h2 class="text-3xl font-bold text-center mb-8">LOGIN</h2>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-5 relative">
                <input type="text" name="username" placeholder="Username" required
                       class="w-full pl-10 pr-4 py-3 border-none rounded-md bg-white text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-400">
                <i class="fas fa-user absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
            </div>

            <div class="mb-5 relative">
                <input type="password" name="password" placeholder="Password" required
                       class="w-full pl-10 pr-4 py-3 border-none rounded-md bg-white text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-400">
                <i class="fas fa-lock absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                @error('login')
                    <div class="text-red-400 text-sm mt-2">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="flex items-center mb-5">
                <label class="text-sm cursor-pointer">
                    <input type="checkbox" name="remember" class="mr-2 rounded text-blue-600 focus:ring-blue-500">
                    Ingat saya
                </label>
            </div>

            <p class="text-center text-sm mb-5">
                Belum punya akun? <a href="{{ route('register') }}" class="text-blue-400 hover:underline font-semibold">Register</a>
            </p>

            <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 transition-colors duration-300 border-none py-3 rounded-md text-white font-bold cursor-pointer text-lg">
                LOGIN
            </button>
        </form>
    </div>
</body>
</html>
