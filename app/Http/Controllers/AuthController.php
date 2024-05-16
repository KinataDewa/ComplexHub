<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Exceptions\HttpResponseException;

class AuthController extends Controller
{
    public function index()
    {
        // kita ambil data user lalu simpan pada variabel $user
        $user = Auth::user();

        // kondisi jika usernya ada
        if ($user) {
            // jika usernya memiliki roles
            if ($user->roles_id == '1') {
                return redirect()->intended('rt');
            }
            // jika usernya memiliki roles
            else if ($user->roles_id == '2') {
                return redirect()->intended('rw');
            } else if ($user->roles_id == '3') {
                return redirect()->intended('pd');
            }
        }
        return view('login');
    }

    public function proses_login(Request $request)
    {
        // kita buat validasi pada saat tombol login diklik
        // validasinya username & password wajib diisi
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        // ambil data request username & password saja
        $ambil = $request->only('email', 'password');
        //cek jika data username dan password valid (sesuai) dengan data
        if (Auth::attempt($ambil)) {

            // kalau berhasil simpan data usernya di variabel $user
            $user = Auth::user();

            // cek lagi jika level user admin maka arahkan ke halaman admin
            if ($user->role_id == '1') {
                return redirect()->intended('rt');
            }
            // tapi jika level usernya user biasa maka arahkan kehalaman user
            else if ($user->role_id == '2') {
                return redirect()->intended('rw');
            } else if ($user->role_id == '3') {
                return redirect()->intended('pd');
            }
            // jika belum ada role maka ke halaman /
            return redirect()->intended('/');
        }
        // jika tidak ada data user yang valid maka kembalikan lagi ke halaman login
        // pastikan kirim pesar error juga kalau login gagal yaa...
        return redirect('/')
            ->withInput()
            ->withErrors(['login_gagal' => 'Pastikan kembali username dan password yang dimasukkan sudah benar']);
    }


    public function register()
    {
        // tampilkan view register
        $id = role::select('id', 'role_name')->get();
        return view('register', ['id' => $id]);
    }

    // aksi form register
    public function proses_register(Request $request)
    {
        // Buat validasi
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role_name' => 'required|exists:roles,id',
        ]);

        // Jika validasi gagal, kembali ke halaman registrasi dengan pesan error
        if ($validator->fails()) {
            return redirect('/register')
                ->withErrors($validator)
                ->withInput();
        }

        // Hash password
        $password = Hash::make($request->password);

        // Buat user baru
        User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => $password,
            'role_id' => $request->input('role_name'),
        ]);

        // Redirect ke halaman login
        return redirect()->route('login');
    }


    public function logout(Request $request)
    {
        // logout itu harus menghapus sessionnya
        $request->session()->flush();

        // jalankan juga dungsi logout pada auth
        Auth::logout();
        // kembali ke halaman login
        return Redirect('login');
    }
}