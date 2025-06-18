<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use App\Models\Item;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Illuminate\Support\Facades\DB;
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
        $items = Item::with('category')->get()->map(function ($item) {
            return [
            'id' => $item->id,
            'name' => $item->name,
            'stok' => $item->stok,
            'category_id' => $item->category->name ?? '-',
            'foto' => $item->foto,
        ];
    });

        return response()->json($items);
    }

    // PROFILE API
    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        if (!$user || !($user instanceof \App\Models\User)) {
            return response()->json(['message' => 'User not authenticated or not found'], 401);
        }

        $request->validate([
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:5|confirmed',
        ]);

        $user->email = $request->email;
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }
        $user->save();

        return response()->json(['message' => 'Profile updated', 'user' => $user]);
    }

    // PEMINJAMAN API
    public function store(Request $request)
    {
        $item = Item::findOrFail($request->items_id);
        if ($item->stok < $request->jumlah_pinjam) {
            return response()->json(['message' => 'Stok tidak mencukupi'], 400);
        }

        $request->validate([
            'items_id' => 'required|exists:items,id',
            'jumlah_pinjam' => 'required|integer|min:1',
            'tanggal_pinjam' => 'required|date_format:Y-m-d',
        ]);

        $peminjaman = Peminjaman::create([
            'users_id' => auth()->id(),
            'items_id' => $request->items_id,
            'jumlah_pinjam' => $request->jumlah_pinjam,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'status' => 'menunggu', // Status awal saat peminjaman diajukan
        ]);

        return response()->json([
            'message' => 'Peminjaman berhasil diajukan.',
            'data' => $peminjaman
        ], 201);
    }

    public function getMyPeminjaman()
    {
        $peminjaman = Peminjaman::with(['items.category', 'user', 'pengembalian'])
        ->where('users_id', auth()->id())
        ->latest()
        ->get();
        return response()->json($peminjaman);
    }


    // PENGEMBALIAN API
    public function requestPengembalian(Request $request, $peminjamanId) // ID di sini adalah ID dari Peminjaman
    {
        $validator = Validator::make($request->all(), [
            'deskripsi' => 'nullable|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $peminjaman = Peminjaman::where('id', $peminjamanId)
        ->where('users_id', auth()->id())
        ->first();

        if (!$peminjaman) {
            return response()->json(['message' => 'Peminjaman tidak ditemukan atau Anda tidak memiliki akses.'], 404);
        }

        if ($peminjaman->status !== 'dipinjam') {
            return response()->json(['message' => 'Barang belum/tidak dalam status dipinjam.'], 400);
        }

        if ($peminjaman->pengembalian && $peminjaman->pengembalian->status_pengembalian === 'diajukan') {
             return response()->json(['message' => 'Pengajuan pengembalian untuk peminjaman ini sudah diajukan dan sedang menunggu persetujuan.'], 400);
        }

        DB::transaction(function () use ($request, $peminjaman) {
            $fotoPath = null;
            if ($request->hasFile('foto')) {
                $fotoPath = $request->file('foto')->store('foto_pengembalian', 'public');
            }

            Pengembalian::create([
                'peminjaman_id' => $peminjaman->id,
                'deskripsi_pengembalian' => $request->deskripsi,
                'foto_pengembalian' => $fotoPath,
                'tanggal_pengajuan_kembali' => now(),
                'status_pengembalian' => 'diajukan',
            ]);

            $peminjaman->status = 'menunggu';
            $peminjaman->save();
        });

        $peminjaman->load('pengembalian');

        return response()->json([
            'message' => 'Permintaan pengembalian berhasil diajukan. Menunggu persetujuan admin.',
            'data' => $peminjaman
        ], 201);
    }

}
