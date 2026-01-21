<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\ValidSession;

class ValidSessionChecker
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Jos käyttäjä ei ole kirjautunut, ohitetaan middleware
        if (!Auth::check()) {
            return $next($request);
        }

        // Hae nykyinen session ID
        $currentSessionId = session()->getId();

        // Tarkista, onko käyttäjällä voimassa oleva ValidSession
        $valid = ValidSession::where('user_id', Auth::id())
                             ->where('hash', $currentSessionId)
                             ->exists();

        // Jos ei ole validia sessionia, logout ja redirect
        if (!$valid) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect('/auth/login')->withErrors([
                'session' => 'Istuntosi ei ole enää voimassa. Kirjaudu uudelleen.'
            ]);
        }

        // Jos session on validi, jatketaan normaalisti
        return $next($request);
    }
}

