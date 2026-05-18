<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\ChecksUserStatus;

class CheckUserStatus
{
    use ChecksUserStatus;

    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            // Mengecek apakah user masih aktif
            if (!$this->isUserActive($user)) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                
                // Redirect ke login dengan pesan error sesuai tipe user
                return redirect('/login')->withErrors([
                    'email' => $this->getInactiveMessage($user)
                ]);
            }
        }

        return $next($request);
    }
}