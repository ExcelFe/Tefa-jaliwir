<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AkunMurid;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Cari data murid berdasarkan email
        $user = AkunMurid::where('email', $request->email)->first();

        // Cek apakah user ditemukan dan password plain text sesuai
        if ($user && $user->password === $request->password) {
            Auth::guard('murid')->login($user);
            $request->session()->regenerate();

            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::guard('murid')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}