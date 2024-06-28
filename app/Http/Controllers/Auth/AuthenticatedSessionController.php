<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        if (Auth::user()->hasRole('practitioner')) {
            $user = Auth::user();
            $practitioner = $user->practitioners->first();
            if ($practitioner) {
                return redirect()->route('practitioners.show', $practitioner->slug)->with('success', 'Logged in successfully.');
            } else {
                Auth::logout();
                return back()->with('error', 'This user is not associated with any practitioner.');
            }
        }

        return redirect('/practitioners');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        //get user role
        $role = Auth::user()->roles->pluck('name')->first();

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if ($role == 'practitioner') {
            return redirect()->route('portal.index');
        }

        return redirect()->route('login');
    }
}
