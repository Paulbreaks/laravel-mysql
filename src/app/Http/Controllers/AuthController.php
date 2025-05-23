<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Show the registration form (WEB).
     * If the user is already logged in, redirect to the home page.
     */
    public function showRegisterForm()
    {
        if (auth()->check()) {
            return redirect('/'); // Redirect if already logged in
        }
        return view('auth.register'); // Show registration form
    }

    /**
     * Register a new user (WEB).
     * After successful registration, the user is logged in automatically.
     */
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        return redirect('/')->with('success', __('messages.register_success', ['name' => $user->name]));
    }

    /**
     * Show the login form (WEB).
     * If the user is already logged in, redirect to the home page.
     */
    public function showLoginForm()
    {
        if (auth()->check()) {
            return redirect('/'); // Redirect if already logged in
        }
        return view('auth.login'); // Show login form
    }

    /**
     * Authenticate the user (WEB).
     * If credentials are correct, redirect to the home page.
     */
    public function login(LoginRequest $request)
    {
        if (Auth::attempt($request->validated())) {
            return redirect('/')->with('success', __('messages.login_success'));
        }

        return back()->withErrors(['email' => __('validation.auth_failed')])->withInput();
    }

    /**
     * Logout the user and redirect to the home page (WEB).
     */
    public function logout()
    {
        Auth::logout();
        return redirect('/')->with('success', __('messages.logout_success'));
    }
}
