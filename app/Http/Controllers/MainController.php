<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\support\Facades\Storage;
use App\Models\Category;
use App\Models\Item;

class MainController extends Controller
{
    // AUTH
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:users',
            'email'    => 'required|email|unique:users',
            'password' => 'required|confirmed|min:5',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'username' => $request->username,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);
        return redirect()->route('home');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->route('home');
        }
        else {
            return back()->withErrors(['login' => 'Username atau password salah'])->withInput();
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    // HOME
    public function showHome()
    {
        $users = User::all();
        $categories = Category::all();
        $items = Item::with('category')->get();

        return view('pages.home', compact('users', 'categories', 'items'));
    }

    // USERS
    public function showUsers()
    {
        $users = User::all();
        return view('pages.users', compact('users'));
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:5',
        ]);

        User::create([
            'username' => $request->username,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('users')->with('success', 'User berhasil ditambahkan.');
    }


    // CRUD
    public function showCrudPage()
    {
        $categories = Category::all();
        $items      = Item::with('category')->get();

        return view('pages.crud', compact('categories', 'items'));
    }

    // CATEGORY CRUD
    public function showCategories()
    {
        $categories = Category::all();
        return view('pages.crud', compact('categories'));
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories,name',
        ]);

        Category::create(['name' => $request->name]);

        return redirect()->route('crud')->with('success_category', 'Kategori berhasil ditambahkan.');
    }

    public function updateCategory(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:categories,name,' . $id,
        ]);

        Category::where('id', $id)->update(['name' => $request->name]);

        return redirect()->route('crud')->with('success_category', 'Kategori berhasil diperbarui.');
    }

    public function deleteCategory($id)
    {
        $categories  = Category::find($id)->delete();

        return redirect()->route('crud')->with('success_category', 'Kategori berhasil dihapus.');
    }

    // ITEM CRUD
    public function showItems()
    {
        $items = Item::with('category')->get();
        return view('pages.crud', compact('items'));
    }

    public function storeItem(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'stok'        => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'deskripsi'   => 'nullable|string',
            'foto'        => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only('name', 'stok', 'category_id', 'deskripsi');

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('foto_items', 'public');
        }

        Item::create($data);

        return redirect()->route('crud')->with('success_item', 'Item berhasil ditambahkan.');
    }

    public function updateItem(Request $request, $id)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'stok'        => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'deskripsi'   => 'nullable|string',
            'foto'        => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $item = Item::find($id);
        $data = $request->only('name', 'stok', 'category_id', 'deskripsi');

        if ($request->hasFile('foto')) {
            if ($item->foto) {
                Storage::disk('public')->delete($item->foto);
            }
            $data['foto'] = $request->file('foto')->store('img-item', 'public');
        }

        $item->update($data);

        return redirect()->route('crud')->with('success_item', 'Item berhasil diperbarui.');
    }

    public function deleteItem($id)
    {
        $item = Item::find($id);
        if ($item->foto) {
            Storage::disk('public')->delete($item->foto);
        }
        $item->delete();

        return redirect()->route('crud')->with('success_item', 'Item berhasil dihapus.');
    }
}

