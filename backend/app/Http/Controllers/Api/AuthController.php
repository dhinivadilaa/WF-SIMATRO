<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    // Register (public)
    public function register(Request $req)
    {
        $req->validate([
            'name'=>'required|string',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:6'
        ]);

        $user = User::create([
            'name'=>$req->name,
            'email'=>$req->email,
            'password'=>Hash::make($req->password)
        ]);

        $token = $user->createToken('simatro-token')->plainTextToken;

        return response()->json(['message'=>'Register sukses','user'=>$user,'token'=>$token],201);
    }

    // Login (public)
    public function login(Request $req)
    {
        $req->validate(['email'=>'required|email','password'=>'required']);

        $user = User::where('email',$req->email)->first();
        if (! $user || ! Hash::check($req->password, $user->password)) {
            throw ValidationException::withMessages(['email' => ['Credentials are incorrect.']]);
        }

        $token = $user->createToken('simatro-token')->plainTextToken;
        return response()->json(['message'=>'Login sukses','user'=>$user,'token'=>$token]);
    }

    // Logout (protected)
    public function logout(Request $req)
    {
        $req->user()->tokens()->delete();
        return response()->json(['message'=>'Logout berhasil']);
    }
}
