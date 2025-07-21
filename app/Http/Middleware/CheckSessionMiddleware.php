<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\LogUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class CheckSessionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if ($user && $user->session_id !== session()->getId()) {
            if ($user->role == 'admin') {

                $log = LogUser::where('user_id', auth()->user()->id)->first();
                if ($log) {
                    $log->is_active = false;
                    $log->update();
                }

                Auth::logout();

                Session::flush();

                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect()->route('login')->with('error', 'You have been logged out from another device.');
            }
        }

        return $next($request);
    }
}
