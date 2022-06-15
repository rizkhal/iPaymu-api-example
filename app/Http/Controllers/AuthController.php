<?php

namespace App\Http\Controllers;

use Inertia\Response;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function create(): Response
    {
        return inertia('auth/login')->title(__('Login'));
    }

    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->route('product.index')->success(__('Successfully logged in'));
    }

    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('product.index')->success(__('Successfully logout'));
    }
}
