<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class XSSProtection
{
    protected $excepted = [
        '_token'
    ];

    public function handle(Request $request, Closure $next)
    {
        if (in_array($request->getMethod(), ['GET', 'POST', 'PATCH', 'PUT'])) {
            $htmlPurifier = new \HTMLPurifier();
            $inputs = $request->all();
            array_walk_recursive($inputs, function (&$input, $key) use ($htmlPurifier) {
                if (!$this->shouldPassThrough($key)) {
                    $input = $htmlPurifier->purify($input);
                }
            });
            $request->merge($inputs);
        }

        return $next($request);
    }

    protected function shouldPassThrough($key)
    {
        return in_array($key, $this->excepted);
    }
}
