<?php

namespace App\Http\Controllers\Auth;

use Validator;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class RegisterController extends Controller
{
    public function index()
    {
        return view('template.auth.register');
    }

    public function actionRegister(Request $request)
    {
        $messages = [
            'required' => 'Tidak boleh kosong',
            'min' => 'Password minimal 6 karakter',
            'max' => 'Attribute harus diisi maksimal :max karakter ya cuy!!!',
            'same' => 'Password harus sama',
            'required_with' => 'Password harus sama',
            'email' => 'Harus format email',
        ];

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'role' => 'required|not_in:0',
            'email' => 'required|email', // Tambahkan 'required'
            'password' => 'required|min:6|required_with:confirm_password|same:confirm_password',
            'confirm_password' => 'required|min:6'
        ], $messages);

        // Cek jika validasi gagal
        if ($validator->fails()) {
            Session::flash('error', $validator->errors()->all());
            return back()->withInput(); // Kembali ke form dengan input yang sudah diisi
        }

        // Insert ke database
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'active' => 1
        ]);

        Session::flash('message', 'Register Berhasil. Akun Anda sudah Aktif, silahkan Login menggunakan email dan password.');
        return redirect('login');
    }

}
