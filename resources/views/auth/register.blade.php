<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body class="font-sans h-screen flex justify-center items-center bg-gradient-to-br from-blue-900 to-blue-500">
    <div class="bg-blue-900 p-12 rounded-xl shadow-lg text-white w-full max-w-md">
        <h2 class="text-3xl font-bold text-center mb-8">REGISTER</h2>
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="mb-5 relative">
                <input type="text" name="username" placeholder="Username" required
                       class="w-full pl-10 pr-4 py-3 border-none rounded-md bg-white text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-400">
                <i class="fas fa-user absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
            </div>

            <div class="mb-5 relative">
                <input type="email" name="email" placeholder="Email" required
                       class="w-full pl-10 pr-4 py-3 border-none rounded-md bg-white text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-400">
                <i class="fas fa-envelope absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
            </div>

            <div class="mb-5 relative">
                <input type="password" name="password" placeholder="Password" required
                       class="w-full pl-10 pr-4 py-3 border-none rounded-md bg-white text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-400">
                <i class="fas fa-lock absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
            </div>

            <div class="mb-5 relative">
                <input type="password" name="password_confirmation" placeholder="Confirm Password" required
                       class="w-full pl-10 pr-4 py-3 border-none rounded-md bg-white text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-400">
                <i class="fas fa-check-circle absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
            </div>

            <div class="mb-5">
                <label for="role" class="block text-sm font-semibold mb-2">Role</label>
                <select name="role" id="role" required
                        class="w-full px-4 py-3 border-none rounded-md bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>

            <p class="text-center text-sm mb-5">
                Already have an account? <a href="{{ route('login') }}" class="text-blue-400 hover:underline font-semibold">Login here</a>
            </p>
            <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 transition-colors duration-300 border-none py-3 rounded-md text-white font-bold cursor-pointer text-lg">
                REGISTER
            </button>
        </form>
    </div>
</body>
</html>
