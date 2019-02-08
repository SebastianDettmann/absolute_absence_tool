<?php

namespace App\Http\Middleware;

use Closure;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class Absence
 * grand|deny Access for Absence Tool
 * @package App\Http\Middleware
 */
class Absence
{
    /**
     * @const the slug for the absence tool as parameter for $user->hasAccess(String $access_slug_title);
     */
    const ACCESS_SLUG = 'absolute_absence_tool';

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     * throws 404 if User don't have Access for Absence Tool
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = auth()->user();
        if ($user->hasAccess(self::ACCESS_SLUG) || $user->admin) {
            return $next($request);
        }

        throw new HttpException(404);
    }
}
