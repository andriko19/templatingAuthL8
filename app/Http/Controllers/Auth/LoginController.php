<?php

namespace App\Http\Controllers\Auth;

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('page.auth.login');
    }

    public function authenticate(Request $request)
    {
        $messages = [
            'required' => 'Tidak boleh kosong',
            'min' => 'Password minimal 6 karakter',
            'max' => 'Attribute harus diisi maksimal :max karakter ya cuy!!!',
            'email' => 'Harus format email',
        ];

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
            'password' => 'required|min:6|max:255'
        ], $messages);

        // Cek jika validasi gagal
        if ($validator->fails()) {
            Session::flash('error', $validator->errors()->all());
            return back()->withInput(); // Kembali ke form dengan input yang sudah diisi
        } else {
            //jika lolos validasi
            $data = [
                'email' => $request->input('email'),
                'password' => $request->input('password'),
            ];

            if (Auth::Attempt($data)) {
                return redirect('dashboard');
            }else{
                Session::flash('error', ['Email atau Password Salah']);
                return back()->withInput(); // Kembali ke form dengan input yang sudah diisi
            }
        }

    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
