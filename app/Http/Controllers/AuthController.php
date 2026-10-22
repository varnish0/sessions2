<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * Show the login page.
     */
    public function showLoginForm(): View
    {
        return view('pages.login');
    }

    /**
     * Handle user login.
     */
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        try {
            $user = User::where('email', $credentials['email'])
                ->orWhere('name', $credentials['email'])
                ->first();

            if (! $user || ! Hash::check($credentials['password'], $user->password)) {
                return redirect()->back()->with('error', 'Credenciales incorrectas.')->withInput();
            }

            $token = Str::random(60);

            session([
                'token' => $token,
                'name' => $user->name,
            ]);

            return redirect()->route('home')->with('success', 'Has iniciado sesión correctamente.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error al iniciar sesión: '.$e->getMessage())->withInput();
        }
    }

    /**
     * Handle user logout.
     */
    public function logout(Request $request): RedirectResponse
    {
        try {
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->with('success', 'Sesión cerrada correctamente.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error al cerrar sesión: '.$e->getMessage());
        }
    }
}
