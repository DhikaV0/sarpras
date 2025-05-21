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
    public function getCategories()
    {
        $categories = Category::all();
        return response()->json($categories);
    }

    // ITEM API
    public function getItems()
    {
        $items = Item::with('category')->get();
        return response()->json($items);
    }

    // PEMINJAMAN API
      public function store(Request $request)
    {
        $request->validate([
            'items_id' => 'required|exists:items,id',
            'jumlah_pinjam' => 'required|integer|min:1',
            'tanggal_pinjam' => 'required|date',
        ]);

        $peminjaman = Peminjaman::create([
            'users_id' => auth()->id(),
            'items_id' => $request->items_id,
            'jumlah_pinjam' => $request->jumlah_pinjam,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'status' => 'pinjam',
        ]);

        return response()->json([
            'message' => 'Peminjaman berhasil diajukan.',
            'data' => $peminjaman
        ], 201);
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
