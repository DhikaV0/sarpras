<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use App\Models\Item;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class MainApiController extends Controller
{
    // USER (AUTH) API
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|confirmed|min:5',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'User registered successfully',
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer'
        ], 201);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer'
        ]);
    }

    public function logout(Request $request)
    {
        if ($request->user()) {
            $request->user()->currentAccessToken()->delete();
            return response()->json(['message' => 'Logged out successfully']);
        } else {
            return response()->json(['message' => 'User not authenticated'], 401);
        }
    }

    // CATEGORY API
    public function createCategory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $category = Category::create(['name' => $request->name]);

        return response()->json(['message' => 'Category created', 'category' => $category], 201);
    }

    public function getCategories()
    {
        $categories = Category::all();
        return response()->json($categories);
    }

    public function updateCategory(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:categories,name,' . $id,
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $category->update(['name' => $request->name]);

        return response()->json(['message' => 'Category updated', 'category' => $category]);
    }

    public function deleteCategory($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return response()->json(['message' => 'Category deleted']);
    }

    // ITEM API
    public function createItem(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'stok' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'deskripsi' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $path = null;
        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('img-item', 'public');
        }

        $item = Item::create([
            'name' => $request->name,
            'stok' => $request->stok,
            'category_id' => $request->category_id,
            'deskripsi' => $request->deskripsi,
            'foto' => $path,
        ]);

        return response()->json(['message' => 'Item created', 'item' => $item], 201);
    }

    public function getItems()
    {
        $items = Item::with('category')->get();
        return response()->json($items);
    }

    public function updateItem(Request $request, $id)
    {
        $item = Item::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'stok' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'deskripsi' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $data = $request->only('name', 'stok', 'category_id', 'deskripsi');

        if ($request->hasFile('foto')) {
            if ($item->foto) {
                Storage::disk('public')->delete($item->foto);
            }
            $data['foto'] = $request->file('foto')->store('img-item', 'public');
        }

        $item->update($data);

        return response()->json(['message' => 'Item updated', 'item' => $item]);
    }

    public function deleteItem($id)
    {
        $item = Item::findOrFail($id);

        if ($item->foto) {
            Storage::disk('public')->delete($item->foto);
        }

        $item->delete();

        return response()->json(['message' => 'Item deleted']);
    }

    // PEMINJAMAN API
    public function Peminjaman(Request $request)
    {
        $request->validate([
            'users_id'    => 'required|exists:users,id',
            'items_id'    => 'required|exists:items,id',
            'jumlah_pinjam' => 'required|integer|min:1',
            'tanggal_pinjam' => 'required|date',
        ]);

        $item = Item::find($request->items_id);

        if ($item->stok < $request->jumlah_pinjam) {
            return response()->json(['message' => 'Stok tidak mencukupi'], 400);
        }

        $item->stok -= $request->jumlah_pinjam;
        $item->save();

        $peminjaman = Peminjaman::create([
            'users_id'       => $request->users_id,
            'items_id'       => $request->items_id,
            'jumlah_pinjam'  => $request->jumlah_pinjam,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'status'         => 'pinjam',
        ]);

        return response()->json(['message' => 'Peminjaman berhasil', 'data' => $peminjaman]);
    }

    // PENGEMBALIAN API
    public function Pengembalian($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->status !== 'pinjam') {
            return response()->json(['message' => 'Barang sudah dikembalikan'], 400);
        }

        $item = Item::find($peminjaman->items_id);
        $item->stok += $peminjaman->jumlah_pinjam;
        $item->save();

        $peminjaman->update([
            'status' => 'kembali',
            'tanggal_kembali' => now(),
        ]);

        return response()->json(['message' => 'Barang berhasil dikembalikan', 'data' => $peminjaman]);
    }

}
