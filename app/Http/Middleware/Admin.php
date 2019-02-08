<?php

namespace App\Http\Middleware;

use Closure;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class Admin
 * @package App\Http\Middleware
 */
class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     * if not admin returns 404
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(auth()->user()->admin) {
            return $next($request);
        }

        throw new HttpException(404);
    }
}
