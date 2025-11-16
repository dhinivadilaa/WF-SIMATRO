<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin; // ganti User → Admin
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    // Register Admin (public)
    public function register(Request $req)
    {
        $req->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:admin,email',
            'password' => 'required|min:6'
        ]);

        $admin = Admin::create([
            'name' => $req->name,
            'email' => $req->email,
            'password' => Hash::make($req->password)
        ]);

        $token = $admin->createToken('simatro-token')->plainTextToken;

        return response()->json([
            'message' => 'Register sukses',
            'admin' => $admin,
            'token' => $token
        ], 201);
    }

    // Login Admin (public)
    public function login(Request $req)
    {
        $req->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $admin = Admin::where('email', $req->email)->first();

        if (! $admin || ! Hash::check($req->password, $admin->password)) {
            throw ValidationException::withMessages([
                'email' => ['Email atau password salah.']
            ]);
        }

        $token = $admin->createToken('simatro-token')->plainTextToken;

        return response()->json([
            'message' => 'Login sukses',
            'admin' => $admin,
            'token' => $token
        ]);
    }

    // Logout (protected)
    public function logout(Request $req)
    {
        $req->user()->tokens()->delete();

        return response()->json(['message' => 'Logout berhasil']);
    }
}
