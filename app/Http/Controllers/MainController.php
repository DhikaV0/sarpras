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
        $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:admin,user',
        ]);

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
        ]);

        Auth::login($user);

        return $user->role === 'admin'
            ? redirect('mobile/home')
            : redirect('web/home');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
        'username' => 'required|string',
        'password' => 'required',
        ]);

        if (Auth::attempt($request->only('username', 'password'))) {
            $user = Auth::user();
            if ($user->role === 'admin') {
                return redirect()->intended('web/home');
            } elseif ($user->role === 'user') {
                return redirect()->intended('mobile/home');
            } else {
                Auth::logout();
                return redirect()->route('login')->with('error', 'Role tidak dikenal.');
            }
        }

        return back()->withErrors([
            'email' => 'Username atau password salah.',
        ]);
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

        if (Auth::check()) {
            $user = Auth::user();
            if ($user->role === 'admin') {
                return view('web.home', compact('users', 'categories', 'items'));
            } elseif ($user->role === 'user') {
                return view('mobile.home', compact('users', 'categories', 'items'));
            }
        }

        return redirect()->route('login')->with('error', 'Akses ditolak.');
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
            'role'     => $request->role ?? 'user',
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
        $peminjaman = Peminjaman::with(['user', 'items'])->latest()->get();
        return view('web.peminjaman', compact('peminjaman'));
    }

    public function approve($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $items = Item::findOrFail($peminjaman->items_id);

        if ($items->stok < $peminjaman->jumlah_pinjam) {
            return back()->with('error', 'Stok tidak mencukupi untuk disetujui.');
        }

        $peminjaman->status = 'disetujui';
        $peminjaman->save();

        $items->stok -= $peminjaman->jumlah_pinjam;
        $items->save();

        return back()->with('success', 'Peminjaman disetujui.');
    }

    public function reject($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->status = 'ditolak';
        $peminjaman->save();

        return back()->with('success', 'Peminjaman ditolak.');
    }

    public function destroy($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->status === 'disetujui') {
            $item = Item::findOrFail($peminjaman->items_id);
            $item->stok += $peminjaman->jumlah_pinjam;
            $item->save();
        }

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

