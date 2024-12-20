<?php

namespace App\Http\Middleware;

use App\Helpers\ApiException;
use Illuminate\Http\Request;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    protected function redirectTo(Request $request): ?string
    {
        return $request->expectsJson() ? '/' : throw new ApiException('Unauthenticated.', [], 401);
    }

    /**
     * Handle an unauthenticated user.
     *
     * @param  Request  $request
     * @param  array  $guards
     * @return void
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    protected function unauthenticated($request, array $guards)
    {
        if (in_array('sanctum', $guards)) {
            throw new \App\Helpers\ApiException(
                'Unauthenticated.',
                [],
                401
            );
        }

        return parent::unauthenticated($request, $guards);
    }
}
