<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CheckSession
{
    public function handle($request, Closure $next)
    {
        if (Auth::guard('student')->check()) {
            $session_id = Session::getId();
            $user = Auth::user();

            // Check if the user's session ID is stored in the database and matches the current session ID
            if ($user->session_id !== $session_id) {
                // Log out the user if the session ID does not match
                Auth::logout();
                Session::flush();
                return redirect('/login')->withErrors('Your session has been logged out from another location.');
            }
        }

        return $next($request);
    }
}
