<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\History;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index()
    {
        return view('pages.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $fieldType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $user = User::whereEncrypted($fieldType, $request->username)
            ->first();

        if (!empty($user) && Hash::check($request->password, $user->password)) {
            $isActive = $user->is_active == 1 ? true : false;
            if (!$isActive) {
                return to_route('login')->withInput()->with('msg', 'Akun anda telah dinonaktifkan! Silahkan hubungi Administrator.');
            }

            Auth::login($user, $request->has('remember'));

            $request->session()->regenerate();
            $user->update(['last_login' => now()]);

            History::makeHistory('Login.');

            return redirect()->intended('/');
        }

        return to_route('login')->withInput()->with(['msg' => 'Autentikasi tidak sesuai.']);
    }

    public function logout(Request $request)
    {
        History::makeHistory('Logout.');

        $this->do_logout($request);

        return to_route('dashboard');
    }

    public function do_logout($request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }
}
