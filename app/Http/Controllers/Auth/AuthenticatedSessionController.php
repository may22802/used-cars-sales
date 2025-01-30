<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        $user = User::where('email', $request->email)->first();

        if ($user && $user->status === 'deactivated') {
            return redirect()->route('login')
                ->with('status', 'deactivated');
        }

        $request->authenticate();

        $request->session()->regenerate();

        if (Auth::user()->role === 'admin') {
            return redirect()->intended(route('admin.dashboard', absolute: false));
        }

        return redirect()->intended(route('user.dashboard', absolute: false));
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
