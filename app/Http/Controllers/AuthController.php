<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validated = $request->validate([
                'name'      => 'required',
                'email'     => 'required|email|unique:users,email',
                'password'  => 'regex:/[A-Z]/|regex:/[a-z]/|regex:/[0-9]/|regex:/[@$!%*?&]/',
            ],[
                'name.required'     => 'nama wajib diisi',

                'email.required'    => 'email wajib diisi',
                'email.email'       => 'email tidak valid',
                'email.unique'      => 'email sudah terdaftar',

                'password.required' => 'password wajid diisi',
                'password.min'      => 'password minimal 8 karakter',
                'password.regex'    => 'password harus terdiri dari huruf besar, huruf kecil, angka, dan karakter khusus',
            ]);

            $user = User::create([
                'name'      =>$validated['name'],
                'email'     =>$validated['email'],
                'password'  => Hash::make($validated['password'])

            ]);

            if (!$user){
                return response()->json([
                    'status'    => 'error',
                    'message'   =>'gagal membuat akun',
                    'data'      =>[]
                ], 400);
            }

            return response()->json([
                'status'    => 'succes',
                'message'   =>'pendaftaran berhasil',
                'data'      =>$user,
            ],200 );
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ], [
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Email tidak valid',
            'password.required' => 'Password wajib diisi',
        ]);

        $user = User::where('email', $validated['email'])->first();

        if (!$user || !Hash::check($validated['password'], $user->password)) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Email atau password salah',
                'data' => []
            ], 401);
        }

        $token = $user->createToken('API Token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'Login berhasil',
            'token' => $token,
            'data' => $user,
        ], 200)->withCookie(cookie('token', $token, 60, null, null, true, false));
    }


    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Logout berhasil',
            'data' => []
        ], 200);
    }

    public function profile(Request $request)
    {
        return response()->json([
        'status'    =>'succes',
        'message'   =>'data user ditemukan',
        'data'      =>$request->user(),
    ], 200);

    }

    public function index()
    {
        return view('login');
    }

    public function registerpage()
    {
        return view('register');
    }
    
}
