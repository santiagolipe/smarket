<?php

namespace App\Http\Middleware;

use Closure;
use App\Lojista;

class LojistaMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->user() && $request->user()->type != Lojista::type) {
            return redirect()->route('index');
        }

        return $next($request);
    }
}
