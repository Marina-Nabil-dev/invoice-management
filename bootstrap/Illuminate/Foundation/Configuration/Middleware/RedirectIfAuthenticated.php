<?php

namespace Illuminate\Foundation\Configuration\Middleware;

use App\Helper\ResponseHandler;
use App\Http\Resources\AuthenticateUserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    public function handle(Request $request, \Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                if ($guard == 'sanctum') {
                    request()->session()->regenerate();

                    return \App\Helpers\ResponseHandler::success('Already LoggedIn', new AuthenticateUserResource(auth()->user()));
                }

                return redirect('/');
            }
        }

        return $next($request);
    }
}
