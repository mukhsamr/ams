<?php

namespace App\Http\Middleware;

use App\Models\Version;
use Closure;
use Illuminate\Http\Request;

class Identity
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
        session([
            'version' => Version::firstWhere('is_used', 1)
        ]);

        return $next($request);
    }
}
