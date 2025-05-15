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
use App\Models\Peminjaman;

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
            'role'     => 'required|in:user,admin',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'username' => $request->username,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        Auth::login($user);
        if ($user->role === 'admin') {
            return view('web.home');
        } elseif ($user->role === 'user') {
            return view('mobile.home');
        } else {
            Auth::logout();
            return redirect()->route('login')->withErrors(['role' => 'Role tidak dikenali.']);
        }
    }


    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

    if (Auth::attempt($credentials)) {
        $user = Auth::user();

        if ($user->role === 'admin') {
            return view('web.home');
        } elseif ($user->role === 'user') {
            return view('mobile.home');
        } else {
            Auth::logout();
            return back()->withErrors(['login' => 'Role pengguna tidak valid.'])->withInput();
        }
        } else {
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

        return view('web.home', compact('users', 'categories', 'items'));
    }

    // USERS
    public function showUsers()
    {
        $users = User::all();
        return view('web.users', compact('users'));
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
            'role'     => $request->role,
        ]);

        return redirect()->route('users')->with('success', 'User berhasil ditambahkan.');
    }

    // CRUD
    public function showCrudPage()
    {
        $categories = Category::all();
        $items      = Item::with('category')->get();

        return view('web.crud', compact('categories', 'items'));
    }

    // CATEGORY CRUD
    public function showCategories()
    {
        $categories = Category::all();
        return view('web.crud', compact('categories'));
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
        return view('web.crud', compact('items'));
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
        $data['foto'] = $request->file('foto')->store('foto_items', 'public');
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

    // PEMINJAMAN
    public function showPeminjaman()
    {
        $items = Item::all();
        $users = User::all();
        $peminjaman = Peminjaman::with(['user', 'item'])->get();
        return view('web.peminjaman', compact('peminjaman', 'items', 'users'));
    }

    public function Peminjaman(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:items,id',
            'jumlah_pinjam' => 'required|integer|min:1',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'nullable|date|after_or_equal:tanggal_pinjam',
        ]);

        $item = Item::findOrFail($request->item_id);

        if ($item->stok < $request->jumlah_pinjam) {
            return back()->with('error', 'Stok tidak mencukupi.');
        }

        $item->stok -= $request->jumlah_pinjam;
        $item->save();

        Peminjaman::create([
            'users_id' => $request->users_id,
            'items_id' => $request->item_id,
            'jumlah_pinjam' => $request->jumlah_pinjam,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali,
            'status' => 'pinjam',
        ]);

        return redirect()->back()->with('success', 'Peminjaman berhasil.');
    }

    public function destroy($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        $item = Item::findOrFail($peminjaman->items_id);
        $item->stok += $peminjaman->jumlah_pinjam;
        $item->save();

        $peminjaman->delete();

        return redirect()->back()->with('success', 'Data peminjaman berhasil dihapus.');
    }

    //PNGEMBALIAN
    public function Pengembalian($id)
    {
    $peminjaman = Peminjaman::findOrFail($id);

    if ($peminjaman->status != 'pinjam') {
        return back()->with('error', 'Barang sudah dikembalikan.');
    }

    $item = Item::find($peminjaman->items_id);
    $item->stok += $peminjaman->jumlah_pinjam;
    $item->save();

    $peminjaman->status = 'kembali';
    $peminjaman->tanggal_kembali = now();
    $peminjaman->save();

    return redirect()->back()->with('success', 'Barang berhasil dikembalikan.');
    }


}

