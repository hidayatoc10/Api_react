<?php

namespace App\Http\Controllers;

use Hash;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Validator;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class AuthController extends Controller
{
    public function registrasi(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "nama" => "required|min:3|max:50",
            "username" => "required|min:3|max:50|unique:users",
            "email" => "required|min:3|max:80|email|unique:users",
            "nomor_telepon" => "required|min:3|max:13|unique:users",
            "password" => "required|min:3|max:80|unique:users",
        ]);
        if ($validator->fails()) {
            return response()->json([
                "error" => false,
                "message" => $validator->errors(),
            ], 400);
        } else {
            $user = User::create([
                "nama" => $request->nama,
                "username" => $request->username,
                "email" => $request->email,
                "nomor_telepon" => $request->nomor_telepon,
                "password" => Hash::make($request->password),
            ]);
        }
        return response()->json([
            "succses" => true,
            "message" => "Registrasi Berhasil",
            "data" => $user,
        ], 200);
    }

    public function login(Request $request)
    {
        $api = $request->only("username", "password");

        try {
            if (!$token = JWTAuth::attempt($api)) {
                return response()->json([
                    "error" => false,
                    "message" => "Username atau Password salah, coba lagi",
                ], 400);
            }
        } catch (JWTException $e) {
            return response()->json([
                "error" => false,
                "message" => "Gagal membuat token, coba lagi",
            ], 500);
        }

        $user = User::where("username", $request->username)->first();

        return response()->json([
            "succses" => true,
            "message" => "Login berhasil, selamat datang",
            "result" => [
                "token" => $token,
                "nama" => $user->nama,
                "username" => $user->username,
                "email" => $user->email,
                "nomor_telepon" => $user->nomor_telepon,
                "created_at" => $user->created_at,
                "id" => $user->id,
            ]
        ], 200);
    }

    public function user()
    {
        $dataUser = User::all();
        return response()->json([
            "succses" => true,
            "message" => "User berhasil ditampilkan",
            "result" => [
                "data" => $dataUser,
            ]
        ], 200);
    }
    public function cari_user($created_at)
    {
        $user = User::where("created_at", $created_at)->first();
        return response()->json([
            "succses" => true,
            "message" => "User berhasil ditemukan",
            "result" => [
                "data" => $user,
            ]
        ]);
    }
    public function ubah_user_post(Request $request, string $created_at)
    {
        $validator = Validator::make($request->all(), [
            "nama" => "required|min:3|max:50",
            "username" => "required|min:3|max:50|unique:users",
            "email" => "required|min:3|max:80|email|unique:users",
            "nomor_telepon" => "required|min:3|max:13|unique:users",
            "password" => "required|min:3|max:80|unique:users",
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => false,
                'message' => $validator->errors()
            ], 422);
        } else {
            $update = User::where("created_at", $created_at)->first();
            if ($update) {
                $update->nama = $request->nama;
                $update->username = $request->username;
                $update->email = $request->email;
                $update->nomor_telepon = $request->nomor_telepon;
                $update->password = Hash::make($request->password);
                $update->save();
                return response()->json([
                    'succses' => true,
                    'message' => "User berhasil diubah",
                    "result" => [
                        "data" => $update,
                    ]
                ], 200);
            } else {
                return response()->json([
                    'error' => false,
                    'message' => "Data tidak ditemukan"
                ], 422);
            }
        }
    }
}
