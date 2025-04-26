<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;


class AuthCrudController extends Controller
{
    public function showRegisterForm() {
        return view('auth.register');
    }

    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:5',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);
        return redirect()->route('home');
    }

    public function showLoginForm() {
        return view('auth.login');
    }

    public function login(Request $request) {
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->route('home');
        }

        return back()->withErrors(['username' => 'Invalid credentials'])->withInput();
    }

    public function logout() {
        Auth::logout();
        return redirect()->route('login');
    }

        public function showCategoryCrud() {
        $categories = Category::all();
        return view('Crud.category_crud');
    }

    public function storeCategory(Request $request) {
    $request->validate([
        'name' => 'required|unique:categories,name',
    ]);

    Category::create([
        'name' => $request->name,
    ]);

    return redirect()->route('category.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

        public function updateCategory(Request $request, $id) {
        $request->validate([
            'name' => 'required|unique:categories,name,' . $id,
    ]);

    $category = Category::findOrFail($id);
    $category->name = $request->name;
    $category->save();

    return redirect()->route('category.index')->with('success', 'Kategori berhasil diperbarui.');
}

public function deleteCategory($id) {
    $category = Category::findOrFail($id);
    $category->delete();

    return redirect()->route('category.index')->with('success', 'Kategori berhasil dihapus.');
}
}
