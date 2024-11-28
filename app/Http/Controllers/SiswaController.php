<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Siswa;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $siswa = Siswa::all();
        return response()->json([
            'succses' => true,
            'message' => 'Data berhasil tampil',
            'result' => [
                'page' => 1,
                'data' => $siswa,
            ],
        ], 200);
    }

    public function carisiswa(string $keyword)
    {
        $siswa = Siswa::where('name', 'LIKE', '%' . $keyword . '%')
            ->orWhere('kelas', 'LIKE', '%' . $keyword . '%')
            ->orWhere('sekolah', 'LIKE', '%' . $keyword . '%')
            ->orWhere('keterangan', 'LIKE', '%' . $keyword . '%')
            ->get();
        if ($siswa->isEmpty()) {
            return response()->json([
                'message' => 'No students found',
            ], 404);
        }
        return response()->json([
            'succses' => true,
            'message' => 'Data berhasil ditemukan',
            'result' => [
                'page' => 1,
                'data' => $siswa,
            ]
        ], 200);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|max:50',
            'kelas' => 'required|min:3|max:50',
            'sekolah' => 'required|min:3|max:50',
            'keterangan' => 'required|min:3',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'error' => "Siswa gagal ditambahkan",
                'message' => $validator->errors(),
            ], 422);
        } else {
            $siswa = Siswa::create([
                'name' => $request->name,
                'kelas' => $request->kelas,
                'sekolah' => $request->sekolah,
                'keterangan' => $request->keterangan,
            ]);

            return response()->json([
                'sucsess' => true,
                'message' => "Siswa berhasil ditambah",
                'result' => [
                    'data' => $siswa,
                ]
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $created_at)
    {
        $show = Siswa::where('created_at', $created_at)->first();
        if ($show) {
            return response()->json([
                'sucsess' => true,
                'result' => [
                    'data' => $show,
                ]
            ], 200);
        } else {
            return response()->json([
                'error' => false,
                'message' => 'Siswa tidak ditemukan'
            ], 422);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|max:50',
            'kelas' => 'required|min:3|max:50',
            'sekolah' => 'required|min:3|max:50',
            'keterangan' => 'required|min:3',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'error' => false,
                'message' => $validator->errors()
            ], 422);
        } else {
            $update = Siswa::find($id);
            if ($update) {
                $update->name = $request->name;
                $update->kelas = $request->kelas;
                $update->sekolah = $request->sekolah;
                $update->keterangan = $request->keterangan;
                $update->save();
                return response()->json([
                    'sucsess' => true,
                    'message' => 'Siswa berhasil di ubah',
                    'result' => [
                        'data' => $update,
                    ]
                ], 200);
            } else {
                return response()->json([
                    'message' => 'Data Not Foud'
                ], 422);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $created_at)
    {
        $delete = Siswa::where('created_at', $created_at)->delete();
        if ($delete) {
            return response()->json([
                'sucsess' => true,
                'message' => 'Siswa berhasil di hapus'
            ], 200);
        } else {
            return response()->json([
                'error' => false,
                'message' => 'Siswa tidak ditemukan'
            ], 422);
        }
    }
    public function login()
    {
        return view('welcome');
    }
    public function home()
    {
        return view('home');
    }
    public function login_post(Request $request)
    {
        $cek = $request->validate([
            'username' => 'required|min:3',
            'password' => 'required|min:3',
        ]);

        if (isset($request->username) && isset($request->password)) {
            $user = User::where('username', $request->username)->first();
            if ($user && Hash::check($request->password, $user->password)) {
                Auth::login($user);
                return redirect()->route('home')->with("berhasil", "berhasil");
            }
        }
        return redirect()->route("login")->with("gagal", "gagal");
    }
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route("login")->with("", "");
    }

    public function post_user(Request $request)
    {
        $data = Validator::make($request->all(), [
            "nama" => ["required", "string", "min:3"],
            "username" => ["required", "string", "min:3", "unique:users"],
            "nomor_telepon" => ["required", "numeric", "min:15"],
            "email" => ["required", "min:5", "unique:users"],
            "password" => ["required", "min:8"],
        ]);

        if ($data->fails()) {
            return redirect('/home')->withErrors($data)->withInput();
        }
        dd($data);
    }
}
