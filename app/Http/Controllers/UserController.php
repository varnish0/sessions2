<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Show the form for creating a new user.
     */
    public function create(): View
    {
        return view('pages.create');
    }

    /**
     * Store a newly created user in storage and redirect to home.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        try {
            User::create($validated);

            return redirect()->route('home')->with('success', 'Usuario creado correctamente.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error al crear el usuario: '.$e->getMessage())->withInput();
        }
    }
}
