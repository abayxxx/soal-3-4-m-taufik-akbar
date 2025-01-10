<?php

namespace App\Http\Controllers;

use App\Mail\LoginAttempt;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    //

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');


        if (auth()->attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('products.index');
        }

        $user = User::where('email', $request->email)->first();

        $login_attempt = cache()->get($user->email);

        if (!$login_attempt) cache()->put($user->email, 0);

        cache()->increment($request->email);

        if ($user) {

            if ($login_attempt >= 3) {
                //delete login attempts in cache
                cache()->forget($user->email);

                $password = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789'), 0, 6);
                //send email to user on job queue
                Mail::to($user->email)->queue(new LoginAttempt($password, $user->email, $user->name));
            }
        } else {
            return back()->withErrors([
                'email' => 'User tidak ditemukan',
            ]);
        }


        return back()->withErrors([
            'email' => 'Email atau password anda salah',
            'password' => 'Email atau password anda salah',
        ]);
    }


    public function logout(Request $request)
    {
        auth()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function dashboard()
    {
        return view('dashboard');
    }


    public function register(Request $request)
    {

        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|max:15',
            'password_confirmation' => 'required|same:password',
            'phone_number' => 'required|numeric',
        ]);

        DB::beginTransaction();

        try {

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'phone_number' => $request->phone_number,
            ]);

            DB::commit();

            return redirect('/login')->with('success', 'Registrasi berhasil, silahkan login');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->withErrors([
                'error' => 'Registrasi gagal, silahkan coba lagi',
            ]);
        }
    }
}
