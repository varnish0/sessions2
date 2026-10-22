<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    /**
     * Display the home page with the list of users.
     */
    public function index(): View
    {
        $users = User::latest()->get();

        return view('pages.home', [
            'users' => $users,
        ]);
    }
}
