<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{

    public function showRegisterForm()
    {
        return view('auth.register');
    }


    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);
        
        Session::put('user_id', $user->id);

        return redirect()->route('tasks.index')->with('success', 'Cont creat cu succes!');
    }


    public function showLoginForm()
    {
        return view('auth.login');
    }


    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            Session::put('user_id', Auth::id());

            return redirect()->intended(route('tasks.index'))->with('success', 'Autentificare reușită!');
        }

        return back()->withErrors([
            'email' => 'Credențialele furnizate nu corespund înregistrărilor noastre.',
        ])->onlyInput('email');
    }


    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        Session::forget('user_id');

        return redirect()->route('login')->with('success', 'Ai fost deconectat cu succes!');
    }
}